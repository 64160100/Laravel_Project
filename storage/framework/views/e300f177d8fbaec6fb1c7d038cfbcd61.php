<?php $__env->startSection('content'); ?>
<div class="tracking-container">
    <div class="header">
        <h1>
            ติดตามสถานะโครงการ
        </h1>
    </div>

    <div class="content-box">
        <div class="all-budget">
            <div class="budget-stats">
                <div class="budget-stat">
                    <div class="stat-label">โครงการทั้งหมด</div>
                    <div class="stat-value"><?php echo e(count($projects)); ?></div>
                </div>
            </div>
        </div>

        <div class="content-box-list">
            <h4>รายการโครงการ</h4>
            
            <?php if(count($projects) > 0): ?>
                <div class="projects-list">
                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="project-row">
                        <div class="project-content">
                            <div class="project-header">
                                <h3 class="project-title"><?php echo e($project->Name_Project); ?></h3>
                                <div class="status-badge"><?php echo e($project->status); ?></div>
                            </div>
                            
                            <div class="project-info">
                                <div class="info-item">
                                    <i class='bx bx-calendar'></i>
                                    <div>
                                        <div class="info-label">วันที่เริ่ม</div>
                                        <div class="info-value"><?php echo e($project->formattedFirstTime); ?></div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class='bx bx-user'></i>
                                    <div>
                                        <div class="info-label">ผู้รับผิดชอบ</div>
                                        <div class="info-value"><?php echo e($project->employeeName); ?></div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class='bx bx-money'></i>
                                    <div>
                                        <div class="info-label">งบประมาณ</div>
                                        <div class="info-value"><?php echo e($project->budget); ?> บาท</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="progress-section">
                                <div class="progress-header">
                                    <span>ความคืบหน้า</span>
                                    <span class="progress-percent"><?php echo e(round(($project->Count_Steps / 9) * 100)); ?>%</span>
                                </div>
                                <div class="progress-track">
                                    <div class="progress-fill" style="width: <?php echo e(($project->Count_Steps / 9) * 100); ?>%;"></div>
                                </div>
                            </div>
                            
                            <div class="project-footer">
                                <div class="current-status">
                                    <i class='bx bx-info-circle'></i>
                                    <span>สถานะปัจจุบัน: <?php echo e($project->current_status); ?></span>
                                </div>
                                <a href="<?php echo e(route('project.details', ['Id_Project' => $project->Id_Project])); ?>" class="btn-edit">
                                    รายละเอียด
                                    <i class='bx bx-right-arrow-alt'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="no-data">
                    <p>ไม่พบข้อมูลโครงการ</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .tracking-container {
        padding: 20px;
        font-family: 'Kanit', 'Sarabun', sans-serif;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header h1 {
        color: #333;
        margin: 0;
        font-size: 24px;
        display: flex;
        align-items: center;
    }

    .back-button {
        color: #333;
        text-decoration: none;
        margin-right: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .back-button i {
        font-size: 24px;
    }

    .content-box {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .all-budget {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        padding: 20px;
        color: white;
        display: flex;
        justify-content: space-between;
    }

    .budget-stats {
        display: flex;
        gap: 20px;
    }

    .budget-stat {
        text-align: center;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 10px 20px;
        border-radius: 8px;
    }

    .stat-label {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 600;
    }

    .content-box-list {
        padding: 20px;
    }

    .content-box-list h4 {
        margin-bottom: 15px;
        color: #333;
    }

    .projects-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .project-row {
        background-color: #f9f9f9;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s;
        border: 1px solid #eee;
    }

    .project-row:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .project-content {
        padding: 15px;
    }

    .project-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .project-title {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .status-badge {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }

    .project-info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 15px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-item i {
        color: #8729DA;
        font-size: 18px;
    }

    .info-label {
        font-size: 12px;
        color: #666;
    }

    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #333;
    }

    .progress-section {
        margin-bottom: 15px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .progress-percent {
        font-weight: 600;
        color: #8729DA;
    }

    .progress-track {
        height: 8px;
        background-color: #e0e0e0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        border-radius: 4px;
        transition: width 0.8s ease-in-out;
    }

    .project-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .current-status {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
        color: #666;
    }

    .current-status i {
        color: #8729DA;
    }

    .btn-edit {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
    }

    .btn-edit:hover {
        opacity: 0.9;
        color: white;
        text-decoration: none;
    }

    .no-data {
        text-align: center;
        padding: 30px;
        color: #777;
    }

    @media (max-width: 768px) {
        .project-info {
            flex-direction: column;
            gap: 10px;
        }
        
        .project-header, .project-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .project-footer {
            align-items: stretch;
        }
        
        .btn-edit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars on load
    const progressBars = document.querySelectorAll('.progress-fill');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 300);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/status/statusTracking.blade.php ENDPATH**/ ?>