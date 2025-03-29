<?php
use Carbon\Carbon;
Carbon::setLocale('th');
?>

<head>
    <link rel="stylesheet" href="<?php echo e(asset('css/requestApproval.css')); ?>">
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

    .page-container {
        padding: 40px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-bottom: 1px;
        border: 1px solid #000;
    }

    th {
        background-color: #c8e6c9 !important;
        font-weight: bold;
        text-align: center;
        border: 2px solid #000 !important;
        padding: 10px;
        font-size: 14px;
    }

    td {
        border: 2px solid #000 !important;
        padding: 10px;
        font-size: 14px;
        vertical-align: top;
        word-wrap: break-word;
        background-color: white;
    }

    .summary-row {
        background-color: #c8e6c9 !important;
    }

    .summary-row td {
        background-color: #c8e6c9 !important;
        padding: 20px 10px !important;
        border: 2px solid #000 !important;
        line-height: 1.2 !important;
        vertical-align: middle !important;
        font-weight: bold;
    }

    td[rowspan] {
        border: 2px solid #000 !important;
    }

    .button-container {
        margin: 20px 0;
        text-align: center;
    }

    .print-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .text-gray {
        color: #a9a9a9;
    }

    .row-gray {
        background-color: #f0f0f0;
    }

    @media print {
        .button-container {
            display: none;
        }

        @page {
            size: A4 landscape;
        }
    }
    </style>
</head>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>การอนุมัติทั้งหมด</h1>

    <?php $__currentLoopData = $logData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fiscalQuarter => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($group): ?>
    <?php
    list($fiscalYear, $quarterName) = explode('-', $fiscalQuarter);
    ?>
    <div class="card mb-4 border-2">
        <div class="card-body">
            <h5 class="card-title">ปีงบประมาณ: <?php echo e($fiscalYear); ?> ไตรมาส: <?php echo e($quarterName); ?></h5>
            <?php
            $displayedStrategicPlans = [];
            ?>
            <?php $__currentLoopData = $strategics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $strategic->quarterProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarterProject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($quarterProject->quarterProject->Fiscal_Year == $fiscalYear && $quarterProject->quarterProject->Quarter
            == $quarterName): ?>
            <?php
            $hasStrategies = !$strategic->strategies->isEmpty();
            $hasProjects = $strategic->strategies->pluck('projects')->flatten()->isNotEmpty();
            $filteredProjects = $strategic->strategies->pluck('projects')->flatten()->filter(function($project) {
            return $project->Count_Steps == 1;
            });
            $filteredProjectCount = $filteredProjects->count();
            $totalStrategicBudget = $filteredProjects->sum(function($project) {
            return $project->projectBudgetSources ? $project->projectBudgetSources->sum('Amount_Total') : 0;
            });

            // Check if all projects in a strategy are disapproved
            $allStrategiesGray = true;
            foreach ($strategic->strategies as $strategy) {
            $allProjectsGray = true;
            foreach ($strategy->projects as $project) {
            if ($project->approvals->first()->Status !== 'N') {
            $allProjectsGray = false;
            break;
            }
            }
            if (!$allProjectsGray) {
            $allStrategiesGray = false;
            break;
            }
            }
            ?>

            <?php if($filteredProjectCount > 0 && !in_array($strategic->Name_Strategic_Plan, $displayedStrategicPlans)): ?>
            <?php
            $displayedStrategicPlans[] = $strategic->Name_Strategic_Plan;
            ?>

            <?php
            // คำนวณงบประมาณทั้งหมดของยุทธศาสตร์
            $totalStrategicBudget = 0;
            foreach ($strategic->strategies as $strategy) {
            $filteredProjects = $strategy->projects->filter(function($project) {
            return $project->Count_Steps == 1;
            });

            foreach ($filteredProjects as $project) {
            if ($project->Status_Budget !== 'N') {
            $projectBudget = 0;
            if ($project->projectBudgetSources) {
            foreach ($project->projectBudgetSources as $budgetSource) {
            $projectBudget += $budgetSource->budgetSourceTotal ?
            $budgetSource->budgetSourceTotal->Amount_Total : 0;
            }
            }
            $totalStrategicBudget += $projectBudget;
            }
            }
            }
            ?>
            <details class="accordion">
                <summary class="accordion-btn">
                    <b>
                        <a><?php echo e($strategic->Name_Strategic_Plan); ?></a>
                        <?php if(!$hasStrategies): ?>
                        <br><span class="badge bg-danger">ยังไม่มีกลยุทธ์</span>
                        <?php elseif(!$hasProjects): ?>
                        <br><span class="badge bg-warning">มีกลยุทธ์แต่ยังไม่มีโครงการ</span>
                        <br>กลยุทธ์ที่มี:
                        <ul class="strategy-list">
                            <?php $__currentLoopData = $strategic->strategies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($strategy->Name_Strategy); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                        <br>จำนวนโครงการ : <?php echo e($filteredProjectCount); ?> โครงการ
                        <br>งบประมาณรวม: <?php echo e(number_format($totalStrategicBudget, 2)); ?> บาท
                    </b>
                </summary>
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
                                <th style="width:10%; text-align: center;">การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $displayedStrategicName = false;
                            $totalRowCount = $strategic->strategies->sum(function($strategy) {
                            return $strategy->projects->filter(function($project) {
                            return $project->Count_Steps == 1;
                            })->count();
                            });
                            ?>

                            <?php $__currentLoopData = $strategic->strategies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $strategyDisplayed = false;
                            $allProjectsGray = true;
                            $filteredProjects = $strategy->projects->filter(function($project) {
                            return $project->Count_Steps == 1;
                            });
                            ?>

                            <?php if($filteredProjects->count() > 0): ?>
                            <?php $__currentLoopData = $filteredProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            if ($project->approvals->first()->Status !== 'N') {
                            $allProjectsGray = false;
                            }
                            ?>
                            <tr>
                                <?php if(!$displayedStrategicName): ?>
                                <td rowspan="<?php echo e($totalRowCount); ?>"><?php echo e($strategic->Name_Strategic_Plan); ?></td>
                                <?php
                                $displayedStrategicName = true;
                                ?>
                                <?php endif; ?>

                                <?php if(!$strategyDisplayed): ?>
                                <td rowspan="<?php echo e($filteredProjects->count()); ?>"
                                    class="<?php echo e($allProjectsGray ? 'text-gray' : ''); ?>">
                                    <?php echo e($strategy->Name_Strategy); ?>

                                </td>
                                <?php
                                $strategyDisplayed = true;
                                ?>
                                <?php endif; ?>
                                <td class="<?php echo e($project->approvals->first()->Status === 'N' ? 'text-gray' : ''); ?>">
                                    <b><?php echo e($project->Name_Project); ?></b>
                                </td>
                                <td class="<?php echo e($project->approvals->first()->Status === 'N' ? 'text-gray' : ''); ?>">
                                    <?php if($project->successIndicators && $project->successIndicators->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $project->successIndicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    - <?php echo nl2br(e($indicator->Description_Indicators)); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <?php echo e($project->Success_Indicators ?? '-'); ?>

                                    <?php endif; ?>
                                </td>
                                <td class="<?php echo e($project->approvals->first()->Status === 'N' ? 'text-gray' : ''); ?>">
                                    <?php if($project->valueTargets && $project->valueTargets->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $project->valueTargets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    - <?php echo nl2br(e($target->Value_Target)); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <?php echo e($project->Value_Target ?? '-'); ?>

                                    <?php endif; ?>
                                </td>
                                <td class="<?php echo e($project->approvals->first()->Status === 'N' ? 'text-gray' : ''); ?>"
                                    style="text-align: center;">
                                    <?php if($project->Status_Budget === 'N'): ?>
                                    ไม่ใช้งบประมาณ
                                    <?php else: ?>
                                    <?php
                                    $totalBudget = 0;
                                    if($project->projectBudgetSources) {
                                    foreach($project->projectBudgetSources as $budgetSource) {
                                    $totalBudget += $budgetSource->budgetSourceTotal ?
                                    $budgetSource->budgetSourceTotal->Amount_Total : 0;
                                    }
                                    }
                                    ?>
                                    <?php echo e(number_format($totalBudget, 2)); ?>

                                    <?php endif; ?>
                                </td>
                                <td class="<?php echo e($project->approvals->first()->Status === 'N' ? 'text-gray' : ''); ?>">
                                    <?php echo e($project->employee->Firstname ?? '-'); ?>

                                    <?php echo e($project->employee->Lastname ?? '-'); ?>

                                </td>
                                <td>
                                    <?php if($project->approvals->first()->Status !== 'N'): ?>
                                    <button type="button" class="btn btn-danger btn-sm custom-disapprove-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#commentModal-<?php echo e($project->Id_Project); ?>">ไม่อนุมัติ</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
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
            </details>
            <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="status-section mt-3">
                <div class="status-header">การดำเนินการ</div>
                <div class="status-card">
                    <div class="status-right">
                        <div class="action-buttons">
                            <?php if(isset($logData) && is_array($logData) && count($logData) > 0): ?>
                            <?php if(is_array($group) && count($group) > 0): ?>
                            <form action="<?php echo e(route('updateAllStatus')); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="fiscalQuarter" value="<?php echo e($fiscalQuarter); ?>">
                                <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $logEntryParts = explode(', ', $logEntry);
                                $projectId = explode(': ', $logEntryParts[1])[1];
                                ?>
                                <input type="hidden" name="approvals[<?php echo e($projectId); ?>][id]" value="<?php echo e($projectId); ?>">
                                <input type="hidden" name="approvals[<?php echo e($projectId); ?>][status]" value="Y">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <button type="submit" class="status-button approved">
                                    <i class='bx bx-like'></i> อนุมัติทั้งหมด
                                </button>
                            </form>
                            <button type="button" class="status-button not-approved" data-bs-toggle="modal"
                                data-bs-target="#commentModal-<?php echo e($fiscalQuarter); ?>">
                                <i class='bx bx-dislike'></i> ไม่อนุมัติทั้งหมด
                            </button>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for not approving all projects in a fiscal quarter -->
            <div class="modal fade" id="commentModal-<?php echo e($fiscalQuarter); ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">เพิ่มความคิดเห็นสำหรับการไม่อนุมัติทั้งหมด (<?php echo e($fiscalQuarter); ?>)
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo e(route('updateAllStatus')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="fiscalQuarter" value="<?php echo e($fiscalQuarter); ?>">
                                <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $logEntryParts = explode(', ', $logEntry);
                                $projectId = explode(': ', $logEntryParts[1])[1];
                                ?>
                                <input type="hidden" name="approvals[<?php echo e($projectId); ?>][id]" value="<?php echo e($projectId); ?>">
                                <input type="hidden" name="approvals[<?php echo e($projectId); ?>][status]" value="N">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-3">
                                    <label for="comment" class="form-label">ความคิดเห็น:</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3"
                                        required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger">ยืนยันการไม่อนุมัติทั้งหมด</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for not approving individual projects -->
            <?php $__currentLoopData = $strategics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $strategic->projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($project->Count_Steps == 1): ?>
            <div class="modal fade" id="commentModal-<?php echo e($project->Id_Project); ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">เพิ่มความคิดเห็น</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo e(route('disapproveProject', ['id' => $project->Id_Project])); ?>"
                                method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="mb-3">
                                    <label for="comment" class="form-label">ความคิดเห็น:</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3"
                                        required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger">ยืนยันการไม่อนุมัติ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <?php $__currentLoopData = $approvals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $approval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($approval->Status !== 'Y' && $approval->Status !== 'N'): ?>
    <?php if($approval->project->Count_Steps != 1): ?>
    <div class="outer-container">
        <div class="container">
            <div class="header">
                <div class="project-title"><?php echo e($approval->project->Name_Project); ?></div>
                <p><?php echo e($approval->project->employee->department->Name_Department ?? 'ยังไม่มีผู้รับผิดชอบโครงการ'); ?></p>
                <div class="project-info">
                    <div class="info-item">
                        <div class="info-top">
                            <i class='bx bx-calendar' style="width: 20px; height: 0px;"></i>
                            <span class="info-label">วันที่เริ่ม</span>
                        </div>
                        <span class="info-value">
                            <?php echo e($approval->project->formattedFirstTime ?? '-'); ?>

                        </span>
                    </div>
                    <div class="info-item">
                        <div class="info-top">
                            <i class='bx bx-user' style="width: 20px; height: 0px;"></i>
                            <span class="info-label">ผู้รับผิดชอบ</span>
                        </div>
                        <span class="info-value">
                            <?php if($approval->project->employee && ($approval->project->employee->Firstname ||
                            $approval->project->employee->Lastname)): ?>
                            <?php echo e($approval->project->employee->Firstname ?? ''); ?>

                            <?php echo e($approval->project->employee->Lastname ?? ''); ?>

                            <?php else: ?>
                            -
                            <?php endif; ?>
                        </span>

                    </div>
                    <div class="info-item">
                        <div class="info-top">
                            <i class='bx bx-wallet-alt' style="width: 20px; height: 0px;"></i>
                            <span class="info-label">งบประมาณ</span>
                        </div>
                        <span class="info-value">
                            <?php if($approval->project->Status_Budget === 'Y'): ?>
                            <?php
                            $totalBudget = 0;
                            // หากมี projectBudgetSources
                            if ($approval->project->projectBudgetSources) {
                            // วนลูปแต่ละ budget source
                            foreach ($approval->project->projectBudgetSources as $budgetSource) {
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

                <div class="project-actions">
                    <a href="<?php echo e(route('StorageFiles.index', ['project_id' => $approval->project->Id_Project])); ?>"
                        class="action-link">
                        <i class='bx bx-info-circle'></i>
                        ดูรายละเอียดโครงการ
                    </a>

                    <a href="#" class="action-link" data-bs-toggle="modal"
                        data-bs-target="#commentsModal-<?php echo e($approval->project->Id_Project); ?>">
                        <i class='bx bx-message'></i>
                        ข้อเสนอแนะ(<?php echo e($approval->recordHistory->where('Status_Record', 'N')->count()); ?>)
                    </a>

                    <div class="modal fade" id="commentsModal-<?php echo e($approval->project->Id_Project); ?>" tabindex="-1"
                        aria-labelledby="commentsModalLabel-<?php echo e($approval->project->Id_Project); ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"
                                        id="commentsModalLabel-<?php echo e($approval->project->Id_Project); ?>">ข้อเสนอแนะ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $filteredRecords = $approval->recordHistory->where('Status_Record', 'N');
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
                        data-bs-target="#viewersModal-<?php echo e($approval->project->Id_Project); ?>">
                        <i class='bx bxs-book-content'></i>
                        คำสั่ง
                    </a>

                    <?php
                    $approval->project->viewers = collect([
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
                    <div class="modal fade" id="viewersModal-<?php echo e($approval->project->Id_Project); ?>" tabindex="-1"
                        aria-labelledby="viewersModalLabel-<?php echo e($approval->project->Id_Project); ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewersModalLabel-<?php echo e($approval->project->Id_Project); ?>">
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
                                            <?php $__currentLoopData = $approval->project->viewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $viewer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                    <div class="status-header">การดำเนินการ</div>
                    <div class="status-card">
                        <div class="status-left">
                            <div class="status-text">
                                รออนุมัติ: <?php echo e(floor($approval->recordHistory->last()->daysSinceTimeRecord ?? 0)); ?> วัน
                            </div>
                        </div>
                        <div class="status-right">
                            <div class="action-buttons">
                                <form
                                    action="<?php echo e(route('approvals.updateStatus', ['id' => $approval->Id_Approve, 'status' => 'Y'])); ?>"
                                    method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <button type="submit" class="status-button approved">
                                        <i class='bx bx-like'></i> เห็นควร
                                    </button>
                                </form>
                                <button type="button" class="status-button not-approved" data-bs-toggle="modal"
                                    data-bs-target="#commentModal-<?php echo e($approval->Id_Approve); ?>">
                                    <i class='bx bx-dislike'></i> ไม่เห็นควร
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="commentModal-<?php echo e($approval->Id_Approve); ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มความคิดเห็น</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form
                            action="<?php echo e(route('approvals.updateStatus', ['id' => $approval->Id_Approve, 'status' => 'N'])); ?>"
                            method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="mb-3">
                                <label for="comment" class="form-label">ความคิดเห็น:</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="status-button not-approved">ยืนยันการไม่อนุมัติ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/requestApproval.blade.php ENDPATH**/ ?>