<?php
use Carbon\Carbon;
Carbon::setLocale('th');
?>

<head>
    <meta charset="UTF-8">
    <title>แบบรายงานผลการดำเนินงานโครงการ</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/reportResult.css')); ?>">

    <style>
    * {
        font-family: 'Sarabun', sans-serif;
        box-sizing: border-box;
    }

    .report-container {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        text-align: center;
        margin-bottom: 40px;
        border-bottom: 2px solid #1e88e5;
        padding-bottom: 20px;
    }

    .header img {
        max-width: 250px; /* Increase the max-width to make the logo larger */
        margin-bottom: 20px;
    }

    .section {
        margin-bottom: 30px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 5px;
    }

    .section-title {
        color: #1e88e5;
        font-size: 1.2em;
        margin-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 5px;
    }

    .subsection {
        margin-left: 20px;
        margin-bottom: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        min-height: 40px;
    }

    textarea.form-control {
        min-height: 100px;
    }

    .table-container {
        margin: 20px 0;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #dee2e6;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f8f9fa;
    }

    .step-buttons {
        display: flex;
        gap: 20px;
        margin-top: 30px;
        justify-content: center;
    }

    .step-button {
        position: relative;
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .step-button::before {
        content: attr(data-step);
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 14px;
        color: #666;
    }

    .step-button.primary {
        background-color: #1e88e5;
        color: white;
    }

    .step-button.primary:hover:not(:disabled) {
        background-color: #1565c0;
    }

    .step-button.secondary {
        background-color: #757575;
        color: white;
    }

    .step-button.secondary:hover:not(:disabled) {
        background-color: #616161;
    }

    .step-button.secondary.active {
        background-color: #2e7d32;
        /* เปลี่ยนเป็นสีเขียว เมื่อปุ่มแรกถูกกด */
    }

    .step-button.secondary.active:hover:not(:disabled) {
        background-color: #1b5e20;
    }

    .step-button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .step-button i {
        font-size: 20px;
    }
    </style>
</head>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="report-container">
        <div class="header">
            <img src="<?php echo e(asset('images/logo_BUU_LIB.png')); ?>" alt="มหาวิทยาลัยบูรพา">
            <h1>แบบรายงานผลการดำเนินงานโครงการ</h1>
            <h2>สำนักหอสมุด มหาวิทยาลัยบูรพา</h2>
        </div>

        <div class="section">
            <div class="section-title">1. ข้อมูลโครงการ</div>
            <div class="form-group">
                <label>ชื่อโครงการ:</label>
                <input type="text" class="form-control" value="<?php echo e($project->Name_Project); ?>" readonly>
            </div>
            
        </div>

        <div class="section">
            <div class="section-title">2. ผู้รับผิดชอบโครงการ</div>
            <div class="form-group">
                <label>ผู้รับผิดชอบโครงการ:</label>
                
                <input type="text" class="form-control" 
                value="<?php echo e($project->employee->Prefix_Name); ?><?php echo e($project->employee->Firstname); ?> <?php echo e($project->employee->Lastname); ?>" readonly>
            </div>
        </div>


        <div class="section">
            <div class="section-title">3. วัตถุประสงค์</div>
            <div class="form-group">
                <textarea class="form-control"rows="5" readonly>
                    <?php $__currentLoopData = $project->objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($objective->Description_Objective); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </textarea>
            </div>
        </div>

        <div class="section">
            <div class="section-title">4. กลุ่มเป้าหมาย</div>
            <div class="form-group">
                <label>กลุ่มเป้าหมาย:</label>
                <?php $__currentLoopData = $project->targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" class="form-control mt-2" value="<?php echo e($target->Name_Target); ?>" style="flex: 2;" readonly>
                    <input type="text" class="form-control mt-2" value="<?php echo e($target->Quantity_Target); ?>" style="flex: 1; text-align: center;" readonly>
                    <input type="text" class="form-control mt-2" value="<?php echo e($target->Unit_Target); ?>" style="flex: 1;" readonly>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="form-group">
                <label>พื้นที่/ชุมชนเป้าหมาย (ถ้ามี ระบุ)</label>
                <div>
                    <?php $__currentLoopData = $project->targets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $target->targetDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="text" class="form-control" value="<?php echo e($detail->Details_Target); ?>" style="flex: 1;" readonly>  
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
            </div>
            
        </div>

        <div class="section">
            <div class="section-title">5. ระยะเวลาดำเนินงาน</div>
            <div class="form-group">
                <label>ระยะเวลาดำเนินงาน</label><br>
                <div>วันที่เริ่มต้น:</div>
                <input type="text" class="form-control mb-2" value="<?php echo e($project->formatted_first_time); ?>" readonly>
                <div>วันที่สิ้นสุด:</div>
                <input type="text" class="form-control mb-2" value="<?php echo e($project->formatted_end_time); ?>" readonly>
            </div>
        </div>

        <div class="section">
            <div class="section-title">6. สถานที่ดำเนินงาน</div>
            <div class="form-group">
                <label>สถานที่ดำเนินงาน:</label>
                <?php $__currentLoopData = $project->locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" class="form-control" value="<?php echo e($location->Name_Location); ?>" readonly><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="section">
            <div class="section-title">7. วิทยากร</div>
            <div class="form-group">
                <label>วิทยากร:</label>
                <input type="text" class="form-control" value="<?php echo e($project->Name_Speaker); ?>">
            </div>
        </div>

        <div class="section">
            <div class="section-title">8. รูปแบบกิจกรรมการดำเนินงาน</div>
            <?php if($project->Project_Type == 'S'): ?>

                <b>วิธีการดำเนินงาน</b><br>
                <p> 
                    <?php $__currentLoopData = $project->shortProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shortProject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            <?php echo e($loop->iteration); ?>. <?php echo e($shortProject->Details_Short_Project); ?><br>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </p>
            <?php else: ?>

                <p><b>ขั้นตอนและแผนการดำเนินงาน(PDCA)</b><br></p>
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

        </div>


        <div class="section">
            <div class="section-title">9. ตัวชี้วัดความสำเร็จ</div>

            <?php if($project->projectHasIndicators->where('indicators.Type_Indicators', 'Quantitative')->isNotEmpty()): ?>
                <label><b>เชิงปริมาณ</b></label>
                <?php $__currentLoopData = $project->projectHasIndicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectIndicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($projectIndicator->indicators && $projectIndicator->indicators->Type_Indicators === 'Quantitative'): ?>
                        <input type="text" class="form-control mb-2" value="<?php echo e($projectIndicator->Details_Indicators); ?>" readonly>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if($project->projectHasIndicators->where('indicators.Type_Indicators', 'Qualitative')->isNotEmpty()): ?>
                <label class="mt-3"><b>เชิงคุณภาพ</b></label>
                <?php $__currentLoopData = $project->projectHasIndicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectIndicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($projectIndicator->indicators && $projectIndicator->indicators->Type_Indicators === 'Qualitative'): ?>
                        <input type="text" class="form-control mb-2" value="<?php echo e($projectIndicator->Details_Indicators); ?>" readonly>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        <div class="section">
            <form action="<?php echo e(route('projects.complete', ['id' => $project->Id_Project])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('POST'); ?>

                <div class="section-title">10. สรุปผลการดำเนินงาน</div>
                    <div class="form-group">
                        <label><b>สรุปผล</b></label>
                        <?php if($project->approvals->first()->Status == 'Y'): ?>
                            <textarea class="form-control" rows="15" readonly><?php echo e($project->Summary); ?></textarea>
                        <?php else: ?>
                            <textarea class="form-control" name="Summary" rows="15"><?php echo e(old('Summary', $project->Summary)); ?></textarea>
                        <?php endif; ?>
                    </div>

                <div class="section-title">ผลสำเร็จตามตัวชี้วัดของโครงการ</div>
                    <?php if($project->projectHasIndicators->where('indicators.Type_Indicators', 'Quantitative')->isNotEmpty()): ?>
                        <label><b>ตัวชี้วัดเชิงปริมาณ</b></label>
                        <?php $__currentLoopData = $project->projectHasIndicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectIndicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($projectIndicator->indicators && $projectIndicator->indicators->Type_Indicators === 'Quantitative'): ?>
                                <input type="text" class="form-control mb-2" value="<?php echo e($projectIndicator->Details_Indicators); ?>" readonly>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php if($project->projectHasIndicators->where('indicators.Type_Indicators', 'Qualitative')->isNotEmpty()): ?>
                        <label class="mt-3"><b>ตัวชี้วัดเชิงคุณภาพ</b></label>
                        <?php $__currentLoopData = $project->projectHasIndicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectIndicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($projectIndicator->indicators && $projectIndicator->indicators->Type_Indicators === 'Qualitative'): ?>
                                <input type="text" class="form-control mb-2" value="<?php echo e($projectIndicator->Details_Indicators); ?>" readonly>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <div class="section-title mt-3">การมีส่วนร่วมของหน่วยงานภายนอก/ชุมชน</div>
                        <div class="form-group">
                            <label><b>การมีส่วนร่วมของบุคคลภายนอก</b></label>
                            <?php if($project->approvals->first()->Status == 'Y' ): ?>
                                <input type="text" class="form-control" value="<?php echo e($project->External_Participation); ?>" readonly>
                            <?php else: ?>
                                <textarea class="form-control" name="External_Participation"><?php echo e(old('External_Participation', $project->External_Participation)); ?></textarea>
                            <?php endif; ?>
                        </div>

                    <div class="section-title mt-3">งบประมาณ</div>
                    <?php if(!empty($project) && $project->Status_Budget == 'Y'): ?>
                        <label>งบประมาณที่ใช้ทั้งสิ้น:</label>
                    <?php else: ?>
                        <div>ไม่มีงบประมาณ</div>
                    <?php endif; ?> 

                    <div class="section-title mt-3">ข้อเสนอแนะ</div>
                    <div class="form-group">
                        <label><b>ข้อเสนอแนะ</b></label>
                        <?php if( $project->approvals->first()->Status == 'Y' ): ?>
                            <input type="text" class="form-control" value="<?php echo e($project->Suggestions); ?>" readonly>
                        <?php else: ?>
                            <textarea class="form-control" name="Suggestions"><?php echo e(old('Suggestions', $project->Suggestions)); ?></textarea>
                        <?php endif; ?>
                    </div>

                <div class="step-buttons">
                    <button type="submit" class="step-button primary" name="action" value="complete" style="height: 48px;" 
                        data-step="ขั้นตอนที่ 1" <?php echo e($project->approvals->first()->Status == 'Y' ? 'disabled' : ''); ?>>
                        <i class='bx bx-check-circle'></i> เสร็จสิ้น
                    </button>
            </form>
            <form id="submit-form" action="<?php echo e(route('projects.submitForApproval', ['id' => $project->Id_Project])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="status" value="Y">
                
                <button type="submit" class="step-button secondary" id="submit-button" data-step="ขั้นตอนที่ 2" 
                    <?php echo e($project->approvals->first()->Status == 'Y' ? '' : 'disabled'); ?>>
                    <i class='bx bx-log-in-circle'></i> เสนอเพื่อพิจารณา
                </button>
            </form>
                </div>
            
        </div>
    </div>
</div>

<script>
document.getElementById('complete-form').addEventListener('submit', function() {
    const submitButton = document.getElementById('submit-button');
    submitButton.disabled = false;
    submitButton.classList.add('active'); // เพิ่ม class active เมื่อปุ่มแรกถูกกด
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/ReportForm.blade.php ENDPATH**/ ?>