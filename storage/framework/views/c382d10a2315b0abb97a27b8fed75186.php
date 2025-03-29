<!DOCTYPE html>
<html lang="th">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="<?php echo e(public_path('css/pdf.css')); ?>">
    <title><?php echo e($project->Name_Project); ?></title>
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

    body {
        font-family: 'THSarabunNew', sans-serif;
        overflow-wrap: break-word;
        margin-top: 0.3in;
        margin-left: 0.5in;
        margin-right: 0.05in;
        margin-bottom: 0.07in;
        line-height: 0.8;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        page-break-inside: avoid;
    }

    tr {
        page-break-inside: avoid;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 5px;
        text-align: center;
        font-size: 18px;
        word-wrap: break-word;
        word-break: break-word;
    }

    th {
        background-color: rgba(197, 224, 179, 255);
    }

    td {
        text-align: left;
        vertical-align: top;
        word-break: break-word;
    }

    .thead-repeat {
        display: table-header-group;
    }

    .strategy-cell {
        position: relative;
    }

    .page-break {
        page-break-before: always;
    }

    .header {
        position: fixed;
        top: 0.01in;
        left: 0;
        right: 0;
        margin-bottom: 40px;
        margin-right: 0.7in;

        height: 30px;
        text-align: right;
        font-size: 18px;
    }

    .header:after {
        content: counter(page);
    }
    </style>
</head>

<body>

    <h1>รายงานผลการดำเนินงานโครงการ<br>สำนักหอสมุด มหาวิทยาลัยบูรพา</h1>
    <div class="line" style="width: 100%; max-width: 590px; word-wrap: break-word;"></div>
    <p><b>๑. ชื่อโครงการ </b><?php echo e(toThaiNumber($project->Name_Project)); ?></p>

    <p class="space"><b>๒. ผู้รับผิดชอบโครงการ </b>
        <?php echo e($project->employee->Prefix_Name ?? '-'); ?><?php echo e($project->employee->Firstname ?? ''); ?>

        <?php echo e($project->employee->Lastname ?? ''); ?>

    </p>

    <p class="space"><b>๓. วัตถุประสงค์โครงการ</b>
        <?php $__currentLoopData = $project->objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p style="text-indent: 70px; margin-top: 0;">
                <?php echo e(toThaiNumber($objective->Description_Objective) ?? '-'); ?>

            </p>    
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </p>

    <p class="space"><b>๔. กลุ่มเป้าหมาย</b>
        <p class="paragraph"><b>๔.๑ กลุ่มผู้รับบริการ</b>
        <?php $__currentLoopData = $project->targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <table style="border-collapse: collapse; width:100%; border: none;">
                <tr>
                    <td style="width: 18%; border: none;"></td>
                    <td style="width: 35%; text-align: left; padding: 5px; border: none;"><p><?php echo e(toThaiNumber($index + 1)); ?>. <?php echo e($target->Name_Target); ?></p></td>
                    <td style="text-align: left; padding: 5px; border: none;">
                        <p class="paragraph-two">
                            <span>จำนวน </span>
                            <span style="width: 50px; margin-top: 0;">
                                <?php echo e(toThaiNumber($target->Quantity_Target)); ?>

                            </span>
                            <?php echo e(toThaiNumber($target->Unit_Target)); ?>

                        </p>
                    </td>
                </tr>
            </table>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </p>

        <?php if($project->targets->isNotEmpty()): ?> 
            <p class="paragraph" style="margin-top: 20px;">
                <b>๔.๒ พื้นที่/ชุมชนเป้าหมาย (ถ้ามี ระบุ)</b>
            </p>
            <p class="paragraph-two">
                <?php $__currentLoopData = $project->targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $target->targetDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e(toThaiNumber($detail->Details_Target)); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </p>
        <?php else: ?>
            <span>-</span>
        <?php endif; ?>
    </p>

    <p class="space">
        <span><b>๕. ระยะเวลาดำเนินโครงการ</b></span>
        <p class="paragraph-content">
            <?php if(!empty($project->First_Time) && !empty($project->End_Time)): ?>
            <span>กำหนดการจัดโครงการ
                <b><?php echo e($project->formatted_first_time); ?></b> ถึง <b><?php echo e($project->formatted_end_time); ?></b>
            </span>
            <?php else: ?>
            <span>-</span>
            <?php endif; ?>
        </p>
    </p>

    <p class="space">
        <span><b>๖. สถานที่ดำเนินงาน</b></span><br>
        <?php if($project->locations->isNotEmpty()): ?>
            <?php $__currentLoopData = $project->locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="paragraph">
                <?php echo e(toThaiNumber($index + 1)); ?>. <?php echo e(toThaiNumber($location->Name_Location)); ?> <br>
            </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            -
        <?php endif; ?>
    </p>

    <p class="space">
        <span><b>๗. วิทยากร</b></span>
        <p class="paragraph-content">
            <?php if($project->Name_Speaker != null): ?>
                <?php echo e(toThaiNumber($project->Name_Speaker)); ?>

            <?php else: ?>
                -
            <?php endif; ?>
        </p>
    </p>

    <p class="space">
        <span><b>๘. รูปแบบกิจกรรมการดำเนินงาน</b></span> <br>
        <?php if($project->Project_Type == 'S'): ?>
            <!-- โครงการระยะสั้น -->
            <p>วิธีการดำเนินการ</p>
            <p>
                <?php $__currentLoopData = $project->shortProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shortProject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="paragraph">
                    <?php echo e(toThaiNumber($loop->iteration)); ?>. <?php echo e(toThaiNumber($shortProject->Details_Short_Project)); ?>

                </span><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </p>

        <?php else: ?>

            <p>ขั้นตอนและแผนการดำเนินงาน(PDCA)<br></p>
            <!-- โครงการระยะยาว -->
            <table>
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 40%; line-height: 0.6;">กิจกรรมและแผนการเบิกจ่ายงบประมาณ</th>
                        <th colspan="12">
                            <span>ปีงบประมาณ พ.ศ.</span>
                            <?php $__currentLoopData = $quarterProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span><?php echo e(toThaiNumber($year)); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </th>
                    </tr>
                    <tr>
                        <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($month); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $groupedPdcaDetails = $project->pdcaDetails->groupBy(function($pdcaDetail) {
                            return $pdcaDetail->pdca->Name_PDCA ?? 'N/A';
                        });
                    ?>

                    <?php $__currentLoopData = $groupedPdcaDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $namePDCA => $pdcaDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="text-align: left;">
                                <strong><?php echo e($namePDCA); ?></strong><br>
                                <?php $__currentLoopData = $pdcaDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdcaDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e(toThaiNumber($loop->iteration)); ?>. <?php echo e($pdcaDetail->Details_PDCA); ?><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <?php for($month = 1; $month <= 12; $month++): ?>
                                <td style="text-align: center;">
                                <?php if($project->monthlyPlans->where('Months_Id', $month)->where('PDCA_Stages_Id', $pdcaDetail->PDCA_Stages_Id)->isNotEmpty()): ?>
                                    /
                                <?php endif; ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </p>

    <!-- ตัวชี้วัด -->
    <p class="space">
        <span><b>๙. ตัวชี้วัดความสำเร็จ</b></span>
        <?php if($project->projectHasIndicators->where('indicators.Type_Indicators', 'Quantitative')->isNotEmpty()): ?>
            <p class="paragraph">เชิงปริมาณ</p>
            <?php $__currentLoopData = $project->projectHasIndicators->where('indicators.Type_Indicators', 'Quantitative')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>$projectIndicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="paragraph-two" style="margin-top: 0;"><?php echo e(toThaiNumber($index + 1)); ?>. <?php echo e(toThaiNumber($projectIndicator->Details_Indicators)); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <?php if($project->projectHasIndicators->where('indicators.Type_Indicators', 'Qualitative')->isNotEmpty()): ?>
            <p class="paragraph">เชิงคุณภาพ</p>
            <?php $__currentLoopData = $project->projectHasIndicators->where('indicators.Type_Indicators', 'Qualitative')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>$projectIndicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="paragraph-two" style="margin-top: 0;"><?php echo e(toThaiNumber($index + 1)); ?>. <?php echo e(toThaiNumber($projectIndicator->Details_Indicators)); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </p>

    <p class="space">
        <span><b>๑๐. สรุปผลการดำเนินงาน</b></span>
    <p style="text-indent: 70px; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; margin-top: 0;">
        <span><?php echo e($project->Summary); ?></span>
    </p>

    <p class="paragraph-content">
        <b>ผลสำเร็จตามตัวชี้วัดของโครงการ</b><br>
        <?php if($project->projectHasIndicators->where('indicators.Type_Indicators', 'Quantitative')->isNotEmpty()): ?>
            <p style="margin-left: 120px; margin-top: 0;">ตัวชี้วัดเชิงปริมาณ</p>
                <?php $__currentLoopData = $project->projectHasIndicators->where('indicators.Type_Indicators', 'Quantitative')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $projectIndicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p style="margin-left: 170px; margin-top: 0;"><?php echo e(toThaiNumber($index + 1)); ?>. <?php echo e(toThaiNumber($projectIndicator->Details_Indicators)); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <?php if($project->projectHasIndicators->where('indicators.Type_Indicators', 'Qualitative')->isNotEmpty()): ?>
            <p style="margin-left: 120px; margin-top: 0;">ตัวชี้วัดเชิงคุณภาพ</p>
            <?php $__currentLoopData = $project->projectHasIndicators->where('indicators.Type_Indicators', 'Qualitative')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>$projectIndicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p style="margin-left: 170px; margin-top: 0;"><?php echo e(toThaiNumber($index + 1)); ?>. <?php echo e(toThaiNumber($projectIndicator->Details_Indicators)); ?>

                </p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </p><br>

    
    <p class="paragraph-content">
        <b>การมีส่วนร่วมของหน่วยงานภายนอก/ชุมชน (ถ้ามี)</b>
        <p style="text-indent: 70px; margin: 0;">
            การดำเนินงาน <span><?php echo e(toThaiNumber($project->Name_Project)); ?></span> ได้มีหน่วยงานภายนอกและชุมชนเข้ามามีส่วนร่วม ในการดำเนินงานในด้านต่างๆ ดังนี้
        </p>
        <p style="text-indent: 70px; margin: 0;">
            <?php echo e($project->External_Participation); ?>

        </p>
    </p><br>

    <p class="paragraph-content">
        <b>งบประมาณ</b>
        <p style="text-indent: 70px; margin-top: 0;">
            <?php if(!empty($project) && $project->Status_Budget == 'Y'): ?>
                ใช้งบประมาณทั้งสิ้น <?php echo e(digits($totalExpense)); ?> บาท
            <?php else: ?>
                ไม่มีงบประมาณ
            <?php endif; ?>
        </p>
        
    </p><br>

    <p class="paragraph-content mt-3">
        <b>ข้อเสนอแนะ</b><br>
        <p style="text-indent: 70px; margin-top: 0;">
            <?php echo e($project->Suggestions); ?>

        </p>
    </p>


</p>

</body>

</html><?php /**PATH /app/resources/views/PDF/PDFReportForm.blade.php ENDPATH**/ ?>