<?php $__env->startSection('content'); ?>
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="welcome-text">
            <h1>ระบบติดตามแผนงานหอสมุด</h1>
            <p>ยินดีต้อนรับ,
                <?php echo e(session('employee') ? session('employee')->Firstname : 'ผู้ใช้งาน'); ?>

                <?php echo e(session('employee') ? session('employee')->Lastname : ''); ?><br>
                <?php echo e(session('employee') ? session('employee')->Position_Name : ''); ?>

            </p>
        </div>
        <div class="user-actions">
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-logout">ออกจากระบบ</button>
            </form>
        </div>
    </div>

    <?php
    $employee = session('employee');
    $hasPermission = $employee && ($employee->IsManager == 'Y' ||
    $employee->IsDirector == 'Y' ||
    $employee->IsFinance == 'Y' ||
    $employee->IsResponsible == 'Y' ||
    $employee->IsAdmin == 'Y' ||
    $employee->IsGeneralEmployees == 'Y');
    ?>

    <?php if($hasPermission): ?>
    <!-- Dashboard Overview Section -->
    <div class="dashboard-overview">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="stat-info">
                <h3>โครงการทั้งหมด</h3>
                <p class="stat-value"><?php echo e($totalProjects ?? 24); ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-info">
                <h3>โครงการที่กำลังดำเนินการ</h3>
                <p class="stat-value"><?php echo e($inProgressProjects ?? 12); ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>โครงการที่เสร็จสิ้น</h3>
                <p class="stat-value"><?php echo e($completedProjects ?? 8); ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>โครงการที่ล่าช้า</h3>
                <p class="stat-value"><?php echo e($delayedProjects ?? 4); ?></p>
            </div>
        </div>
    </div>

    <!-- Recent Projects Section -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>โครงการล่าสุด</h2>
            <button class="btn btn-action" id="addProjectBtn">เพิ่มโครงการใหม่</button>
        </div>
        <div class="projects-table-container">
            <table class="projects-table">
                <thead>
                    <tr>
                        <th>ชื่อโครงการ</th>
                        <th>ผู้รับผิดชอบ</th>
                        <th>วันที่เริ่มต้น</th>
                        <th>กำหนดเสร็จ</th>
                        <th>สถานะ</th>
                        <th>การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recentProjects ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($project->name); ?></td>
                        <td><?php echo e($project->manager); ?></td>
                        <td><?php echo e($project->start_date); ?></td>
                        <td><?php echo e($project->end_date); ?></td>
                        <td><span class="status-badge status-<?php echo e($project->status_class); ?>"><?php echo e($project->status); ?></span>
                        </td>
                        <td>
                            <button class="btn-icon view-project" data-id="<?php echo e($project->id); ?>"><i
                                    class="fas fa-eye"></i></button>
                            <button class="btn-icon edit-project" data-id="<?php echo e($project->id); ?>"><i
                                    class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <!-- Fallback demo data if no projects -->
                    <?php if(empty($recentProjects)): ?>
                    <tr>
                        <td>โครงการปรับปรุงระบบสืบค้นหนังสือ</td>
                        <td>สมชาย ใจดี</td>
                        <td>01/02/2025</td>
                        <td>15/04/2025</td>
                        <td><span class="status-badge status-progress">กำลังดำเนินการ</span></td>
                        <td>
                            <button class="btn-icon view-project" data-id="1"><i class="fas fa-eye"></i></button>
                            <button class="btn-icon edit-project" data-id="1"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>โครงการส่งเสริมการอ่านประจำปี</td>
                        <td>สมศรี รักการอ่าน</td>
                        <td>15/01/2025</td>
                        <td>15/03/2025</td>
                        <td><span class="status-badge status-delay">ล่าช้า</span></td>
                        <td>
                            <button class="btn-icon view-project" data-id="2"><i class="fas fa-eye"></i></button>
                            <button class="btn-icon edit-project" data-id="2"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>โครงการจัดเก็บข้อมูลดิจิทัล</td>
                        <td>วิชัย เทคโนโลยี</td>
                        <td>10/01/2025</td>
                        <td>10/02/2025</td>
                        <td><span class="status-badge status-complete">เสร็จสิ้น</span></td>
                        <td>
                            <button class="btn-icon view-project" data-id="3"><i class="fas fa-eye"></i></button>
                            <button class="btn-icon edit-project" data-id="3"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="section-footer">
            <a class="view-all-link">ดูโครงการทั้งหมด <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <!-- Upcoming Deadlines Section -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>กำหนดการที่ใกล้ถึง</h2>
        </div>
        <div class="deadlines-container">
            <?php $__currentLoopData = $upcomingDeadlines ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deadline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="deadline-card">
                <div class="deadline-date"><?php echo e($deadline->due_date); ?></div>
                <div class="deadline-details">
                    <h4><?php echo e($deadline->name); ?></h4>
                    <p><?php echo e($deadline->description); ?></p>
                </div>
                <div class="deadline-status">
                    <span class="days-left"><?php echo e($deadline->days_left); ?> วัน</span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- Fallback demo data if no deadlines -->
            <?php if(empty($upcomingDeadlines)): ?>
            <div class="deadline-card">
                <div class="deadline-date">01/03/2025</div>
                <div class="deadline-details">
                    <h4>ส่งรายงานความคืบหน้าประจำเดือน</h4>
                    <p>โครงการปรับปรุงระบบสืบค้นหนังสือ</p>
                </div>
                <div class="deadline-status">
                    <span class="days-left">2 วัน</span>
                </div>
            </div>
            <div class="deadline-card">
                <div class="deadline-date">05/03/2025</div>
                <div class="deadline-details">
                    <h4>ประชุมคณะกรรมการบริหารหอสมุด</h4>
                    <p>นำเสนอความคืบหน้าโครงการประจำไตรมาส</p>
                </div>
                <div class="deadline-status">
                    <span class="days-left">6 วัน</span>
                </div>
            </div>
            <div class="deadline-card">
                <div class="deadline-date">15/03/2025</div>
                <div class="deadline-details">
                    <h4>กำหนดส่งสรุปผลการดำเนินงาน</h4>
                    <p>โครงการส่งเสริมการอ่านประจำปี</p>
                </div>
                <div class="deadline-status">
                    <span class="days-left">16 วัน</span>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <!-- No Permissions Message -->
    <div class="no-permission-container">
        <!-- <div class="no-permission-content">
            <div class="no-permission-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h2>ไม่มีสิทธิ์เข้าถึง</h2>
            <p>คุณไม่มีสิทธิ์เข้าถึงข้อมูลในระบบนี้</p>
            <p>กรุณาติดต่อผู้ดูแลระบบเพื่อขอสิทธิ์ในการเข้าถึงข้อมูล</p>
            <p class="contact-admin">ติดต่อผู้ดูแลระบบ: <a href="mailto:admin@example.com">admin@example.com</a></p>
        </div> -->
    </div>
    <?php endif; ?>
</div>

<!-- Add/Edit Project Modal -->
<?php if($hasPermission): ?>
<div id="projectModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">จัดการโครงการ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="projectForm">
                    <div class="form-group">
                        <label for="projectName">ชื่อโครงการ</label>
                        <input type="text" class="form-control" id="projectName" required>
                    </div>
                    <div class="form-group">
                        <label for="projectManager">ผู้รับผิดชอบ</label>
                        <input type="text" class="form-control" id="projectManager" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="startDate">วันที่เริ่มต้น</label>
                            <input type="date" class="form-control" id="startDate" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="endDate">กำหนดเสร็จ</label>
                            <input type="date" class="form-control" id="endDate" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="projectStatus">สถานะ</label>
                        <select class="form-control" id="projectStatus">
                            <option value="planning">วางแผน</option>
                            <option value="progress">กำลังดำเนินการ</option>
                            <option value="delay">ล่าช้า</option>
                            <option value="complete">เสร็จสิ้น</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="projectDescription">รายละเอียด</label>
                        <textarea class="form-control" id="projectDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="saveProject">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- View Project Modal -->
<div id="viewProjectModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProjectTitle">รายละเอียดโครงการ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="project-details">
                    <div class="project-info">
                        <div class="info-group">
                            <label>ผู้รับผิดชอบ:</label>
                            <p id="viewProjectManager">-</p>
                        </div>
                        <div class="info-group">
                            <label>วันที่เริ่มต้น:</label>
                            <p id="viewProjectStart">-</p>
                        </div>
                        <div class="info-group">
                            <label>กำหนดเสร็จ:</label>
                            <p id="viewProjectEnd">-</p>
                        </div>
                        <div class="info-group">
                            <label>สถานะ:</label>
                            <p id="viewProjectStatus">-</p>
                        </div>
                    </div>
                    <div class="project-description">
                        <h6>รายละเอียด</h6>
                        <p id="viewProjectDescription">-</p>
                    </div>

                    <div class="project-progress">
                        <h6>ความคืบหน้า</h6>
                        <div class="progress">
                            <div class="progress-bar" id="viewProjectProgressBar" role="progressbar" style="width: 75%;"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                        </div>
                    </div>

                    <div class="project-tasks">
                        <h6>กิจกรรมในโครงการ</h6>
                        <ul class="task-list" id="viewProjectTasks">
                            <li>
                                <span class="task-check completed"><i class="fas fa-check"></i></span>
                                <span class="task-name">สำรวจความต้องการผู้ใช้</span>
                                <span class="task-date">01/02/2025</span>
                            </li>
                            <li>
                                <span class="task-check completed"><i class="fas fa-check"></i></span>
                                <span class="task-name">ออกแบบระบบใหม่</span>
                                <span class="task-date">15/02/2025</span>
                            </li>
                            <li>
                                <span class="task-check in-progress"><i class="fas fa-spinner"></i></span>
                                <span class="task-name">พัฒนาระบบ</span>
                                <span class="task-date">21/03/2025</span>
                            </li>
                            <li>
                                <span class="task-check"><i class="fas fa-circle"></i></span>
                                <span class="task-name">ทดสอบระบบ</span>
                                <span class="task-date">01/04/2025</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="editProjectBtn">แก้ไข</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Include jQuery, Bootstrap, and Font Awesome -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
:root {
    --primary-gradient-start: #8729DA;
    --primary-gradient-end: #AC2BDD;
    --primary-color: #9A2DDB;
    --secondary-color: #7620C0;
    --accent-color: #D442F5;
    --text-light: #FFFFFF;
    --text-dark: #333333;
    --bg-light: #F8F9FA;
    --bg-dark: #212529;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --info-color: #17a2b8;
}

body {
    background-color: var(--bg-light);
    color: var(--text-dark);
    font-family: 'Sarabun', sans-serif;
}

.dashboard-container {
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.dashboard-header {
    background: linear-gradient(180deg, var(--primary-gradient-start) 0%, var(--primary-gradient-end) 100%);
    color: var(--text-light);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.welcome-text h1 {
    font-size: 24px;
    margin-bottom: 5px;
}

.welcome-text p {
    margin-bottom: 0;
    font-size: 16px;
}

.system-message {
    font-style: italic;
    opacity: 0.8;
}

.user-actions {
    display: flex;
    align-items: center;
}

.btn-logout {
    background-color: rgba(255, 255, 255, 0.2);
    color: var(--text-light);
    border: 1px solid rgba(255, 255, 255, 0.4);
    padding: 8px 16px;
    border-radius: 5px;
    transition: all 0.3s;
}

.btn-logout:hover {
    background-color: rgba(255, 255, 255, 0.3);
}

.dashboard-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    background: linear-gradient(180deg, var(--primary-gradient-start) 0%, var(--primary-gradient-end) 100%);
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 20px;
}

.stat-info h3 {
    font-size: 14px;
    margin-bottom: 5px;
    color: var(--text-dark);
}

.stat-value {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 0;
    color: var(--primary-color);
}

.dashboard-section {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-header h2 {
    font-size: 18px;
    margin-bottom: 0;
}

.btn-action {
    background: linear-gradient(180deg, var(--primary-gradient-start) 0%, var(--primary-gradient-end) 100%);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    transition: all 0.3s;
}

.btn-action:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

.projects-table-container {
    overflow-x: auto;
}

.projects-table {
    width: 100%;
    border-collapse: collapse;
}

.projects-table th,
.projects-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.projects-table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.projects-table tr:hover {
    background-color: #f8f9fa;
}

.status-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.status-planning {
    background-color: #e9ecef;
    color: #495057;
}

.status-progress {
    background-color: #cff4fc;
    color: #055160;
}

.status-delay {
    background-color: #fff3cd;
    color: #664d03;
}

.status-complete {
    background-color: #d1e7dd;
    color: #0f5132;
}

.btn-icon {
    background: none;
    border: none;
    color: var(--primary-color);
    cursor: pointer;
    transition: all 0.3s;
    padding: 5px;
    margin-right: 5px;
}

.btn-icon:hover {
    color: var(--accent-color);
    transform: scale(1.1);
}

.section-footer {
    margin-top: 15px;
    text-align: right;
}

.view-all-link {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s;
}

.view-all-link:hover {
    color: var(--accent-color);
    text-decoration: none;
}

.deadlines-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 15px;
}

.deadline-card {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 15px;
    display: flex;
    align-items: center;
    transition: all 0.3s;
}

.deadline-card:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-3px);
}

.deadline-date {
    background: linear-gradient(180deg, var(--primary-gradient-start) 0%, var(--primary-gradient-end) 100%);
    color: white;
    padding: 10px;
    border-radius: 8px;
    text-align: center;
    font-weight: bold;
    min-width: 80px;
    margin-right: 15px;
}

.deadline-details {
    flex-grow: 1;
}

.deadline-details h4 {
    font-size: 14px;
    margin-bottom: 5px;
}

.deadline-details p {
    font-size: 12px;
    margin-bottom: 0;
    color: #6c757d;
}

.deadline-status {
    margin-left: 10px;
}

.days-left {
    background-color: #f8f9fa;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 12px;
    color: var(--primary-color);
    white-space: nowrap;
}

.modal-content {
    border-radius: 10px;
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(180deg, var(--primary-gradient-start) 0%, var(--primary-gradient-end) 100%);
    color: white;
    border-bottom: none;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
}

.modal-footer {
    border-top: 1px solid #eee;
}

.project-details {
    padding: 10px;
}

.project-info {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.info-group label {
    font-weight: bold;
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 5px;
    display: block;
}

.info-group p {
    margin-bottom: 0;
    font-size: 16px;
}

.project-description,
.project-progress,
.project-tasks {
    margin-bottom: 20px;
}

.project-description h6,
.project-progress h6,
.project-tasks h6 {
    font-weight: bold;
    margin-bottom: 10px;
    color: var(--primary-color);
}

.progress {
    height: 15px;
    border-radius: 8px;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(90deg, var(--primary-gradient-start) 0%, var(--primary-gradient-end) 100%);
}

.task-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.task-list li {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
}

.task-check {
    margin-right: 10px;
    width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 12px;
}

.task-check.completed {
    background-color: var(--success-color);
    color: white;
}

.task-check.in-progress {
    background-color: var(--info-color);
    color: white;
}

.task-name {
    flex-grow: 1;
}

.task-date {
    color: #6c757d;
    font-size: 12px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .user-actions {
        margin-top: 15px;
        align-self: flex-end;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .section-header .btn-action {
        margin-top: 10px;
    }

    .projects-table th,
    .projects-table td {
        padding: 8px 10px;
    }
}
</style>

<script>
$(document).ready(function() {
    // Show Project Modal
    $('#addProjectBtn').click(function() {
        $('#projectForm')[0].reset();
        $('#projectModal .modal-title').text('เพิ่มโครงการใหม่');
        $('#projectModal').modal('show');
    });

    // View Project Details
    $('.view-project').click(function() {
        var projectId = $(this).data('id');
        // In a real application, you would fetch project details from the server
        // For this demo, we'll use placeholder data
        $('#viewProjectTitle').text('รายละเอียดโครงการ');

        // Set sample data based on projectId
        if (projectId == 1) {
            $('#viewProjectManager').text('สมชาย ใจดี');
            $('#viewProjectStart').text('01/02/2025');
            $('#viewProjectEnd').text('15/04/2025');
            $('#viewProjectStatus').html(
                '<span class="status-badge status-progress">กำลังดำเนินการ</span>');
            $('#viewProjectDescription').text(
                'โครงการปรับปรุงระบบสืบค้นหนังสือเพื่อให้ผู้ใช้งานสามารถค้นหาหนังสือได้อย่างมีประสิทธิภาพมากขึ้น รองรับการค้นหาด้วยคีย์เวิร์ดที่หลากหลาย'
            );
            $('#viewProjectProgressBar').css('width', '50%').text('50%');
        } else if (projectId == 2) {
            $('#viewProjectManager').text('สมศรี รักการอ่าน');
            $('#viewProjectStart').text('15/01/2025');
            $('#viewProjectEnd').text('15/03/2025');
            $('#viewProjectStatus').html('<span class="status-badge status-delay">ล่าช้า</span>');
            $('#viewProjectDescription').text(
                'โครงการส่งเสริมการอ่านประจำปีเพื่อกระตุ้นการอ่านในชุมชน จัดกิจกรรมส่งเสริมการอ่านและจัดหนังสือเข้าระบบหอสมุดอย่างต่อเนื่อง'
            );
            $('#viewProjectProgressBar').css('width', '70%').text('70%');
        } else if (projectId == 3) {
            $('#viewProjectManager').text('วิชัย เทคโนโลยี');
            $('#viewProjectStart').text('10/01/2025');
            $('#viewProjectEnd').text('10/02/2025');
            $('#viewProjectStatus').html('<span class="status-badge status-complete">เสร็จสิ้น</span>');
            $('#viewProjectDescription').text(
                'โครงการจัดเก็บข้อมูลดิจิทัลแปลงข้อมูลจากระบบเก่าเข้าสู่ระบบใหม่ที่รองรับเทคโนโลยีสมัยใหม่ ทำให้การจัดเก็บและการเข้าถึงข้อมูลเป็นไปอย่างมีประสิทธิภาพ'
            );
            $('#viewProjectProgressBar').css('width', '100%').text('100%');
        }

        $('#viewProjectModal').modal('show');
    });

    // Edit Project from View Modal
    $('#editProjectBtn').click(function() {
        $('#viewProjectModal').modal('hide');
        $('#projectModal .modal-title').text('แก้ไขโครงการ');

        // Populate form with current data
        $('#projectName').val($('#viewProjectTitle').text());
        $('#projectManager').val($('#viewProjectManager').text());
        $('#projectDescription').val($('#viewProjectDescription').text());

        // In a real application, you would format dates properly
        $('#startDate').val('2025-02-01');
        $('#endDate').val('2025-04-15');

        $('#projectModal').modal('show');
    });

    // Edit Project directly from list
    $('.edit-project').click(function() {
        var projectId = $(this).data('id');
        $('#projectModal .modal-title').text('แก้ไขโครงการ');

        // In a real application, you would fetch project details from the server
        // For this demo, we'll use placeholder data based on projectId
        if (projectId == 1) {
            $('#projectName').val('โครงการปรับปรุงระบบสืบค้นหนังสือ');
            $('#projectManager').val('สมชาย ใจดี');
            $('#startDate').val('2025-02-01');
            $('#endDate').val('2025-04-15');
            $('#projectStatus').val('progress');
            $('#projectDescription').val(
                'โครงการปรับปรุงระบบสืบค้นหนังสือเพื่อให้ผู้ใช้งานสามารถค้นหาหนังสือได้อย่างมีประสิทธิภาพมากขึ้น รองรับการค้นหาด้วยคีย์เวิร์ดที่หลากหลาย'
            );
        } else if (projectId == 2) {
            $('#projectName').val('โครงการส่งเสริมการอ่านประจำปี');
            $('#projectManager').val('สมศรี รักการอ่าน');
            $('#startDate').val('2025-01-15');
            $('#endDate').val('2025-03-15');
            $('#projectStatus').val('delay');
            $('#projectDescription').val(
                'โครงการส่งเสริมการอ่านประจำปีเพื่อกระตุ้นการอ่านในชุมชน จัดกิจกรรมส่งเสริมการอ่านและจัดหนังสือเข้าระบบหอสมุดอย่างต่อเนื่อง'
            );
        } else if (projectId == 3) {
            $('#projectName').val('โครงการจัดเก็บข้อมูลดิจิทัล');
            $('#projectManager').val('วิชัย เทคโนโลยี');
            $('#startDate').val('2025-01-10');
            $('#endDate').val('2025-02-10');
            $('#projectStatus').val('complete');
            $('#projectDescription').val(
                'โครงการจัดเก็บข้อมูลดิจิทัลแปลงข้อมูลจากระบบเก่าเข้าสู่ระบบใหม่ที่รองรับเทคโนโลยีสมัยใหม่ ทำให้การจัดเก็บและการเข้าถึงข้อมูลเป็นไปอย่างมีประสิทธิภาพ'
            );
        }

        $('#projectModal').modal('show');
    });

    // Save Project (Mock Function)
    $('#saveProject').click(function() {
        // In a real application, you would send the form data to the server via AJAX
        // For this demo, we'll just display a success message and close the modal
        alert('บันทึกข้อมูลโครงการเรียบร้อยแล้ว');
        $('#projectModal').modal('hide');

        // Optionally, refresh the page or update the table with the new data
    });

    // Enable dynamic behavior for all table rows
    $('.projects-table tbody tr').click(function(e) {
        // Ignore clicks on buttons
        if (!$(e.target).closest('button').length) {
            $(this).find('.view-project').click();
        }
    }).css('cursor', 'pointer');

    // Initialize Bootstrap tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/dashboard.blade.php ENDPATH**/ ?>