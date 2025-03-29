<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <style>
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url('<?php echo e(public_path('fonts/THSarabunNew.ttf')); ?>') format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url('<?php echo e(public_path('fonts/THSarabunNew Bold.ttf')); ?>') format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: italic;
        font-weight: normal;
        src: url('<?php echo e(public_path('fonts/THSarabunNew Italic.ttf')); ?>') format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: italic;
        font-weight: bold;
        src: url('<?php echo e(public_path('fonts/THSarabunNew BoldItalic.ttf')); ?>') format('truetype');
    }

    @page {
        size: A4 landscape;
        margin: 0.5in 1in 1in 1in;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: 'THSarabunNew', sans-serif;
    }

    .page-container {
        padding: 40px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 10px;
        font-size: 14px;
        vertical-align: top;
        word-wrap: break-word;
        background-color: white;
    }

    th {
        background-color: #c8e6c9 !important;
        font-weight: bold;
        text-align: center;
    }

    .red-text {
        color: red;
    }

    .sub-item {
        padding-left: 20px;
    }

    .button-container {
        margin-bottom: 20px;
        padding: 0;
        text-align: center;
    }

    button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }

    @media print {
        @page {
            size: A4 landscape;
            margin: 0.5in 1in 1in 1in;
        }

        .button-container {
            display: none;
        }

        body {
            padding: 0;
            margin: 0;
        }

        th {
            background-color: #c8e6c9 !important;
            color: black;
            text-align: center;
            padding: 10px;
            border: 1px solid black !important;
        }

        td {
            padding: 8px;
            word-wrap: break-word;
        }
    }
    </style>
</head>

<body>
    <div id="content">
        <table>
            <thead class="thead-repeat">
                <tr>
                    <th style="width:10%; font-family: 'THSarabunNew', sans-serif;">ยุทธศาสตร์ สำนักหอสมุด</th>
                    <th style="width:10%; font-family: 'THSarabunNew', sans-serif;">กลยุทธ์ สำนักหอสมุด</th>
                    <th style="width:14%; font-family: 'THSarabunNew', sans-serif;">โครงการ</th>
                    <th style="width:14%; font-family: 'THSarabunNew', sans-serif;">ตัวชี้วัดความสำเร็จ ของโครงการ</th>
                    <th style="width:12%; font-family: 'THSarabunNew', sans-serif;">ค่าเป้าหมาย</th>
                    <th style="width:10%; font-family: 'THSarabunNew', sans-serif;">งบประมาณ (บาท)</th>
                    <th style="width:12%; font-family: 'THSarabunNew', sans-serif;">ผู้รับผิดชอบ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                use Carbon\Carbon;
                Carbon::setLocale('th');

                // Calculate total budget from Budget_Source_Total
                $totalBudget = 0;
                foreach ($project->projectBudgetSources as $pbs) {
                // Get budget source totals for this project_has_budget_source
                $budgetSourceTotals = App\Models\BudgetSourceTotalModel::where('Project_has_Budget_Source_Id',
                $pbs->Id_Project_has_Budget_Source)->get();

                // Sum up all Amount_Total values
                foreach ($budgetSourceTotals as $bst) {
                $totalBudget += (float)$bst->Amount_Total;
                }
                }
                ?>
                <tr>
                    <td><?php echo e($project->strategic->Name_Strategic_Plan); ?></td>
                    <td><?php echo e($project->Name_Strategy ?? '-'); ?></td>
                    <td>
                        <?php echo e($project->Name_Project); ?><br>
                        <?php $__currentLoopData = $project->subProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subProject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        - <?php echo e($subProject->Name_Sub_Project); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td>
                        <?php if($project->successIndicators && $project->successIndicators->isNotEmpty()): ?>
                        <?php $__currentLoopData = $project->successIndicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($index + 1); ?>. <?php echo nl2br(e($indicator->Description_Indicators)); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php elseif($project->Success_Indicators): ?>
                        <?php echo nl2br(e($project->Success_Indicators)); ?>

                        <?php else: ?>
                        -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($project->valueTargets && $project->valueTargets->isNotEmpty()): ?>
                        <?php $__currentLoopData = $project->valueTargets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($index + 1); ?>. <?php echo nl2br(e($target->Value_Target)); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php elseif($project->Value_Target): ?>
                        <?php echo nl2br(e($project->Value_Target)); ?>

                        <?php else: ?>
                        -
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <?php if($project->Status_Budget == 'N' || $totalBudget == 0): ?>
                        ไม่ใช้งบประมาณ
                        <?php else: ?>
                        <?php echo e(number_format($totalBudget, 0)); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo e($project->employee->Firstname ?? '-'); ?>

                        <?php echo e($project->employee->Lastname ?? ''); ?>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html><?php /**PATH /app/resources/views/PDF/PDFFirstForm.blade.php ENDPATH**/ ?>