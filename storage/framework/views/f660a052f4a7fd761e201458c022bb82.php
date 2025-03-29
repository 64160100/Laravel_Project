<?php
use Carbon\Carbon;
Carbon::setLocale('th');
?>



<head>
    <link rel="stylesheet" href="<?php echo e(asset('css/proposeProject.css')); ?>">
    <style>
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url('<?php echo e(storage_path('fonts/THSarabunNew.ttf')); ?>') format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url('<?php echo e(storage_path('fonts/THSarabunNew Bold.ttf')); ?>') format('truetype');
    }

    .project-status-badge {
        margin-left: 10px;
    }

    .project-status-badge .badge {
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 4px;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-info {
        background-color: #17a2b8;
        color: #fff;
    }

    .badge-primary {
        background-color: #007bff;
        color: #fff;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
    }

    .badge-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .badge-orange {
        background-color: #fd7e14;
        color: #fff;
    }
    </style>
</head>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>เสนอโครงการเพื่อพิจารณา</h1>

    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($project->Count_Steps !== 0): ?>
    <div class="outer-container">
        <div class="container">
            <div class="header">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="project-title"><?php echo e($project->Name_Project); ?></div>
                        <div class="project-subtitle">
                            <?php echo e($project->departmentName ?? 'ยังไม่มีผู้รับผิดชอบโครงการ'); ?>

                        </div>
                    </div>
                    <div class="project-status-badge">
                        <?php
                        $statusText = '';
                        $statusClass = '';

                        if ($project->Count_Steps === 0) {
                        $statusText = 'รอการเสนอ';
                        $statusClass = 'badge-warning';
                        } elseif ($project->Count_Steps === 1) {
                        $statusText = 'รอการพิจารณาจากผู้อำนวยการ';
                        $statusClass = 'badge-info';
                        } elseif ($project->Count_Steps === 2) {
                        if ($project->approvals->first()->Status === 'I') {
                        $statusText = 'รอการเสนอโครงการ';
                        } elseif ($project->approvals->first()->Status === 'Y') {
                        $statusText = 'รอกรอกข้อมูล';
                        }
                        $statusClass = 'badge-orange';
                        } elseif ($project->Count_Steps === 3) {
                        $statusText = 'รอพิจารณางบประมาณ';
                        $statusClass = 'badge-info';
                        } elseif ($project->Count_Steps === 4) {
                        $statusText = 'รอพิจารณาจากหัวหน้าฝ่าย';
                        $statusClass = 'badge-info';
                        } elseif ($project->Count_Steps === 5) {
                        $statusText = 'รอการพิจารณาจากผู้อำนวยการ';
                        $statusClass = 'badge-info';
                        } elseif ($project->Count_Steps === 6) {
                        $statusText = 'อยู่ระหว่างดำเนินการ';
                        $statusClass = 'badge-orange';
                        } elseif ($project->Count_Steps === 7) {
                        $statusText = 'รอพิจารณาจากหัวหน้าฝ่าย';
                        $statusClass = 'badge-info';
                        } elseif ($project->Count_Steps === 8) {
                        $statusText = 'รอการพิจารณาจากผู้อำนวยการ';
                        $statusClass = 'badge-info';
                        } elseif ($project->Count_Steps === 9) {
                        $statusText = 'เสร็จสิ้น';
                        $statusClass = 'badge-success';
                        } elseif ($project->Count_Steps === 11) {
                        $statusText = 'ล่าช้า';
                        $statusClass = 'badge-danger';
                        }

                        if ($project->approvals->isNotEmpty() && $project->approvals->first()->Status === 'N') {
                        $statusText = 'ไม่อนุมัติ';
                        $statusClass = 'badge-danger';
                        }
                        ?>
                        <span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusText); ?></span>
                    </div>
                </div>
                <div class="project-info">
                    <div class="info-item">
                        <div class="info-top">
                            <i class='bx bxs-calendar-event' style="width: 20px; height: 0px;"></i>
                            <span class="info-label">วันที่เริ่ม</span>
                        </div>
                        <span class="info-value"><?php echo e($project->formattedFirstTime); ?></span>
                    </div>

                    <div class="info-item">
                        <div class="info-top d-flex align-items-center">
                            <i class='bx bx-group' style="width: 20px; height: 0px; margin-right: 10px;"></i>
                            <span class="info-label">ผู้รับผิดชอบ</span>
                        </div>
                        <span class="info-value">
                            <?php if(session()->get('employee')->IsAdmin !== 'Y'): ?>
                            <?php if($project->employee && ($project->employee->Firstname || $project->employee->Lastname)): ?>
                            <?php echo e($project->employee->Firstname ?? ''); ?> <?php echo e($project->employee->Lastname ?? ''); ?>

                            <?php else: ?>
                            -
                            <?php endif; ?>
                            <?php endif; ?>

                            <?php if(session()->get('employee')->IsAdmin === 'Y'): ?>
                            <form action="<?php echo e(route('projects.updateEmployee', ['id' => $project->Id_Project])); ?>"
                                method="POST" id="updateEmployeeForm-<?php echo e($project->Id_Project); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="form-group d-flex align-items-center">
                                    <label for="employee_id-<?php echo e($project->Id_Project); ?>" class="mb-0"></label>
                                    <select name="employee_id" id="employee_id-<?php echo e($project->Id_Project); ?>"
                                        class="form-control ml-2"
                                        onchange="document.getElementById('updateEmployeeForm-<?php echo e($project->Id_Project); ?>').submit()">
                                        <?php if($project->employee && ($project->employee->Firstname ||
                                        $project->employee->Lastname)): ?>
                                        <option value="<?php echo e($project->employee_id); ?>" selected>
                                            <?php echo e($project->employee->Firstname); ?> <?php echo e($project->employee->Lastname); ?>

                                        </option>
                                        <?php else: ?>
                                        <option value="" disabled selected>เลือกผู้รับผิดชอบ</option>
                                        <?php endif; ?>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($employee->Id_Employee); ?>"
                                            <?php echo e($project->employee_id == $employee->Id_Employee ? 'selected' : ''); ?>>
                                            <?php echo e($employee->Firstname); ?> <?php echo e($employee->Lastname); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </form>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <div class="info-top">
                            <i class='bx bx-wallet-alt' style="width: 20px; height: 0px;"></i>
                            <span class="info-label">งบประมาณ</span>
                        </div>
                        <span class="info-value">
                            <?php if($project->Status_Budget === 'Y'): ?>
                            <?php
                            $totalBudget = 0;
                            // หากมี projectBudgetSources
                            if ($project->projectBudgetSources) {
                            // วนลูปแต่ละ budget source
                            foreach ($project->projectBudgetSources as $budgetSource) {
                            // ดึงค่าจาก relationship budgetSourceTotal และเพิ่มเข้าไปใน totalBudget
                            if ($budgetSource->budgetSourceTotal) {
                            $totalBudget += $budgetSource->budgetSourceTotal->Amount_Total;
                            }
                            }
                            }
                            ?>
                            <?php echo e(number_format($totalBudget, 2)); ?> บาท
                            <?php else: ?>
                            ไม่ใช้งบประมาณ
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="project-actions">
                <a href="<?php echo e(route('StorageFiles.index', ['project_id' => $project->Id_Project])); ?>" class="action-link">
                    <i class='bx bx-info-circle'></i>
                    ดูรายละเอียดโครงการ
                </a>

                <a href="#" class="action-link" data-bs-toggle="modal"
                    data-bs-target="#commentsModal-<?php echo e($project->Id_Project); ?>">
                    <i class='bx bx-message'></i>
                    ข้อเสนอแนะ(<?php echo e($project->approvals->first()->recordHistory->where('Status_Record', 'N')->count()); ?>)
                </a>

                <div class="modal fade" id="commentsModal-<?php echo e($project->Id_Project); ?>" tabindex="-1"
                    aria-labelledby="commentsModalLabel-<?php echo e($project->Id_Project); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="commentsModalLabel-<?php echo e($project->Id_Project); ?>">ข้อเสนอแนะ
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                $filteredRecords = $project->approvals->first()->recordHistory->where('Status_Record',
                                'N');
                                ?>
                                <?php if($filteredRecords->count() > 0): ?>
                                <ul>
                                    <?php $__currentLoopData = $filteredRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="p-2 border-bottom">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span
                                                class="font-weight-bold"><?php echo e($record->Name_Record ?? 'Unknown'); ?></span>
                                            <span
                                                class="text-muted small"><?php echo e($record->formattedDateTime ?? 'N/A'); ?></span>
                                        </div>
                                        <p class="mb-0"><?php echo e($record->comment ?? 'No Comment'); ?></p>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <?php else: ?>
                                <p class="text-center text-muted">ไม่มีข้อเสนอแนะ</p>
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="action-link" data-bs-toggle="modal"
                    data-bs-target="#viewersModal-<?php echo e($project->Id_Project); ?>">
                    <i class='bx bxs-book-content'></i>
                    คำสั่ง
                </a>

                <?php
                $project->viewers = collect([
                (object) ['Firstname' => 'สมชาย', 'Lastname' => 'ใจดี', 'Position' => 'ผู้อำนวยการ'],
                (object) ['Firstname' => 'สมหญิง', 'Lastname' => 'ใจงาม', 'Position' => 'หัวหน้าฝ่าย'],
                (object) ['Firstname' => 'สมปอง', 'Lastname' => 'ใจเย็น', 'Position' => 'บุคลากรในฝ่าย'],
                (object) ['Firstname' => 'สมศรี', 'Lastname' => 'ใจสบาย', 'Position' => 'บุคลากรในฝ่าย'],
                (object) ['Firstname' => 'สมจิตร', 'Lastname' => 'ใจสงบ', 'Position' => 'บุคลากรในฝ่าย'],
                (object) ['Firstname' => 'สมหมาย', 'Lastname' => 'ใจมั่น', 'Position' => 'บุคลากรในฝ่าย'],
                (object) ['Firstname' => 'สมบัติ', 'Lastname' => 'ใจเพชร', 'Position' => 'บุคลากรในฝ่าย'],
                ]);
                ?>

                <!-- Modal -->
                <div class="modal fade" id="viewersModal-<?php echo e($project->Id_Project); ?>" tabindex="-1"
                    aria-labelledby="viewersModalLabel-<?php echo e($project->Id_Project); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewersModalLabel-<?php echo e($project->Id_Project); ?>">
                                    รายชื่อผู้ที่สามารถมองเห็นโครงการ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ชื่อ</th>
                                            <th>นามสกุล</th>
                                            <th>ตำแหน่ง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $project->viewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $viewer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($viewer->Firstname); ?></td>
                                            <td><?php echo e($viewer->Lastname); ?></td>
                                            <td><?php echo e($viewer->Position); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="status-section">
                <div class="status-header">
                    สถานะการพิจารณา
                    <i class='bx bxs-chevron-right toggle-icon' id="toggle-icon-<?php echo e($project->Id_Project); ?>"></i>
                </div>
                <div class="project-status" id="project-status-<?php echo e($project->Id_Project); ?>">
                    <?php if($project->approvals->isNotEmpty() && $project->approvals->first()->recordHistory->isNotEmpty()): ?>
                    <?php $__currentLoopData = $project->approvals->first()->recordHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="status-card">
                        <div class="status-left">
                            <i class='bx bx-envelope' style="width: 40px;"></i>
                            <div>
                                <div class="status-text">
                                    <?php if($history->Status_Record === 'N'): ?>
                                    ไม่อนุมัติโครงการ
                                    <?php else: ?>
                                    <?php echo e($history->comment ?? 'No Comment'); ?>

                                    <?php endif; ?>
                                </div>
                                <div class="status-text">
                                    อนุมัติโดย: <?php echo e($history->Name_Record ?? 'Unknown'); ?>

                                </div>
                                <div class="status-text">
                                    ตำแหน่ง: <?php echo e($history->Permission_Record ?? 'Unknown'); ?>

                                </div>
                            </div>
                        </div>
                        <div class="status-right">
                            <span class="status-date">
                                <?php echo e($history->formattedDateTime ?? 'N/A'); ?>

                            </span>
                            <?php if($history->Status_Record === 'Y'): ?>
                            <button class="status-button approval-status approved">
                                เสร็จสิ้น
                            </button>
                            <?php elseif($history->Status_Record === 'N'): ?>
                            <a href="<?php echo e(route('approveProject', ['id' => $history->Approve_Id])); ?>"
                                class="status-button approval-status not-approved">
                                ไม่อนุมัติ
                            </a>
                            <?php else: ?>
                            <button class="status-button approval-status pending">
                                รอการอนุมัติ
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php if($project->approvals->first()->Status !== 'N'): ?>
                    <div class="status-card">
                        <div class="status-left">
                            <i class='bx bx-envelope' style="width: 40px;"></i>
                            <div>
                                <div class="status-text">
                                    <?php if($project->Count_Steps === 0): ?>
                                    <div class="status-text">
                                        เริ่มต้นการเสนอโครงการ
                                    </div>
                                    <div class="status-text">
                                        ถึง: ผู้อำนวยการพิจารณาเบื้องต้น
                                    </div>
                                    <?php elseif($project->Count_Steps === 1): ?>
                                    <div class="status-text">
                                        อยู่ระหว่างการพิจารณาเบื้องต้น
                                    </div>
                                    <div class="status-text">
                                        สถานะ: รอการพิจารณาจากผู้อำนวยการ
                                    </div>
                                    <?php elseif($project->Count_Steps === 2): ?>
                                    <?php if($project->approvals->first()->Status === 'Y'): ?>
                                    <div class="status-text">
                                        กรอกข้อมูลของโครงการทั้งหมด
                                    </div>
                                    <?php else: ?>
                                    <?php if($project->Status_Budget === 'N'): ?>
                                    <div class="status-text">
                                        การพิจารณาโดยหัวหน้าฝ่าย
                                    </div>
                                    <div class="status-text">
                                        สถานะ: อยู่ระหว่างการพิจารณาโดยหัวหน้าฝ่าย
                                    </div>
                                    <?php else: ?>
                                    <div class="status-text">
                                        การพิจารณาด้านงบประมาณ
                                    </div>
                                    <div class="status-text">
                                        ถึง: ฝ่ายการเงินตรวจสอบงบประมาณ
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <?php elseif($project->Count_Steps === 3): ?>
                                    <div class="status-text">
                                        ตรวจสอบความเหมาะสมด้านงบประมาณ
                                    </div>
                                    <div class="status-text">
                                        สถานะ: อยู่ระหว่างการตรวจสอบโดยฝ่ายการเงิน
                                    </div>
                                    <?php elseif($project->Count_Steps === 4): ?>
                                    <div class="status-text">
                                        การพิจารณาโดยหัวหน้าฝ่าย
                                    </div>
                                    <div class="status-text">
                                        สถานะ: อยู่ระหว่างการตรวจสอบโดยหัวหน้าฝ่าย
                                    </div>
                                    <?php elseif($project->Count_Steps === 5): ?>
                                    <div class="status-text">
                                        การพิจารณาโดยผู้อำนวยการ
                                    </div>
                                    <div class="status-text">
                                        สถานะ: อยู่ระหว่างการพิจารณาโดยผู้อำนวยการ
                                    </div>
                                    <?php elseif($project->Count_Steps === 6): ?>
                                    <div class="status-text">
                                        การดำเนินโครงการ
                                    </div>
                                    <?php if(\Carbon\Carbon::now()->lte(\Carbon\Carbon::parse($project->End_Time))): ?>
                                    <div class="status-text text-success">
                                        สถานะ: เสร็จทันเวลา
                                    </div>
                                    <?php else: ?>
                                    <div class="status-text text-danger">
                                        สถานะ: เสร็จไม่ทันเวลา
                                    </div>
                                    <?php endif; ?>
                                    <?php elseif($project->Count_Steps === 7): ?>
                                    <div class="status-text">
                                        การตรวจสอบผลการดำเนินงาน
                                    </div>
                                    <div class="status-text">
                                        สถานะ: รอการตรวจสอบจากหัวหน้าฝ่าย
                                    </div>
                                    <?php elseif($project->Count_Steps === 8): ?>
                                    <div class="status-text">
                                        การรับรองผลการดำเนินงาน
                                    </div>
                                    <div class="status-text">
                                        สถานะ: รอการรับรองจากผู้อำนวยการ
                                    </div>
                                    <?php elseif($project->Count_Steps === 9): ?>
                                    <div class="status-text">
                                        ปิดโครงการ
                                    </div>
                                    <div class="status-text">
                                        สถานะ: ดำเนินการเสร็จสิ้นสมบูรณ์
                                    </div>
                                    <?php elseif($project->Count_Steps === 11): ?>
                                    <div class="status-text">
                                        สถานะพิเศษ: การดำเนินการล่าช้า
                                    </div>
                                    <div class="status-text">
                                        สถานะ: รอการพิจารณาจากผู้อำนวยการ
                                    </div>
                                    <?php else: ?>
                                    <div class="status-text">
                                        <?php echo e($project->approvals->first()->Status ?? 'รอการพิจารณา'); ?>

                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php if($project->Count_Steps === 6 || $project->Count_Steps === 11): ?>
                                <div class="status-text">
                                    วันที่สิ้นสุด: <?php echo e($project->formattedEndTime); ?>

                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="status-right">
                            <span class="status-date">
                                <?php if($project->approvals->first()->recordHistory->isNotEmpty()): ?>
                                <?php echo e($project->approvals->first()->recordHistory->first()->formattedTimeRecord); ?>

                                <?php else: ?>
                                N/A
                                <?php endif; ?>
                            </span>
                            <button class="status-button approval-status pending">
                                <?php if($project->Count_Steps === 0): ?>
                                ส่ง Email
                                <?php elseif($project->Count_Steps === 1): ?>
                                กำลังพิจารณา
                                <?php elseif($project->Count_Steps === 2): ?>
                                กำลังพิจารณา
                                <?php elseif($project->Count_Steps === 3): ?>
                                กำลังพิจารณา
                                <?php elseif($project->Count_Steps === 4): ?>
                                กำลังพิจารณา
                                <?php elseif($project->Count_Steps === 5): ?>
                                กำลังพิจารณา
                                <?php elseif($project->Count_Steps === 6): ?>
                                กำลังพิจารณา
                                <?php elseif($project->Count_Steps === 7): ?>
                                กำลังพิจารณา
                                <?php elseif($project->Count_Steps === 8): ?>
                                เสร็จสิ้น
                                <?php elseif($project->Count_Steps === 9): ?>
                                สิ้นสุดโครงการ
                                <?php elseif($project->Count_Steps === 11): ?>
                                โครงการเสร็จไม่ทันเวลา
                                <?php else: ?>
                                <?php echo e($project->approvals->first()->Status ?? 'รอการอนุมัติ'); ?>

                                <?php endif; ?>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="button-container">
                        <?php if(in_array($project->Count_Steps, [0, 2, 3, 4, 5, 6])): ?>
                        <?php if($project->Count_Steps === 6): ?>
                        <?php if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($project->End_Time))): ?>
                        <form action="<?php echo e(route('projects.submitForApproval', ['id' => $project->Id_Project])); ?>"
                            method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-log-in-circle'></i> ส่งให้ผู้อำนวยการตรวจสอบ
                            </button>
                        </form>
                        <?php else: ?>
                        <a href="<?php echo e(route('reportForm', ['id' => $project->Id_Project])); ?>" class="btn btn-success">
                            <i class='bx bx-file'></i> ปุ่มรายงานโครงการ
                        </a>
                        <?php endif; ?>
                        <?php else: ?>
                        <?php if($project->Count_Steps === 2 && $project->approvals->first()->Status === 'Y'): ?>
                        <a href="<?php echo e(route('projects.edit', ['id' => $project->Id_Project ])); ?>" class="btn btn-warning">
                            <i class='bx bx-edit'></i> แก้ไขฟอร์ม
                        </a>
                        <?php elseif($project->Count_Steps === 3 && $project->approvals->first()->Status === 'N'): ?>
                        <a href="<?php echo e(route('projects.edit', ['id' => $project->Id_Project ])); ?>" class="btn btn-warning">
                            <i class='bx bx-edit'></i> แก้ไขฟอร์ม
                        </a>
                        <?php elseif($project->Count_Steps === 4 && $project->approvals->first()->Status === 'N'): ?>
                        <a href="<?php echo e(route('projects.edit', ['id' => $project->Id_Project ])); ?>" class="btn btn-warning">
                            <i class='bx bx-edit'></i> แก้ไขฟอร์ม
                        </a>
                        <?php elseif($project->Count_Steps === 5 && $project->approvals->first()->Status === 'N'): ?>
                        <a href="<?php echo e(route('projects.edit', ['id' => $project->Id_Project ])); ?>" class="btn btn-warning">
                            <i class='bx bx-edit'></i> แก้ไขฟอร์ม
                        </a>
                        <?php else: ?>
                        <?php if(in_array($project->Count_Steps, [3, 4, 5]) && $project->approvals->first()->Status === 'I'): ?>
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class='bx bx-log-in-circle'></i> เสนอเพื่อพิจารณา
                        </button>
                        <?php else: ?>
                        <form action="<?php echo e(route('projects.submitForApproval', ['id' => $project->Id_Project])); ?>"
                            method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-log-in-circle'></i> เสนอเพื่อพิจารณา
                            </button>
                        </form>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php elseif($project->Count_Steps === 9): ?>
                        <form action="<?php echo e(route('projects.submitForApproval', ['id' => $project->Id_Project])); ?>"
                            method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-secondary">สิ้นสุดโครงการ</button>
                        </form>
                        <?php else: ?>
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class='bx bx-log-in-circle'></i> เสนอเพื่อพิจารณา
                        </button>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(session()->get('employee')->IsAdmin === 'Y'): ?>
    <?php $__currentLoopData = $quartersByFiscalYear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fiscalYear => $yearQuarters): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $yearQuarters->sortBy('Quarter'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    $quarterProjects = $filteredStrategics->filter(function($strategic) use ($quarter) {
    return $strategic->quarterProjects->contains('Quarter_Project_Id', $quarter->Id_Quarter_Project);
    });
    $quarterStyle = $quarterStyles[$quarter->Quarter] ?? 'border-gray-200';

    $hasIncompleteStrategies = isset($incompleteStrategiesByYear[$fiscalYear]) &&
    $incompleteStrategiesByYear[$fiscalYear]->isNotEmpty();
    $missingStrategies = [];
    $logDataIncompleteStrategies = [];

    foreach ($logData as $logEntry) {
    if (strpos($logEntry, "Fiscal Year: $fiscalYear, Quarter: $quarter->Quarter") !== false) {
    if (strpos($logEntry, 'Status: No strategies created') !== false || strpos($logEntry, 'Status: No projects created')
    !== false) {
    $logDataIncompleteStrategies[] = preg_replace('/Fiscal Year: \d{4}, Quarter: \d, Status: (No strategies created|No
    projects created)/', '', $logEntry);
    }
    if (strpos($logEntry, 'Missing Strategy:') !== false) {
    preg_match('/Missing Strategy: (.*?),/', $logEntry, $matches);
    if (isset($matches[1])) {
    $missingStrategies[] = $matches[1];
    }
    }
    }
    }

    // Format logDataIncompleteStrategies to display only the required parts
    $logDataIncompleteStrategies = array_map(function($logEntry) {
    preg_match('/Strategy: (.*?), Strategic: (.*?),/', $logEntry, $matches);
    if (isset($matches[1], $matches[2])) {
    return "{$matches[2]}, {$matches[1]}";
    } elseif (preg_match('/Strategic: (.*?),/', $logEntry, $matches)) {
    return "{$matches[1]}, ไม่มีกลยุทธ์";
    } else {
    return $logEntry;
    }
    }, $logDataIncompleteStrategies);

    foreach ($quarterProjects as $Strategic) {
    foreach ($Strategic->projects as $project) {
    $strategyName = $project->Name_Strategy;
    $strategyProjects = $Strategic->projects->filter(function($p) use ($strategyName) {
    return $p->Name_Strategy === $strategyName;
    });

    $allProjectsStatusN = $strategyProjects->every(function($p) {
    return in_array('N', $p->approvalStatuses) || !isset($p->approvalStatuses);
    });

    $hasProjectStatusI = $strategyProjects->contains(function($p) {
    return in_array('I', $p->approvalStatuses);
    });

    if ($allProjectsStatusN && !$hasProjectStatusI) {
    $missingStrategies[] = $strategyName;
    }
    }
    }

    $missingStrategies = array_unique($missingStrategies);
    $allStrategiesComplete = empty($missingStrategies) && empty($logDataIncompleteStrategies);
    ?>

    <?php if($quarterProjects->isNotEmpty()): ?>
    <div class="card mb-4 border-2 <?php echo e($quarterStyle); ?>">
        <div class="card-body">
            <h5 class="card-title">เสนอหาผู้อำนวยการ ปีงบประมาณ <?php echo e($fiscalYear); ?> ไตรมาส <?php echo e($quarter->Quarter); ?></h5>

            <?php if($hasIncompleteStrategies || !empty($missingStrategies) || !empty($logDataIncompleteStrategies)): ?>
            <div class="alert alert-warning">
                <strong>กลยุทธ์ยังไม่ครบสำหรับปีงบประมาณ <?php echo e($fiscalYear); ?> ไตรมาส <?php echo e($quarter->Quarter); ?></strong>
                <ul>
                    <?php if($hasIncompleteStrategies): ?>
                    <?php $__currentLoopData = $incompleteStrategiesByYear[$fiscalYear]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($strategy); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <?php $__currentLoopData = $missingStrategies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($strategy); ?>: ไม่มีกลยุทธ์</li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $logDataIncompleteStrategies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($logEntry); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php else: ?>
            <div class="alert alert-success">
                <strong>กลยุทธ์ครบแล้วสำหรับปีงบประมาณ <?php echo e($fiscalYear); ?> ไตรมาส <?php echo e($quarter->Quarter); ?></strong>
            </div>
            <?php endif; ?>

            <div class="mb-3">
                <?php $__currentLoopData = $quarterProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Strategic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $filteredProjects = $Strategic->projects->filter(function($project) {
                return $project->Count_Steps == 0;
                });
                $filteredProjectCount = $filteredProjects->count();
                $firstStrategicPlanName = $Strategic->Name_Strategic_Plan;

                // Check for missing strategies
                $hasStrategies = !$Strategic->strategies->isEmpty();
                $hasProjects = $filteredProjectCount > 0;

                $totalStrategicBudget = $filteredProjects->sum(function($project) {
                $projectTotal = 0;
                if($project->projectBudgetSources) {
                foreach($project->projectBudgetSources as $budgetSource) {
                $projectTotal += $budgetSource->budgetSourceTotal ?
                $budgetSource->budgetSourceTotal->Amount_Total : 0;
                }
                }
                return $projectTotal;
                });
                $projectsByStrategy = $filteredProjects->groupBy('Name_Strategy');
                ?>

                <details class="accordion" id="<?php echo e($Strategic->Id_Strategic); ?>">
                    <summary class="accordion-btn">
                        <b>
                            <a><?php echo e($firstStrategicPlanName); ?></a>
                            <?php if(!$hasStrategies): ?>
                            <br><span class="badge bg-danger">ยังไม่มีกลยุทธ์</span>
                            <?php elseif(!$hasProjects): ?>
                            <br><span class="badge bg-warning">มีกลยุทธ์แต่ยังไม่มีโครงการ</span>
                            <br>กลยุทธ์ที่มี:
                            <ul class="strategy-list">
                                <?php $__currentLoopData = $Strategic->strategies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($strategy->Name_Strategy); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>
                            <br>จำนวนโครงการ : <?php echo e($filteredProjectCount); ?> โครงการ
                            <br>งบประมาณรวม: <?php echo e(number_format($totalStrategicBudget, 2)); ?> บาท
                        </b>
                    </summary>
                    <?php if($filteredProjectCount > 0): ?>
                    <div class="accordion-content">
                        <table class="summary-table">
                            <thead>
                                <tr>
                                    <th style="width:10%; text-align: center;">ยุทธศาสตร์ สำนักหอสมุด</th>
                                    <th style="width:10%; text-align: center;">กลยุทธ์ สำนักหอสมุด</th>
                                    <th style="width:14%; text-align: center;">โครงการ</th>
                                    <th style="width:14%; text-align: center;">ตัวชี้วัดความสำเร็จ<br>ของโครงการ</th>
                                    <th style="width:12%; text-align: center;">ค่าเป้าหมาย</th>
                                    <th style="width:10%; text-align: center;">งบประมาณ (บาท)</th>
                                    <th style="width:12%; text-align: center;">ผู้รับผิดชอบ</th>
                                    <th style="width:18%; text-align: center;">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $projectsByStrategy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategyName => $projects): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $strategyCount = $projects->count();
                                ?>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $Project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $isStatusN = in_array('N', $Project->approvalStatuses);
                                $isStatusI = in_array('I', $Project->approvalStatuses);
                                $allProjectsDeleted = $projects->every(function($project) {
                                return in_array('N', $project->approvalStatuses);
                                });
                                ?>
                                <tr>
                                    <?php if($index === 0 && $loop->parent->first): ?>
                                    <td rowspan="<?php echo e($filteredProjectCount); ?>"><?php echo e($firstStrategicPlanName); ?></td>
                                    <?php endif; ?>
                                    <?php if($index === 0): ?>
                                    <td class="<?php echo e($allProjectsDeleted ? 'text-gray' : ''); ?>"
                                        rowspan="<?php echo e($strategyCount); ?>">
                                        <?php echo e($strategyName ?? '-'); ?>

                                    </td>
                                    <?php endif; ?>
                                    <td class="<?php echo e($isStatusN && !$isStatusI ? 'text-gray' : ''); ?>">
                                        <b><?php echo e($Project->Name_Project); ?></b><br>
                                        <?php $__currentLoopData = $Project->subProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subProject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        - <?php echo e($subProject->Name_Sub_Project); ?><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td class="<?php echo e($isStatusN && !$isStatusI ? 'text-gray' : ''); ?>">
                                        <?php if($Project->successIndicators->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $Project->successIndicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        - <?php echo nl2br(e($indicator->Description_Indicators)); ?><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        -
                                        <?php endif; ?>
                                    </td>
                                    <td class="<?php echo e($isStatusN && !$isStatusI ? 'text-gray' : ''); ?>">
                                        <?php if($Project->valueTargets->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $Project->valueTargets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        - <?php echo nl2br(e($target->Value_Target)); ?><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        -
                                        <?php endif; ?>
                                    </td>
                                    <td class="<?php echo e($isStatusN && !$isStatusI ? 'text-gray' : ''); ?>"
                                        style="text-align: center;">
                                        <?php if($Project->Status_Budget === 'N'): ?>
                                        ไม่ใช้งบประมาณ
                                        <?php else: ?>
                                        <?php
                                        $totalBudget = 0;
                                        if($Project->projectBudgetSources) {
                                        foreach($Project->projectBudgetSources as $budgetSource) {
                                        $totalBudget += $budgetSource->budgetSourceTotal ?
                                        $budgetSource->budgetSourceTotal->Amount_Total : 0;
                                        }
                                        }
                                        ?>
                                        <?php echo e(number_format($totalBudget, 2)); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="<?php echo e($isStatusN && !$isStatusI ? 'text-gray' : ''); ?>">
                                        <?php echo e($Project->employee->Firstname ?? '-'); ?>

                                        <?php echo e($Project->employee->Lastname ?? ''); ?>

                                    </td>
                                    <td class="<?php echo e($isStatusN && !$isStatusI ? 'text-gray' : ''); ?>"
                                        style="text-align: center;">
                                        <a href="<?php echo e(route('editProject', ['Id_Project' => $Project->Id_Project, 'sourcePage' => 'proposeProject'])); ?>"
                                            class="btn btn-warning btn-sm">แก้ไข</a>
                                        <?php if(!$isStatusN || $isStatusI): ?>
                                        <form
                                            action="<?php echo e(route('projects.updateStatus', ['id' => $Project->Id_Project])); ?>"
                                            method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to update the status of this project?');">ลบ</button>
                                        </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr class="summary-row">
                                    <td colspan="2" style="text-align: left; font-weight: bold;">รวมงบประมาณทั้งหมด:
                                    </td>
                                    <td colspan="6" style="text-align: center; font-weight: bold;">
                                        <?php echo e(number_format($totalStrategicBudget, 2)); ?> บาท
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="accordion-content">
                        <p>ไม่มีโครงการที่เกี่ยวข้อง</p>
                    </div>
                    <?php endif; ?>
                </details>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="button-container mt-3">
                <form action="<?php echo e(route('projects.submitForAllApproval')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="quarter" value="<?php echo e($quarter->Quarter); ?>">
                    <input type="hidden" name="fiscal_year" value="<?php echo e($fiscalYear); ?>">
                    <?php $__currentLoopData = $quarterProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Strategic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $Strategic->projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="project_ids[]" value="<?php echo e($project->Id_Project); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <button type="submit" class="btn btn-primary w-full"
                        <?php echo e($allStrategiesComplete && !$hasStatusN ? '' : 'disabled'); ?>>
                        เสนอโครงการทั้งหมด ไตรมาส <?php echo e($quarter->Quarter); ?>

                    </button>
                </form>
            </div>

        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusHeaders = document.querySelectorAll('.status-header');

    statusHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const projectStatus = this.nextElementSibling;
            const toggleIcon = this.querySelector('.toggle-icon');

            if (projectStatus.classList.contains('show')) {
                projectStatus.style.maxHeight = 0;
                projectStatus.classList.remove('show');
                toggleIcon.classList.remove('rotate');
            } else {
                projectStatus.style.maxHeight = projectStatus.scrollHeight + 'px';
                projectStatus.classList.add('show');
                toggleIcon.classList.add('rotate');
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="employee_id-"]').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            const formId = this.id.replace('employee_id-', 'updateEmployeeForm-');
            document.getElementById(formId).submit();
            alert('ชื่อผู้รับผิดชอบมีการแก้ไขแล้ว');
        });

        const formId = selectElement.id.replace('employee_id-', 'updateEmployeeForm-');
        document.getElementById(formId).addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                this.submit();
                alert('ชื่อผู้รับผิดชอบมีการแก้ไขแล้ว');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/proposeProject.blade.php ENDPATH**/ ?>