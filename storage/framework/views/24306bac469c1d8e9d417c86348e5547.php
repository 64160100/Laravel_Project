<hade>
    <link rel="stylesheet" href="<?php echo e(asset('css/createProject.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/createFirstForm.css')); ?>">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/i18n/datepicker-th.min.js"></script>


    <style>
    /* CSS สำหรับ inline editing */
    .editable-objective {
        cursor: pointer;
        padding: 5px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .editable-objective:hover {
        background-color: rgba(0, 123, 255, 0.05);
        position: relative;
    }

    .editable-objective:hover::after {
        content: "\f4c7";
        /* Boxicons bx-edit icon */
        font-family: 'boxicons' !important;
        display: inline-block;
        margin-left: 8px;
        font-size: 16px;
        color: #007bff;
        opacity: 0.7;
    }

    .editable-objective.editing {
        outline: none;
    }

    .editable-objective.saving {
        opacity: 0.7;
        background-color: #f8f9fa;
        position: relative;
    }

    .editable-objective.saving::after {
        content: "\eb2c";
        /* Boxicons bx-loader-alt icon */
        font-family: 'boxicons' !important;
        animation: spin 1s infinite linear;
        display: inline-block;
        margin-left: 8px;
        font-size: 16px;
        color: #007bff;
    }

    /* Animation for loading spinner */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Toast notification styling */
    .toast-notification {
        padding: 12px 20px;
        border-radius: 4px;
        color: white;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        min-width: 300px;
        max-width: 500px;
        opacity: 0;
        transform: translateY(20px);
        animation: toast-in 0.3s ease forwards;
    }

    .toast-notification.hide {
        animation: toast-out 0.3s ease forwards;
    }

    .output-field:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        background-color: #f8f9fa;
    }

    .output-field.saving {
        background-color: #f8f9fa !important;
        opacity: 0.7;
    }

    .save-success {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }

    .save-error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }

    @keyframes toast-in {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes toast-out {
        0% {
            opacity: 1;
            transform: translateY(0);
        }

        100% {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
    </style>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</hade>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card">
        <h3 class="card-header">กรอกข้อมูลโครงการ</h3>

        <form action="<?php echo e(route('projects.resetStatus', ['id' => $project->Id_Project])); ?>" method="POST"
            class="needs-validation" novalidate>
            <?php echo csrf_field(); ?>

            <div class="card-body">
                <!-- ชื่อโครงการ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            1. ชื่อโครงการ
                        </h4>
                    </div>
                    <div id="projectDetails">
                        <div class="form-group">
                            <label for="Name_Project" class="form-label">สร้างชื่อโครงการ</label>
                            <div class="editable" style="border: 1px solid #007bff; padding: px; border-radius: 5px;"
                                contenteditable="true"
                                onblur="saveData(this, '<?php echo e($project->Id_Project); ?>', 'Name_Project')"
                                onkeypress="checkEnter(event, this)">
                                <?php echo e($project->Name_Project); ?>

                            </div>
                            <?php $__errorArgs = ['Name_Project'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div id="projectContainer">
                            <?php echo csrf_field(); ?>
                        </div>
                    </div>
                </div>

                <!-- ผู้รับผิดชอบโครงการ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            2. ผู้รับผิดชอบโครงการ
                        </h4>
                    </div>
                    <div id="responsibleDetails">
                        <div class="form-group">
                            <label for="employee_id" class="form-label">เลือกผู้รับผิดชอบ</label>
                            <div class="editable-container">
                                <select class="form-select editable-select" id="employee_id" name="employee_id"
                                    onchange="saveEmployeeData(this, '<?php echo e($project->Id_Project); ?>', 'Employee_Id')">
                                    <option value="" disabled>เลือกผู้รับผิดชอบ</option>
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($employee->Id_Employee); ?>"
                                        <?php echo e($employee->Id_Employee == $project->Employee_Id ? 'selected' : ''); ?>>
                                        <?php echo e($employee->Firstname); ?> <?php echo e($employee->Lastname); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- ความสอดคล้องกับยุทธศาสตร์ส่วนงาน -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            3. ความสอดคล้องกับยุทธศาสตร์ส่วนงาน
                        </h4>
                    </div>
                    <div id="departmentStrategicDetails">
                        <div class="mb-3 col-md-6">
                            <div class="mb-3">
                                <label for="Name_Strategic_Plan" class="form-label">ชื่อแผนยุทธศาสตร์</label>
                                <input type="text" class="form-control" id="Name_Strategic_Plan"
                                    name="Name_Strategic_Plan" value="<?php echo e($nameStrategicPlan); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="Name_Strategy" class="form-label">กลยุทธ์</label>
                                <input type="text" class="form-control" id="Name_Strategy" name="Name_Strategy"
                                    value="<?php echo e($project->Name_Strategy); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ความสอดคล้องกับยุทธศาสตร์มหาวิทยาลัย -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            4. ความสอดคล้องกับยุทธศาสตร์มหาวิทยาลัย
                        </h4>
                    </div>
                    <div id="platform-container">
                        <?php if($platforms->isEmpty()): ?>
                        <div class="platform-card card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title m-0">แพลตฟอร์มที่ 1</h5>
                                <button type="button" class="btn btn-danger btn-sm remove-platform-btn"
                                    onclick="removePlatform(this)" style="display: none;">
                                    <i class='bx bx-trash'></i> <span class="d-none d-md-inline">ลบแพลตฟอร์ม</span>
                                </button>
                            </div>
                            <div class="card-body">
                                <!-- แพลตฟอร์ม -->
                                <div class="form-group mb-3">
                                    <label class="form-label">ชื่อแพลตฟอร์ม</label>
                                    <input type="text" class="form-control" name="platforms[0][name]"
                                        placeholder="กรุณากรอกชื่อแพลตฟอร์ม" value="">
                                    <input type="hidden" name="platforms[0][platform_id]" value="">
                                </div>

                                <!-- โปรแกรม -->
                                <div class="form-group mb-3">
                                    <label class="form-label">โปรแกรม</label>
                                    <input type="text" class="form-control" name="platforms[0][programs][0][name]"
                                        placeholder="กรุณากรอกชื่อโปรแกรม" value="">
                                    <input type="hidden" name="platforms[0][programs][0][program_id]" value="">
                                </div>

                                <!-- KPI -->
                                <div class="form-group kpi-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label m-0">KPI</label>
                                        <button type="button" class="btn btn-success btn-sm" onclick="addKpi(this)">
                                            <i class='bx bx-plus'></i> เพิ่ม KPI
                                        </button>
                                    </div>
                                    <div class="kpi-group">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text location-number">1</span>
                                                <input type="text" class="form-control"
                                                    name="platforms[0][programs][0][kpis][0][name]"
                                                    placeholder="กรุณากรอก KPI" value="">
                                                <input type="hidden" name="platforms[0][programs][0][kpis][0][kpi_id]"
                                                    value="">
                                                <button type="button" class="btn btn-danger btn-sm remove-field"
                                                    onclick="removeKpi(this)" style="display: none;">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="platform-card card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title m-0">แพลตฟอร์มที่ <?php echo e($index + 1); ?></h5>
                                <button type="button" class="btn btn-danger btn-sm remove-platform-btn"
                                    onclick="removePlatform(this)" style="<?php echo e($index == 0 ? 'display: none;' : ''); ?>">
                                    <i class='bx bx-trash'></i> <span class="d-none d-md-inline">ลบแพลตฟอร์ม</span>
                                </button>
                            </div>
                            <div class="card-body">
                                <!-- แพลตฟอร์ม -->
                                <div class="form-group mb-3">
                                    <label class="form-label">ชื่อแพลตฟอร์ม</label>
                                    <input type="text" class="form-control" name="platforms[<?php echo e($index); ?>][name]"
                                        value="<?php echo e($platform->Name_Platform); ?>">
                                    <input type="hidden" name="platforms[<?php echo e($index); ?>][platform_id]"
                                        value="<?php echo e($platform->Id_Platform); ?>">
                                </div>

                                <!-- โปรแกรมและ KPI -->
                                <?php if($platform->programs->isEmpty()): ?>
                                <!-- ถ้าไม่มีโปรแกรม ให้แสดงฟอร์มให้กรอกโปรแกรมและ KPI -->
                                <div class="form-group mb-3">
                                    <label class="form-label">โปรแกรม</label>
                                    <input type="text" class="form-control"
                                        name="platforms[<?php echo e($index); ?>][programs][0][name]"
                                        placeholder="กรุณากรอกชื่อโปรแกรม" value="">
                                    <input type="hidden" name="platforms[<?php echo e($index); ?>][programs][0][program_id]"
                                        value="">
                                </div>

                                <div class="form-group kpi-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label m-0">KPI</label>
                                        <button type="button" class="btn btn-success btn-sm" onclick="addKpi(this)"
                                            data-platform-index="<?php echo e($index); ?>" data-program-index="0">
                                            <i class='bx bx-plus'></i> เพิ่ม KPI
                                        </button>
                                    </div>
                                    <div class="kpi-group">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text location-number">1</span>
                                                <input type="text" class="form-control"
                                                    name="platforms[<?php echo e($index); ?>][programs][0][kpis][0][name]"
                                                    placeholder="กรุณากรอก KPI" value="">
                                                <input type="hidden"
                                                    name="platforms[<?php echo e($index); ?>][programs][0][kpis][0][kpi_id]"
                                                    value="">
                                                <button type="button" class="btn btn-danger btn-sm remove-field"
                                                    onclick="removeKpi(this)" style="display: none;">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <!-- ถ้ามีโปรแกรม ให้วนลูปแสดงโปรแกรมและ KPI -->
                                <?php $__currentLoopData = $platform->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $programIndex => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group mb-3">
                                    <label class="form-label">โปรแกรม</label>
                                    <input type="text" class="form-control"
                                        name="platforms[<?php echo e($index); ?>][programs][<?php echo e($programIndex); ?>][name]"
                                        value="<?php echo e($program->Name_Program); ?>">
                                    <input type="hidden"
                                        name="platforms[<?php echo e($index); ?>][programs][<?php echo e($programIndex); ?>][program_id]"
                                        value="<?php echo e($program->Id_Program); ?>">
                                </div>

                                <div class="form-group kpi-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label m-0">KPI</label>
                                        <button type="button" class="btn btn-success btn-sm" onclick="addKpi(this)"
                                            data-platform-index="<?php echo e($index); ?>" data-program-index="<?php echo e($programIndex); ?>">
                                            <i class='bx bx-plus'></i> เพิ่ม KPI
                                        </button>
                                    </div>
                                    <div class="kpi-group">
                                        <?php if($program->kpis->isEmpty()): ?>
                                        <!-- ถ้าไม่มี KPI ให้แสดงฟอร์มให้กรอก KPI -->
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="input-group">
                                                <span class="input-group-text location-number">1</span>
                                                <input type="text" class="form-control"
                                                    name="platforms[<?php echo e($index); ?>][programs][<?php echo e($programIndex); ?>][kpis][0][name]"
                                                    placeholder="กรุณากรอก KPI" value="">
                                                <input type="hidden"
                                                    name="platforms[<?php echo e($index); ?>][programs][<?php echo e($programIndex); ?>][kpis][0][kpi_id]"
                                                    value="">
                                                <button type="button" class="btn btn-danger btn-sm remove-field"
                                                    onclick="removeKpi(this)" style="display: none;">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <!-- ถ้ามี KPI ให้วนลูปแสดง KPI -->
                                        <?php $__currentLoopData = $program->kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kpiIndex => $kpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text location-number"><?php echo e($kpiIndex + 1); ?></span>
                                                <input type="text" class="form-control"
                                                    name="platforms[<?php echo e($index); ?>][programs][<?php echo e($programIndex); ?>][kpis][<?php echo e($kpiIndex); ?>][name]"
                                                    value="<?php echo e($kpi->Name_KPI); ?>">
                                                <input type="hidden"
                                                    name="platforms[<?php echo e($index); ?>][programs][<?php echo e($programIndex); ?>][kpis][<?php echo e($kpiIndex); ?>][kpi_id]"
                                                    value="<?php echo e($kpi->Id_KPI); ?>">
                                                <button type="button" class="btn btn-danger btn-sm remove-field"
                                                    onclick="removeKpi(this)"
                                                    style="<?php echo e($kpiIndex == 0 ? 'display: none;' : ''); ?>">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" onclick="addPlatform()">
                        <i class='bx bx-plus-circle'></i> เพิ่มแพลตฟอร์ม
                    </button>
                </div>

                <!-- SDGs -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            5. ความสอดคล้องกับ (SDGs)
                        </h4>
                    </div>
                    <div id="sdgsDetails" class="editable-container">
                        <div class="sdgs-grid">
                            <?php $__currentLoopData = $sdgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sdg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-group-sdgs">
                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input sdg-checkbox" type="checkbox"
                                        value="<?php echo e($sdg->id_SDGs); ?>" id="sdg_<?php echo e($sdg->id_SDGs); ?>"
                                        <?php echo e(in_array($sdg->id_SDGs, $selectedSdgs ?? []) ? 'checked' : ''); ?>

                                        onchange="saveSdgData(this, '<?php echo e($project->Id_Project); ?>', <?php echo e($sdg->id_SDGs); ?>)">
                                    <label class="form-check-label ml-2" for="sdg_<?php echo e($sdg->id_SDGs); ?>">
                                        <?php echo e($sdg->Name_SDGs); ?>

                                    </label>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="sdgs-status mt-2" id="sdgsStatus" style="display: none;">
                            <div class="d-flex align-items-center text-primary">
                                <i class='bx bx-loader-alt bx-spin me-2'></i> กำลังบันทึกการเปลี่ยนแปลง...
                            </div>
                        </div>
                    </div>
                </div>

                <!-- การบูรณาการงานโครงการ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            6. การบูรณาการงานโครงการ/กิจกรรม
                        </h4>
                    </div>
                    <div id="integrationDetails">
                        <div class="dropdown-container">
                            <div class="dropdown-options">
                                <?php $__currentLoopData = $integrationCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="option-item">
                                    <label>
                                        <input type="checkbox" class="integration-checkbox"
                                            data-category-id="<?php echo e($category->Id_Integration_Category); ?>"
                                            <?php echo e(in_array($category->Id_Integration_Category, $selectedIntegrations ?? []) ? 'checked' : ''); ?>

                                            onchange="saveIntegrationData(this, '<?php echo e($project->Id_Project); ?>', <?php echo e($category->Id_Integration_Category); ?>)">
                                        <?php echo e($category->Name_Integration_Category); ?>

                                    </label>
                                    <textarea class="additional-info" rows="2"
                                        id="integration_details_<?php echo e($category->Id_Integration_Category); ?>"
                                        name="integrationCategories[<?php echo e($category->Id_Integration_Category); ?>][details]"
                                        placeholder="ระบุข้อมูลเพิ่มเติม"
                                        <?php echo e(!in_array($category->Id_Integration_Category, $selectedIntegrations ?? []) ? 'disabled' : ''); ?>

                                        onblur="saveIntegrationDetails(this, '<?php echo e($project->Id_Project); ?>', <?php echo e($category->Id_Integration_Category); ?>)"
                                        style="width: 100%; resize: none;"><?php echo e($integrationDetails[$category->Id_Integration_Category] ?? ''); ?></textarea>
                                    <div class="integration-status text-primary"
                                        style="font-size: 0.8rem; margin-top: 3px; display: none;">
                                        <i class='bx bx-loader-alt bx-spin'></i> กำลังบันทึกข้อมูล...
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div id="integrationStatus"
                            style="display: none; background-color: #e9f7ff; padding: 8px; border-radius: 4px; margin-top: 10px;">
                            <div class="d-flex align-items-center text-primary">
                                <i class='bx bx-loader-alt bx-spin me-2'></i> กำลังบันทึกการเปลี่ยนแปลง...
                            </div>
                        </div>
                    </div>
                </div>
                <!-- หลักการและเหตุผล -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            7. หลักการและเหตุผล
                        </h4>
                    </div>
                    <div id="rationaleDetails" class="editable-container">
                        <div class="form-group">
                            <div class="editable"
                                style="border: 1px solid #ced4da; padding: 10px; border-radius: 5px; min-height: 300px;"
                                contenteditable="true"
                                onblur="saveData(this, '<?php echo e($project->Id_Project); ?>', 'Principles_Reasons')"
                                onkeypress="checkEnter(event, this)">
                                <?php echo e($project->Principles_Reasons); ?>

                            </div>
                            <?php $__errorArgs = ['Principles_Reasons'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- วัตถุประสงค์โครงการ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>8. วัตถุประสงค์โครงการ</h4>
                    </div>
                    <div id="objectiveDetails">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label fw-bold">วัตถุประสงค์โครงการ:</label>
                                    <div class="d-flex flex-column">
                                        <select class="form-control <?php $__errorArgs = ['objective_select'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="objective_select" name="objective_select">
                                            <option value="" disabled selected>เลือกวัตถุประสงค์โครงการ</option>
                                            <?php $__currentLoopData = $strategicObjectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($objective->id); ?>">
                                                <?php echo e($objective->Details_Strategic_Objectives); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="d-flex align-items-center mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                id="toggleObjectiveInput">
                                                <i class='bx bx-edit'></i> กรอกวัตถุประสงค์ด้วยตนเอง
                                            </button>
                                        </div>
                                        <textarea class="form-control mt-2" id="objective_manual"
                                            name="objective_manual" placeholder="กรอกวัตถุประสงค์โครงการด้วยตนเอง"
                                            style="display: none; resize: vertical;" rows="15"></textarea>
                                        <?php $__errorArgs = ['objective_select'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="addObjectiveBtn" class="btn btn-primary">
                            <i class='bx bx-plus-circle me-1'></i> เพิ่มวัตถุประสงค์
                        </button>

                        <div id="objectivesContainer" class="mt-3" data-project-id="<?php echo e($project->Id_Project); ?>">
                            <?php $__currentLoopData = $project->objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="objective-item mb-2 p-3 border rounded bg-light position-relative"
                                data-id="<?php echo e($objective->Id_Objective_Project); ?>">
                                <button type="button"
                                    class="btn-close position-absolute top-0 end-0 m-2 delete-objective"
                                    data-id="<?php echo e($objective->Id_Objective_Project); ?>"></button>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fw-bold mb-1">วัตถุประสงค์:</div>
                                        <div class="objective-text editable-objective"
                                            data-project-id="<?php echo e($project->Id_Project); ?>"
                                            data-objective-id="<?php echo e($objective->Id_Objective_Project); ?>"
                                            onclick="makeEditable(this)">
                                            <?php echo e($objective->Description_Objective); ?>

                                        </div>
                                        <input type="hidden" name="Objective_Project[]"
                                            value="<?php echo e($objective->Description_Objective); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- Template สำหรับสร้างรายการวัตถุประสงค์ใหม่ (ซ่อนไว้) -->
                <template id="objectiveItemTemplate">
                    <div class="objective-item mb-2 p-3 border rounded bg-light position-relative" data-id="__ID__">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 delete-objective"
                            data-id="__ID__"></button>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="fw-bold mb-1">วัตถุประสงค์:</div>
                                <div class="objective-text editable-objective"
                                    data-project-id="<?php echo e($project->Id_Project); ?>" data-objective-id="__ID__"
                                    onclick="makeEditable(this)">
                                    __OBJECTIVE__
                                </div>
                                <input type="hidden" name="Objective_Project[]" value="__OBJECTIVE_VALUE__">
                            </div>
                        </div>
                    </div>
                </template>

                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            9. วิทยากร
                        </h4>
                    </div>
                    <div id="speakerDetails">
                        <div class="form-group">
                            <label for="Name_Speaker" class="form-label">ชื่อวิทยากร</label>
                            <div id="Name_Speaker" class="editable"
                                style="border: 1px solid #007bff; padding: 8px; border-radius: 5px;"
                                contenteditable="true"
                                onblur="saveData(this, '<?php echo e($project->Id_Project); ?>', 'Name_Speaker')"
                                onkeypress="checkEnter(event, this)">
                                <?php if(empty($project->Name_Speaker)): ?>
                                <span class="placeholder-text" style="color: #6c757d;">กรุณากรอกชื่อวิทยากร</span>
                                <?php else: ?>
                                <?php echo e($project->Name_Speaker); ?>

                                <?php endif; ?>
                            </div>
                            <?php $__errorArgs = ['Name_Speaker'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- กลุ่มเป้าหมาย -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            10. กลุ่มเป้าหมาย
                        </h4>
                    </div>
                    <div id="targetGroupDetails">
                        <div id="targetGroupContainer" class="dynamic-container">
                            <div class="form-group target-group-item mt-2">
                                <div class="d-flex align-items-center">
                                    <div class="input-group">
                                        <span class="input-group-text target-group-number">1</span>
                                        <input type="text" class="form-control target-group-field" name="target_group[]"
                                            placeholder="กรอกกลุ่มเป้าหมาย" data-field-type="target-group"
                                            onkeydown="handleTargetGroupKeyDown(event, this)"
                                            onblur="cancelTargetGroupEdit(this)">
                                        <input type="number" class="form-control target-count-field"
                                            name="target_count[]" placeholder="จำนวน" data-field-type="target-count"
                                            onkeydown="handleTargetCountKeyDown(event, this)"
                                            onblur="cancelTargetCountEdit(this)">
                                        <input type="text" class="form-control target-unit-field" name="target_unit[]"
                                            placeholder="หน่วย" data-field-type="target-unit"
                                            onkeydown="handleTargetUnitKeyDown(event, this)"
                                            onblur="cancelTargetUnitEdit(this)">
                                        <button type="button" class="btn btn-danger btn-sm remove-field"
                                            onclick="removeTargetGroupField(this)" style="display: none;">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-addlist"
                            onclick="createAndAddTargetGroupField('targetGroupContainer', 'target_group[]', 'target_count[]', 'target_unit[]')">
                            <i class='bx bx-plus-circle'></i>เพิ่มกลุ่มเป้าหมาย
                        </button>

                        <div class="form-group mt-3">
                            <label>พื้นที่/ชุมชนเป้าหมาย (ถ้ามี ระบุ)</label>
                            <div class="form-check" style="display: flex; align-items: center;">
                                <input class="form-check-input" type="checkbox" id="targetAreaCheckbox"
                                    onchange="toggleTargetAreaDetails()">
                                <label class="form-check-label" for="targetAreaCheckbox"
                                    style="margin-left: 5px; margin-bottom: 0;">
                                    เลือกพื้นที่/ชุมชนเป้าหมาย
                                </label>
                            </div>
                            <div id="targetAreaDetails" style="display: none;">
                                <div class="form-group mt-3">
                                    <label>รายละเอียดกลุ่มเป้าหมาย <small>(กด Enter เพื่อบันทึก)</small></label>
                                    <textarea class="form-control target-details-field" name="target_details"
                                        placeholder="กรอกรายละเอียด"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- สถานที่ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            11. สถานที่ดำเนินงาน
                        </h4>
                    </div>
                    <div id="locationDetails">
                        <div id="locationContainer" class="dynamic-container">
                            <div class="form-group location-item mt-2">
                                <div class="d-flex align-items-center">
                                    <div class="input-group">
                                        <span class="input-group-text location-number">1</span>
                                        <input type="text" class="form-control location-field" name="location[]"
                                            placeholder="กรอกสถานที่" data-field-type="location"
                                            onkeydown="handleLocationKeyDown(event, this)"
                                            onblur="cancelLocationEdit(this)" style="min-width: 800px;">
                                        <button type="button" class="btn btn-danger btn-sm remove-field"
                                            style="display: none;">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-addlist"
                            onclick="createAndAddLocationField('locationContainer', 'location[]')">
                            <i class='bx bx-plus-circle'></i>เพิ่มสถานที่
                        </button>
                    </div>
                </div>

                <div class="content-box">
                    <div class="section-header">
                        <h4>12. ตัวชี้วัด</h4>
                    </div>
                    <div id="indicatorsDetails">
                        <div class="form-group-radio mt-3">
                            <div class="radio-group">
                                <input type="checkbox" name="goal[]" value="1" id="quantitative">
                                <label for="quantitative">เชิงปริมาณ</label>

                                <input type="checkbox" name="goal[]" value="2" id="qualitative">
                                <label for="qualitative">เชิงคุณภาพ</label>
                            </div>
                        </div>

                        <!-- ส่วนตัวชี้วัดเชิงปริมาณ -->
                        <div id="quantitative-inputs" class="goal-inputs" style="display: none;">
                            <h6>เชิงปริมาณ</h6>
                            <div id="quantitative-items" class="mt-3">
                                <div class="form-group location-item">
                                    <div class="d-flex align-items-center">
                                        <div class="input-group">
                                            <span class="input-group-text location-number">1</span>
                                            <input type="text" class="form-control indicator-field"
                                                name="quantitative[]" placeholder="เพิ่มรายการ"
                                                data-field-type="quantitative"
                                                onkeydown="handleIndicatorKeyDown(event, this, 'quantitative')"
                                                onblur="cancelIndicatorEdit(this, 'quantitative')">
                                            <button type="button" class="btn btn-danger btn-sm remove-field"
                                                onclick="removeIndicator(this, 'quantitative')" style="display: none;">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-addlist" onclick="addQuantitativeItem()">
                                <i class='bx bx-plus-circle'></i>เพิ่มรายการ
                            </button>
                        </div>

                        <!-- ส่วนตัวชี้วัดเชิงคุณภาพ -->
                        <div id="qualitative-inputs" class="goal-inputs" style="display: none;">
                            <h6>เชิงคุณภาพ</h6>
                            <div id="qualitative-items" class="mt-3">
                                <div class="form-group location-item">
                                    <div class="d-flex align-items-center">
                                        <div class="input-group">
                                            <span class="input-group-text location-number">1</span>
                                            <input type="text" class="form-control indicator-field" name="qualitative[]"
                                                placeholder="เพิ่มข้อความ" data-field-type="qualitative"
                                                onkeydown="handleIndicatorKeyDown(event, this, 'qualitative')"
                                                onblur="cancelIndicatorEdit(this, 'qualitative')">
                                            <button type="button" class="btn btn-danger btn-sm remove-field"
                                                onclick="removeIndicator(this, 'qualitative')" style="display: none;">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-addlist" onclick="addQualitativeItem()">
                                <i class='bx bx-plus-circle'></i>เพิ่มรายการ
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ระยะเวลาดำเนินโครงการ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            13. ระยะเวลาดำเนินโครงการ
                        </h4>
                    </div>
                    <div id="projectDurationDetails">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="First_Time">วันที่เริ่มต้น:</label>
                                    <input type="date" class="form-control editable-date" id="First_Time"
                                        name="First_Time" value="<?php echo e($project->First_Time); ?>" data-field="First_Time"
                                        data-project-id="<?php echo e($project->Id_Project); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="End_Time">วันที่สิ้นสุด:</label>
                                    <input type="date" class="form-control editable-date" id="End_Time" name="End_Time"
                                        value="<?php echo e($project->End_Time); ?>" data-field="End_Time"
                                        data-project-id="<?php echo e($project->Id_Project); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ขั้นตอนและแผนการดำเนินงาน -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            14. ขั้นตอนและแผนการดำเนินงาน (PDCA)
                        </h4>
                    </div>
                    <div id="planDetails">
                        <div class="form-group-radio mb-4">
                            <input type="radio" name="Project_Type" value="S" id="shortTermProject"
                                <?php echo e($project->Project_Type == 'S' ? 'checked' : ''); ?>>
                            <label for="shortTermProject">โครงการระยะสั้น</label>
                            &nbsp;&nbsp;
                            <input type="radio" name="Project_Type" value="L" id="longTermProject"
                                <?php echo e($project->Project_Type == 'L' ? 'checked' : ''); ?>>
                            <label for="longTermProject">โครงการระยะยาว</label>
                        </div>

                        <!-- วิธีการดำเนินงาน (สำหรับโครงการระยะสั้น) -->
                        <div id="shortProjectSection" class="<?php echo e($project->Project_Type != 'S' ? 'hidden' : ''); ?>">
                            <div class="method-form">
                                <div class="form-label">วิธีการดำเนินงาน</div>
                                <div id="methodContainer" class="method-items">
                                    <?php if(isset($project->shortProjects) && $project->shortProjects->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $project->shortProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $shortProject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group location-item mt-2">
                                        <div class="d-flex align-items-center">
                                            <div class="input-group">
                                                <span class="input-group-text location-number"><?php echo e($index + 1); ?></span>
                                                <input type="text" class="form-control method-field"
                                                    name="Details_Short_Project[]"
                                                    value="<?php echo e($shortProject->Details_Short_Project); ?>"
                                                    placeholder="เพิ่มรายการ">
                                                <button type="button" class="btn btn-danger btn-sm remove-field"
                                                    onclick="removeMethodField(this)"
                                                    <?php echo e($index == 0 ? 'style="display: none;"' : ''); ?>>
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <div class="form-group location-item mt-2">
                                        <div class="d-flex align-items-center">
                                            <div class="input-group">
                                                <span class="input-group-text location-number">1</span>
                                                <input type="text" class="form-control method-field"
                                                    name="Details_Short_Project[]" placeholder="เพิ่มรายการ">
                                                <button type="button" class="btn btn-danger btn-sm remove-field"
                                                    onclick="removeMethodField(this)" style="display: none;">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="btn-addlist" onclick="addMethodField()">
                                    <i class='bx bx-plus-circle'></i>เพิ่มรายการ
                                </button>
                            </div>
                        </div>

                        <!-- PDCA (สำหรับโครงการระยะยาว) -->
                        <div id="longProjectSection" class="<?php echo e($project->Project_Type != 'L' ? 'hidden' : ''); ?>">
                            <table class="table-PDCA">
                                <thead>
                                    <tr>
                                        <th rowspan="2">กิจกรรมและแผนการเบิกจ่ายงบประมาณ</th>
                                        <th colspan="12">ปีงบประมาณ พ.ศ. 2567</th>
                                    </tr>
                                    <tr>
                                        <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e($month); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Convert the JSON data to an associative array for easy lookup
                                    $pdcaData =
                                    collect(json_decode('[{"Id_PDCA_Stages_Details":9,"Details_PDCA":"saadasdas","PDCA_Stages_Id":1,"Project_Id":12},{"Id_PDCA_Stages_Details":10,"Details_PDCA":"dadasda","PDCA_Stages_Id":2,"Project_Id":12},{"Id_PDCA_Stages_Details":11,"Details_PDCA":"dasdsadasd","PDCA_Stages_Id":3,"Project_Id":12},{"Id_PDCA_Stages_Details":12,"Details_PDCA":"sadadasd","PDCA_Stages_Id":4,"Project_Id":12}]',
                                    true));

                                    $monthlyPlansData =
                                    collect(json_decode('[{"Id_Monthly_Plans":25,"Project_Id":12,"Months_Id":1,"PDCA_Stages_Id":1,"Fiscal_Year":2025},{"Id_Monthly_Plans":26,"Project_Id":12,"Months_Id":7,"PDCA_Stages_Id":1,"Fiscal_Year":2025},{"Id_Monthly_Plans":27,"Project_Id":12,"Months_Id":2,"PDCA_Stages_Id":2,"Fiscal_Year":2025},{"Id_Monthly_Plans":28,"Project_Id":12,"Months_Id":6,"PDCA_Stages_Id":2,"Fiscal_Year":2025},{"Id_Monthly_Plans":29,"Project_Id":12,"Months_Id":8,"PDCA_Stages_Id":2,"Fiscal_Year":2025},{"Id_Monthly_Plans":30,"Project_Id":12,"Months_Id":12,"PDCA_Stages_Id":2,"Fiscal_Year":2026},{"Id_Monthly_Plans":31,"Project_Id":12,"Months_Id":3,"PDCA_Stages_Id":3,"Fiscal_Year":2025},{"Id_Monthly_Plans":32,"Project_Id":12,"Months_Id":5,"PDCA_Stages_Id":3,"Fiscal_Year":2025},{"Id_Monthly_Plans":33,"Project_Id":12,"Months_Id":9,"PDCA_Stages_Id":3,"Fiscal_Year":2025},{"Id_Monthly_Plans":34,"Project_Id":12,"Months_Id":11,"PDCA_Stages_Id":3,"Fiscal_Year":2026},{"Id_Monthly_Plans":35,"Project_Id":12,"Months_Id":4,"PDCA_Stages_Id":4,"Fiscal_Year":2025},{"Id_Monthly_Plans":36,"Project_Id":12,"Months_Id":10,"PDCA_Stages_Id":4,"Fiscal_Year":2026}]',
                                    true));

                                    // Group PDCA data by PDCA stage ID
                                    $pdcaByStage = $pdcaData->keyBy('PDCA_Stages_Id');

                                    // Group monthly plans by PDCA stage ID and create a lookup for checked months
                                    $checkedMonths = [];
                                    foreach ($monthlyPlansData as $plan) {
                                    if (!isset($checkedMonths[$plan['PDCA_Stages_Id']])) {
                                    $checkedMonths[$plan['PDCA_Stages_Id']] = [];
                                    }
                                    $checkedMonths[$plan['PDCA_Stages_Id']][] = $plan['Months_Id'];
                                    }
                                    ?>

                                    <?php $__currentLoopData = $pdcaStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="PDCA">
                                            <div class="plan-text"><?php echo e($stage->Name_PDCA); ?></div>
                                            <textarea class="form-control plan-textarea"
                                                name="pdca[<?php echo e($stage->Id_PDCA_Stages); ?>][detail]"
                                                placeholder="เพิ่มรายละเอียด"><?php echo e(isset($pdcaByStage[$stage->Id_PDCA_Stages]) ? $pdcaByStage[$stage->Id_PDCA_Stages]['Details_PDCA'] : ''); ?></textarea>
                                        </td>
                                        <?php for($i = 1; $i <= 12; $i++): ?> <td class="checkbox-container">
                                            <input type="checkbox" name="pdca[<?php echo e($stage->Id_PDCA_Stages); ?>][months][]"
                                                value="<?php echo e($i); ?>"
                                                <?php echo e(isset($checkedMonths[$stage->Id_PDCA_Stages]) && in_array($i, $checkedMonths[$stage->Id_PDCA_Stages]) ? 'checked' : ''); ?>>
                                            </td>
                                            <?php endfor; ?>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- แหล่งงบประมาณ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            15. แหล่งงบประมาณ
                        </h4>
                    </div>
                    <div id="budgetDetails">
                        <div class="form-group-radio mb-3">
                            <div class="radio-group">
                                <input type="radio" name="Status_Budget" value="N" id="non_income"
                                    onchange="toggleIncomeForm(this)"
                                    <?php echo e($project->projectBudgetSources->isEmpty() ? 'checked' : ''); ?>>
                                <label for="non_income">ไม่ใช้งบประมาณ</label>

                                <input type="radio" name="Status_Budget" value="Y" id="income_seeking"
                                    onchange="toggleIncomeForm(this)"
                                    <?php echo e(!$project->projectBudgetSources->isEmpty() ? 'checked' : ''); ?>>
                                <label for="income_seeking">ใช้งบประมาณ</label>
                            </div>
                        </div>

                        <div id="incomeForm" class="income-form"
                            style="display: <?php echo e(!$project->projectBudgetSources->isEmpty() ? 'block' : 'none'); ?>;">
                            <!-- แหล่งที่มาของงบประมาณ -->
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold">แหล่งที่มาของงบประมาณ:</label>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <?php $__currentLoopData = $budgetSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        $projectBudgetSource = $projectBudgetSources->where('Budget_Source_Id',
                                        $source->Id_Budget_Source)->first();
                                        $amount = ($projectBudgetSource && $projectBudgetSource->budgetSourceTotal) ?
                                        $projectBudgetSource->budgetSourceTotal->Amount_Total : 0;
                                        ?>
                                        <div class="form-check mb-2 d-flex align-items-center">
                                            <input type="checkbox" id="<?php echo e($source->Id_Budget_Source); ?>"
                                                name="budget_source[]" value="<?php echo e($source->Id_Budget_Source); ?>"
                                                class="form-check-input" data-id="<?php echo e($source->Id_Budget_Source); ?>"
                                                onchange="handleSourceCheckbox(this)"
                                                <?php echo e($projectBudgetSource ? 'checked' : ''); ?>>
                                            <label class="form-check-label d-flex align-items-center w-100"
                                                for="<?php echo e($source->Id_Budget_Source); ?>">
                                                <span class="label-text me-2"><?php echo e($source->Name_Budget_Source); ?></span>
                                                <div class="input-group" style="max-width: 200px;">
                                                    <input type="number" name="amount_<?php echo e($source->Id_Budget_Source); ?>"
                                                        class="form-control form-control-sm" placeholder="จำนวนเงิน"
                                                        value="<?php echo e($amount); ?>"
                                                        <?php echo e($projectBudgetSource ? '' : 'disabled'); ?>>
                                                    <span class="input-group-text">บาท</span>
                                                </div>
                                            </label>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- ตารางงบประมาณแบบกรอกข้อมูล -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold">รายละเอียดงบประมาณ:</label>
                                        <div class="form-group-radio mb-3">
                                            <label class="form-label">ระยะเวลาการใช้งบประมาณ:</label>
                                            <div class="radio-group">
                                                <input type="radio" name="date_type" value="O" id="single_day"
                                                    onchange="toggleDateForm(this)"
                                                    <?php echo e(count($expenses) <= 1 ? 'checked' : ''); ?>>
                                                <label for="single_day">วันเดียว</label>

                                                <input type="radio" name="date_type" value="M" id="multiple_days"
                                                    onchange="toggleDateForm(this)"
                                                    <?php echo e(count($expenses) > 1 ? 'checked' : ''); ?>>
                                                <label for="multiple_days">หลายวัน</label>
                                            </div>
                                        </div>

                                        <!-- แบบฟอร์มงบประมาณตามวันที่ (อยู่ในกรอบเดียวกัน) -->
                                        <div class="mt-4">
                                            <div id="budgetFormsContainer">
                                                <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expenseIndex => $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div id="budgetFormTemplate" class="budget-form mb-4 pb-3 border-bottom"
                                                    data-form-index="<?php echo e($expenseIndex); ?>">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div style="flex: 1;">
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-3">
                                                                    <label class="form-label">วันที่ดำเนินการ</label>
                                                                    <input type="date" name="date[]"
                                                                        class="form-control" style="width: 200px;"
                                                                        value="<?php echo e($expense->Date_Expense ?? ''); ?>">
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <label
                                                                        class="form-label">รายละเอียดค่าใช้จ่ายสำหรับวันนี้</label>
                                                                    <textarea name="budget_details[]"
                                                                        class="form-control"
                                                                        placeholder="ระบุรายละเอียดค่าใช้จ่ายสำหรับวันที่นี้"
                                                                        rows="2"><?php echo e($expense->Details_Expense ?? ''); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ms-2">
                                                            <button type="button"
                                                                class="btn btn-warning btn-sm reset-form-btn"
                                                                onclick="resetBudgetForm(this)">
                                                                <i class="bx bx-reset"></i> รีเซ็ตข้อมูล
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-form-btn ms-2"
                                                                onclick="removeBudgetForm(this)"
                                                                style="display: <?php echo e(count($expenses) > 1 ? 'inline-block' : 'none'); ?>;">
                                                                <i class="bx bx-trash"></i> ลบวันที่นี้
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- ตารางงบประมาณรวม -->
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th style="width: 5%;">ลำดับ</th>
                                                                    <th style="width: 25%;">หมวดหมู่</th>
                                                                    <th>รายการ</th>
                                                                    <th style="width: 20%;">จำนวน (บาท)</th>
                                                                    <th style="width: 5%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody
                                                                id="<?php echo e($expenseIndex == 0 ? 'budget_categories_container' : 'budget_categories_container_'.$expenseIndex); ?>"
                                                                class="<?php echo e($expenseIndex == 0 ? '' : 'day-categories-container'); ?>"
                                                                data-day-index="<?php echo e($expenseIndex); ?>">
                                                                <?php
                                                                $expenseSubtopicsGroup =
                                                                isset($expenseSubtopics[$expense->Id_Expense])
                                                                ?
                                                                $expenseSubtopics[$expense->Id_Expense]->groupBy('Subtopic_Budget_Id')
                                                                : collect([]);
                                                                ?>

                                                                <?php $__empty_2 = true; $__currentLoopData = $expenseSubtopicsGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtopicId =>
                                                                $subtopicGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                <tr class="category-row"
                                                                    id="<?php echo e($expenseIndex == 0 ? 'category-row-'.$loop->index : ''); ?>"
                                                                    data-row-id="<?php echo e($loop->index); ?>"
                                                                    <?php echo e($expenseIndex > 0 ? 'data-day-id='.$expenseIndex : ''); ?>>
                                                                    <td class="align-middle text-center">
                                                                        <?php echo e($loop->index + 1); ?></td>
                                                                    <td class="align-middle">
                                                                        <select class="form-select category-select"
                                                                            name="<?php echo e($expenseIndex == 0 ? 'budget_category[0][]' : 'budget_category['.$expenseIndex.'][]'); ?>"
                                                                            data-row-id="<?php echo e($loop->index); ?>"
                                                                            onchange="<?php echo e($expenseIndex == 0 ? 'handleCategorySelect(this)' : 'handleDayCategorySelect(this, '.$expenseIndex.')'); ?>">
                                                                            <option value="" disabled>เลือกหมวดหมู่
                                                                            </option>
                                                                            <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>
                                                                            $categoryName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($index); ?>"
                                                                                <?php echo e($subtopicId == $index ? 'selected' : ''); ?>>
                                                                                <?php echo e($categoryName); ?>

                                                                            </option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                    </td>

                                                                    <td class="align-middle">
                                                                        <strong><?php echo e($mainCategories[$subtopicId] ?? ''); ?></strong>
                                                                        <input type="hidden"
                                                                            name="<?php echo e($expenseIndex == 0 ? 'category_0[]' : 'category_'.$expenseIndex.'[]'); ?>"
                                                                            value="<?php echo e($subtopicId); ?>">

                                                                        <div class="items-container pl-3 mt-2"
                                                                            id="<?php echo e($subtopicId); ?>_items_<?php echo e($expenseIndex > 0 ? 'day'.$expenseIndex.'_' : ''); ?><?php echo e($loop->index); ?>">
                                                                            <?php $__currentLoopData = $subtopicGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtopic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="budget-item mb-2">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div style="flex: 3;">
                                                                                        <input type="text"
                                                                                            name="<?php echo e($expenseIndex == 0 ? 'item_desc['.$subtopicId.']['.$loop->parent->index.'][]' : 'item_desc_'.$expenseIndex.'['.$subtopicId.']['.$loop->parent->index.'][]'); ?>"
                                                                                            class="form-control mb-1"
                                                                                            placeholder="รายละเอียดรายการ"
                                                                                            value="<?php echo e($subtopic->Details_Expense_Budget); ?>">
                                                                                    </div>
                                                                                    <div
                                                                                        style="flex: 1; padding-left: 10px;">
                                                                                        <input type="number"
                                                                                            name="<?php echo e($expenseIndex == 0 ? 'item_amount['.$subtopicId.']['.$loop->parent->index.'][]' : 'item_amount_'.$expenseIndex.'['.$subtopicId.']['.$loop->parent->index.'][]'); ?>"
                                                                                            class="form-control <?php echo e($expenseIndex == 0 ? 'calculation-input' : 'day-calculation-input'); ?>"
                                                                                            data-category="<?php echo e($subtopicId); ?>"
                                                                                            <?php echo e($expenseIndex == 0 ? 'data-row-id='.$loop->parent->index : 'data-day='.$expenseIndex.' data-row='.$loop->parent->index); ?>

                                                                                            value="<?php echo e($subtopic->Amount_Expense_Budget); ?>"
                                                                                            onkeyup="<?php echo e($expenseIndex == 0 ? 'calculateRowTotal(\''.$subtopicId.'\', '.$loop->parent->index.')' : 'calculateDayRowTotal(\''.$subtopicId.'\', '.$expenseIndex.', '.$loop->parent->index.')'); ?>">
                                                                                    </div>
                                                                                    <div style="margin-left: 10px;">
                                                                                        <button type="button"
                                                                                            class="btn btn-sm btn-danger"
                                                                                            onclick="<?php echo e($expenseIndex == 0 ? 'removeItem(this, \''.$subtopicId.'\', '.$loop->parent->index.')' : 'removeDayItem(this, \''.$subtopicId.'\', '.$expenseIndex.', '.$loop->parent->index.')'); ?>">
                                                                                            <i class="bx bx-trash"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </div>

                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-primary mt-2"
                                                                            onclick="<?php echo e($expenseIndex == 0 ? 'addBudgetItem(\''.$subtopicId.'_items_'.$loop->index.'\', \''.$subtopicId.'\', '.$loop->index.')' : 'addDayBudgetItem(\''.$subtopicId.'_items_day'.$expenseIndex.'_'.$loop->index.'\', \''.$subtopicId.'\', '.$expenseIndex.', '.$loop->index.')'); ?>">
                                                                            <i class="bx bx-plus"></i> เพิ่มรายการ
                                                                        </button>
                                                                    </td>

                                                                    <td class="text-center align-middle">
                                                                        <span
                                                                            id="<?php echo e($expenseIndex == 0 ? 'total_'.$subtopicId.'_'.$loop->index : 'total_'.$subtopicId.'_day'.$expenseIndex.'_'.$loop->index); ?>"
                                                                            class="total-category">
                                                                            <?php echo e(number_format($subtopicGroup->sum('Amount_Expense_Budget'), 0)); ?>

                                                                        </span>
                                                                    </td>

                                                                    <td class="align-middle text-center">
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-danger"
                                                                            onclick="<?php echo e($expenseIndex == 0 ? 'removeCategoryRow(this)' : 'removeDayCategoryRow(this)'); ?>"
                                                                            style="display: <?php echo e($expenseSubtopicsGroup->count() > 1 ? 'inline-block' : 'none'); ?>;">
                                                                            <i class="bx bx-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                <!-- แถวว่างในกรณีไม่มีข้อมูล -->
                                                                <tr class="category-row"
                                                                    id="<?php echo e($expenseIndex == 0 ? 'category-row-0' : ''); ?>"
                                                                    data-row-id="0"
                                                                    <?php echo e($expenseIndex > 0 ? 'data-day-id='.$expenseIndex : ''); ?>>
                                                                    <td class="align-middle text-center">1</td>
                                                                    <td class="align-middle">
                                                                        <select class="form-select category-select"
                                                                            name="<?php echo e($expenseIndex == 0 ? 'budget_category[0][]' : 'budget_category['.$expenseIndex.'][]'); ?>"
                                                                            data-row-id="0"
                                                                            onchange="<?php echo e($expenseIndex == 0 ? 'handleCategorySelect(this)' : 'handleDayCategorySelect(this, '.$expenseIndex.')'); ?>">
                                                                            <option value="" selected disabled>
                                                                                เลือกหมวดหมู่</option>
                                                                            <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>
                                                                            $categoryName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($index); ?>">
                                                                                <?php echo e($categoryName); ?>

                                                                            </option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                    </td>

                                                                    <td colspan="2" class="align-middle text-center">
                                                                        <span
                                                                            class="text-muted">โปรดเลือกหมวดหมู่ก่อน</span>
                                                                    </td>

                                                                    <td class="align-middle text-center">
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-danger"
                                                                            onclick="<?php echo e($expenseIndex == 0 ? 'removeCategoryRow(this)' : 'removeDayCategoryRow(this)'); ?>"
                                                                            style="display: none;">
                                                                            <i class="bx bx-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="5">
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary"
                                                                            onclick="<?php echo e($expenseIndex == 0 ? 'addCategoryRow()' : 'addDayCategoryRow('.$expenseIndex.')'); ?>">
                                                                            <i class="bx bx-plus-circle"></i>
                                                                            เพิ่มหมวดหมู่
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-light font-weight-bold">
                                                                    <td colspan="3" class="text-end">รวมทั้งสิ้น</td>
                                                                    <td class="text-center">
                                                                        <span
                                                                            id="<?php echo e($expenseIndex == 0 ? 'grand_total' : 'day_total_'.$expenseIndex); ?>"
                                                                            class="<?php echo e($expenseIndex == 0 ? '' : 'day-total'); ?>">
                                                                            <?php echo e(number_format($expenseTotalsByDay[$expense->Id_Expense] ?? 0, 0)); ?>

                                                                        </span> บาท
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <!-- แสดงฟอร์มว่างถ้าไม่มีข้อมูล -->
                                                <div id="budgetFormTemplate" class="budget-form mb-4 pb-3 border-bottom"
                                                    data-form-index="0">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div style="flex: 1;">
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-3">
                                                                    <label class="form-label">วันที่ดำเนินการ</label>
                                                                    <input type="date" name="date[]"
                                                                        class="form-control" style="width: 200px;">
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <label
                                                                        class="form-label">รายละเอียดค่าใช้จ่ายสำหรับวันนี้</label>
                                                                    <textarea name="budget_details[]"
                                                                        class="form-control"
                                                                        placeholder="ระบุรายละเอียดค่าใช้จ่ายสำหรับวันที่นี้"
                                                                        rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ms-2">
                                                            <button type="button"
                                                                class="btn btn-warning btn-sm reset-form-btn"
                                                                onclick="resetBudgetForm(this)">
                                                                <i class="bx bx-reset"></i> รีเซ็ตข้อมูล
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-form-btn ms-2"
                                                                onclick="removeBudgetForm(this)" style="display: none;">
                                                                <i class="bx bx-trash"></i> ลบวันที่นี้
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- ตารางงบประมาณรวม -->
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th style="width: 5%;">ลำดับ</th>
                                                                    <th style="width: 25%;">หมวดหมู่</th>
                                                                    <th>รายการ</th>
                                                                    <th style="width: 20%;">จำนวน (บาท)</th>
                                                                    <th style="width: 5%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="budget_categories_container">
                                                                <!-- แถวแรกสำหรับเลือกหมวดหมู่ -->
                                                                <tr class="category-row" id="category-row-0"
                                                                    data-row-id="0">
                                                                    <td class="align-middle text-center">1</td>
                                                                    <td class="align-middle">
                                                                        <select class="form-select category-select"
                                                                            name="budget_category[0][]" data-row-id="0"
                                                                            onchange="handleCategorySelect(this)">
                                                                            <option value="" selected disabled>
                                                                                เลือกหมวดหมู่</option>
                                                                            <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>
                                                                            $categoryName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($index); ?>">
                                                                                <?php echo e($categoryName); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                    </td>

                                                                    <td colspan="2" class="align-middle text-center">
                                                                        <span
                                                                            class="text-muted">โปรดเลือกหมวดหมู่ก่อน</span>
                                                                    </td>

                                                                    <td class="align-middle text-center">
                                                                        <!-- ปุ่มลบในแถวแรกจะถูกซ่อนไว้ -->
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-danger"
                                                                            onclick="removeCategoryRow(this)"
                                                                            style="display: none;">
                                                                            <i class="bx bx-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="5">
                                                                        <button type="button"
                                                                            class="btn btn-outline-primary"
                                                                            onclick="addCategoryRow()">
                                                                            <i class="bx bx-plus-circle"></i>
                                                                            เพิ่มหมวดหมู่
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                                <tr class="bg-light font-weight-bold">
                                                                    <td colspan="3" class="text-end">รวมทั้งสิ้น</td>
                                                                    <td class="text-center">
                                                                        <span id="grand_total">0</span> บาท
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- ปุ่มเพิ่มแบบฟอร์ม (สำหรับหลายวัน) -->
                                        <div class="mt-3 mb-3" id="addBudgetFormBtnContainer"
                                            style="display: <?php echo e(count($expenses) > 1 ? 'block' : 'none'); ?>;">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="addBudgetForm()">
                                                <i class="bx bx-plus"></i> เพิ่มข้อมูลวันอื่น
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- เพิ่ม Hidden input สำหรับ Expense Status -->
                <input type="hidden" name="Expense_Status" value="<?php echo e($expenseStatus ?? 'O'); ?>">

                <!-- Output -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            16. เป้าหมายเชิงผลผลิต (Output)
                        </h4>
                    </div>
                    <div id="outputDetails">
                        <div id="outputContainer" class="dynamic-container">
                            <div class="form-group location-item mt-2">
                                <div class="d-flex align-items-center">
                                    <div class="input-group">
                                        <span class="input-group-text location-number">1</span>
                                        <input type="text" class="form-control output-field" name="outputs[]"
                                            placeholder="เพิ่มรายการ" data-field-type="output"
                                            onkeydown="handleOutputKeyDown(event, this)" onblur="cancelEdit(this)">
                                        <button type="button" class="btn btn-danger btn-sm remove-field"
                                            style="display: none;">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-addlist"
                            onclick="createAndAddField('outputContainer', 'outputs[]')">
                            <i class='bx bx-plus-circle'></i>เพิ่มรายการ
                        </button>
                    </div>
                </div>

                <!-- Outcome -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            17. เป้าหมายเชิงผลลัพธ์ (Outcome)
                        </h4>
                    </div>
                    <div id="outcomeDetails">
                        <div id="outcomeContainer" class="dynamic-container">
                            <div class="form-group location-item mt-2">
                                <div class="d-flex align-items-center">
                                    <div class="input-group">
                                        <span class="input-group-text location-number">1</span>
                                        <input type="text" class="form-control outcome-field" name="outcomes[]"
                                            placeholder="เพิ่มรายการ" data-field-type="outcome"
                                            onkeydown="handleOutcomeKeyDown(event, this)"
                                            onblur="cancelOutcomeEdit(this)">
                                        <button type="button" class="btn btn-danger btn-sm remove-field"
                                            style="display: none;">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-addlist"
                            onclick="createAndAddOutcomeField('outcomeContainer', 'outcomes[]')">
                            <i class='bx bx-plus-circle'></i>เพิ่มรายการ
                        </button>
                    </div>
                </div>

                <!-- ผลที่คาดว่าจะได้รับ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            18. ผลที่คาดว่าจะได้รับ
                        </h4>
                    </div>
                    <div id="resultDetails">
                        <div id="resultContainer" class="dynamic-container">
                            <div class="form-group location-item mt-2">
                                <div class="d-flex align-items-center">
                                    <div class="input-group">
                                        <span class="input-group-text location-number">1</span>
                                        <input type="text" class="form-control result-field" name="expected_results[]"
                                            placeholder="เพิ่มรายการ" data-field-type="result"
                                            onkeydown="handleResultKeyDown(event, this)"
                                            onblur="cancelResultEdit(this)">
                                        <button type="button" class="btn btn-danger btn-sm remove-field"
                                            style="display: none;">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-addlist"
                            onclick="createAndAddResultField('resultContainer', 'expected_results[]')">
                            <i class='bx bx-plus-circle'></i>เพิ่มรายการ
                        </button>
                    </div>
                </div>

                <!-- ตัวชี้วัดความสำเร็จของโครงการและค่าเป้าหมาย (รวมเป็นหัวข้อเดียว) -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            19. ตัวชี้วัดความสำเร็จของโครงการและค่าเป้าหมาย
                        </h4>
                    </div>

                    <!-- ฟอร์มเพิ่มตัวชี้วัดและค่าเป้าหมาย -->
                    <div id="indicatorForm">
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="form-label fw-bold">ตัวชี้วัดความสำเร็จของโครงการ:</label>
                                    <div class="d-flex flex-column">
                                        <select class="form-control <?php $__errorArgs = ['Success_Indicators'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="Success_Indicators" name="Success_Indicators">
                                            <option value="" disabled selected>กรอกตัวชี้วัดความสำเร็จของโครงการ
                                            </option>
                                            <?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($kpi->Name_Kpi); ?>"
                                                data-strategy-id="<?php echo e($kpi->Strategy_Id); ?>"
                                                data-target-value="<?php echo e($kpi->Target_Value); ?>">
                                                <?php echo e($kpi->Name_Kpi); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="d-flex align-items-center mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                id="toggleIndicatorInput">
                                                <i class='bx bx-edit'></i> กรอกตัวชี้วัดด้วยตนเอง
                                            </button>
                                        </div>
                                        <textarea class="form-control mt-2" id="Success_Indicators_Other"
                                            name="Success_Indicators_Other"
                                            placeholder="กรอกตัวชี้วัดความสำเร็จด้วยตนเอง"
                                            style="display: none;"></textarea>
                                        <?php $__errorArgs = ['Success_Indicators'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- ส่วนของค่าเป้าหมาย -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label fw-bold">ค่าเป้าหมาย:</label>
                                    <div class="d-flex flex-column">
                                        <select class="form-control <?php $__errorArgs = ['Value_Target'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="Value_Target" name="Value_Target">
                                            <option value="" disabled selected>กรอกค่าเป้าหมาย</option>
                                        </select>
                                        <div class="d-flex align-items-center mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                id="toggleTargetInput">
                                                <i class='bx bx-edit'></i> กรอกค่าเป้าหมายด้วยตนเอง
                                            </button>
                                        </div>
                                        <textarea class="form-control mt-2" id="Value_Target_Other"
                                            name="Value_Target_Other" placeholder="กรอกค่าเป้าหมายด้วยตนเอง"
                                            style="display: none;"></textarea>
                                        <?php $__errorArgs = ['Value_Target'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="addIndicatorBtn" class="btn btn-primary">
                            <i class='bx bx-plus-circle me-1'></i> เพิ่มตัวชี้วัดและค่าเป้าหมาย
                        </button>

                        <div id="indicatorsContainer" class="mt-3">
                            <?php if(isset($project->successIndicators) && $project->successIndicators->isNotEmpty()): ?>
                            <?php $__currentLoopData = $project->successIndicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="indicator-item mb-2 p-3 border rounded bg-light position-relative">
                                <button type="button"
                                    class="btn-close position-absolute top-0 end-0 m-2 delete-indicator"
                                    data-id="<?php echo e($indicator->Id_Success_Indicators); ?>"></button>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="fw-bold mb-1">ตัวชี้วัดความสำเร็จ:</div>
                                        <div class="indicator-text"><?php echo e($indicator->Description_Indicators); ?></div>
                                        <input type="hidden" name="indicators[]"
                                            value="<?php echo e($indicator->Description_Indicators); ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <div class="fw-bold mb-1">ค่าเป้าหมาย:</div>
                                        <div class="target-value">
                                            <?php echo e($indicator->valueTargets->first()->Value_Target ?? ''); ?></div>
                                        <input type="hidden" name="targets[]"
                                            value="<?php echo e($indicator->valueTargets->first()->Value_Target ?? ''); ?>">
                                        <input type="hidden" name="target_types[]"
                                            value="<?php echo e($indicator->Type_Indicators); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Template สำหรับสร้างรายการตัวชี้วัดใหม่ (ซ่อนไว้) -->
                <template id="indicatorItemTemplate">
                    <div class="indicator-item mb-2 p-3 border rounded bg-light position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 delete-indicator"
                            data-id="__ID__"></button>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="fw-bold mb-1">ตัวชี้วัดความสำเร็จ:</div>
                                <div class="indicator-text">__INDICATOR__</div>
                                <input type="hidden" name="indicators[]" value="__INDICATOR__">
                            </div>
                            <div class="col-md-5">
                                <div class="fw-bold mb-1">ค่าเป้าหมาย:</div>
                                <div class="target-value">__TARGET__</div>
                                <input type="hidden" name="targets[]" value="__TARGET__">
                                <input type="hidden" name="target_types[]" value="__TARGET_TYPE__">
                            </div>
                        </div>
                    </div>
                </template>

                <!-- เอกสารเพิ่มเติม -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>20. เอกสารเพิ่มเติม</h4>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" id="myFile" name="filename">
                        <small class="form-text text-muted">อัพโหลดไฟล์เอกสารที่เกี่ยวข้องกับโครงการ</small>
                    </div>
                </div>

                <!-- ปุ่มบันทึก -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class='bx bx-save'></i> บันทึกข้อมูล
                    </button>
                </div>
        </form>
    </div>
</div>

<script src="<?php echo e(asset('js/createFirstFormBugget.js')); ?>"></script>

<script>
// Add this to your editBigFormProject.js file or within a script tag
document.addEventListener('DOMContentLoaded', function() {
    // Initialize location container with existing locations if any
    initializeLocations();

    // Add event listener to the add location button
    document.getElementById('addLocationBtn').addEventListener('click', addNewLocation);

    // Add event listeners to any existing remove buttons
    document.querySelectorAll('.remove-location').forEach(button => {
        if (document.querySelectorAll('.location-item').length > 1) {
            button.style.display = 'block';
        }
        button.addEventListener('click', removeLocation);
    });
});

// Initialize locations from database if they exist
function initializeLocations() {
    const projectId = document.querySelector('form').getAttribute('action').split('/').slice(-2)[0];

    // Fetch existing locations from server
    fetch(`/projects/${projectId}/locations`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.locations.length > 0) {
                // Clear the default empty input
                document.getElementById('locationContainer').innerHTML = '';

                // Add each location from the database
                data.locations.forEach((location, index) => {
                    addLocationFromData(location, index + 1);
                });

                // Show remove buttons if multiple locations exist
                if (data.locations.length > 1) {
                    document.querySelectorAll('.remove-location').forEach(button => {
                        button.style.display = 'block';
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error fetching locations:', error);
        });
}

// Add a new location input field
function addNewLocation() {
    const container = document.getElementById('locationContainer');
    const items = container.querySelectorAll('.location-item');
    const index = items.length + 1;

    const locationDiv = document.createElement('div');
    locationDiv.className = 'form-group location-item';
    locationDiv.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="input-group">
                <span class="input-group-text location-number">11.${index}</span>
                <input type="text" class="form-control location-input" name="location[]"
                    placeholder="กรอกสถานที่" style="min-width: 800px;" data-location-id="">
                <button type="button" class="btn btn-danger btn-sm remove-location">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
        </div>
    `;

    container.appendChild(locationDiv);

    // Add event listener to the new input
    const newInput = locationDiv.querySelector('.location-input');
    setupLocationInput(newInput);

    // Add event listener to the new remove button
    const removeButton = locationDiv.querySelector('.remove-location');
    removeButton.addEventListener('click', removeLocation);

    // Show all remove buttons if there's more than one location
    if (items.length > 0) {
        document.querySelectorAll('.remove-location').forEach(button => {
            button.style.display = 'block';
        });
    }

    // Focus on the new input
    newInput.focus();
}

// Add a location from database data
function addLocationFromData(locationData, index) {
    const container = document.getElementById('locationContainer');

    const locationDiv = document.createElement('div');
    locationDiv.className = 'form-group location-item';
    locationDiv.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="input-group">
                <span class="input-group-text location-number">11.${index}</span>
                <input type="text" class="form-control location-input" name="location[]"
                    placeholder="กรอกสถานที่" style="min-width: 800px;" value="${locationData.location_name}" 
                    data-location-id="${locationData.id}">
                <button type="button" class="btn btn-danger btn-sm remove-location" style="display: none;">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
        </div>
    `;

    container.appendChild(locationDiv);

    // Add event listener to the input
    const newInput = locationDiv.querySelector('.location-input');
    setupLocationInput(newInput);

    // Add event listener to the remove button
    const removeButton = locationDiv.querySelector('.remove-location');
    removeButton.addEventListener('click', removeLocation);
}

// Setup event listeners for a location input
function setupLocationInput(input) {
    // Handle Enter key press
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            saveLocation(this);
        }
    });

    // Handle blur event (when input loses focus)
    input.addEventListener('blur', function() {
        saveLocation(this);
    });

    // Add visual indicator for editable field
    input.addEventListener('focus', function() {
        this.classList.add('editing');
    });
}

// Save location data to the server
function saveLocation(inputElement) {
    const locationValue = inputElement.value.trim();
    if (!locationValue) return; // Don't save empty values

    const projectId = document.querySelector('form').getAttribute('action').split('/').slice(-2)[0];
    const locationId = inputElement.getAttribute('data-location-id') || '';

    // Add saving indicator
    inputElement.classList.add('saving');
    inputElement.disabled = true;

    fetch(`/projects/${projectId}/save-location`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                location_id: locationId,
                location_name: locationValue
            })
        })
        .then(response => response.json())
        .then(data => {
            inputElement.classList.remove('saving', 'editing');
            inputElement.disabled = false;

            if (data.success) {
                if (data.location_id) {
                    inputElement.setAttribute('data-location-id', data.location_id);
                }

                inputElement.classList.add('save-success');
                setTimeout(() => {
                    inputElement.classList.remove('save-success');
                }, 2000);

                showToast('บันทึกสถานที่เรียบร้อยแล้ว', 'success');
            } else {
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        })
        .catch(error => {
            inputElement.classList.remove('saving', 'editing');
            inputElement.disabled = false;
            inputElement.classList.add('save-error');
            setTimeout(() => {
                inputElement.classList.remove('save-error');
            }, 2000);

            console.error('Error saving location:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// Remove a location
function removeLocation() {
    const locationItem = this.closest('.location-item');
    const locationInput = locationItem.querySelector('.location-input');
    const locationId = locationInput.getAttribute('data-location-id');
    const projectId = document.querySelector('form').getAttribute('action').split('/').slice(-2)[0];

    if (locationId) {
        if (!confirm('คุณต้องการลบสถานที่นี้ใช่หรือไม่?')) {
            return;
        }

        fetch(`/projects/${projectId}/delete-location/${locationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    removeLocationFromDOM(locationItem);
                    showToast('ลบสถานที่เรียบร้อยแล้ว', 'warning');
                } else {
                    showToast(data.message || 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting location:', error);
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    } else {
        // If it doesn't have an ID, it's a new item that hasn't been saved, so just remove it from DOM
        removeLocationFromDOM(locationItem);
    }
}

// Remove location item from DOM and renumber remaining items
function removeLocationFromDOM(locationItem) {
    const container = document.getElementById('locationContainer');
    locationItem.remove();

    // Renumber the remaining items
    const items = container.querySelectorAll('.location-item');
    items.forEach((item, index) => {
        item.querySelector('.location-number').textContent = `11.${index + 1}`;
    });

    // Hide remove buttons if only one location remains
    if (items.length === 1) {
        items[0].querySelector('.remove-location').style.display = 'none';
    }
}

// Show toast notification function
function showToast(message, type = 'success') {
    // Create toast container if it doesn't exist
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-notification';

    // Set background color and icon based on type
    if (type === 'success') {
        toast.style.backgroundColor = '#28a745';
        toast.innerHTML = `<i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'warning') {
        toast.style.backgroundColor = '#ffc107';
        toast.style.color = '#212529';
        toast.innerHTML = `<i class='bx bx-info-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'error') {
        toast.style.backgroundColor = '#dc3545';
        toast.innerHTML = `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'info') {
        toast.style.backgroundColor = '#17a2b8';
        toast.innerHTML =
            `<i class='bx bx-loader-alt bx-spin' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    }

    // Add to container and animate
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>


<script>
function saveData(element, projectId, fieldName) {
    const newValue = element.innerText;

    // สร้าง toast notification container ถ้ายังไม่มี
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // แสดงสถานะกำลังโหลด
    element.classList.add('saving');

    // ส่งข้อมูลไปยัง server ด้วย AJAX - ระบุ projectId ใน URL
    fetch(`/projects/${projectId}/update-field`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                field: fieldName,
                value: newValue
            })
        })
        .then(response => response.json())
        .then(data => {
            // ลบคลาส saving
            element.classList.remove('saving');

            if (data.success) {
                // สร้าง toast notification
                const toast = document.createElement('div');
                toast.className = 'toast-notification show';
                toast.style.backgroundColor = '#28a745';
                toast.innerHTML =
                    `<i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> บันทึกข้อมูลเรียบร้อยแล้ว`;

                document.getElementById('toast-container').appendChild(toast);

                // ซ่อนตัวเองหลังจาก 3 วินาที
                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);

                element.classList.remove('editing');
                console.log('Data saved successfully');
            } else {
                // กรณีเกิดข้อผิดพลาด
                const toast = document.createElement('div');
                toast.className = 'toast-notification show error';
                toast.style.backgroundColor = '#dc3545';
                toast.innerHTML =
                    `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> ${data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'}`;

                document.getElementById('toast-container').appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);

                console.error('Error saving data:', data.message);
            }
        })
        .catch(error => {
            element.classList.remove('saving');

            // แสดงข้อความแจ้งเตือนข้อผิดพลาด
            const toast = document.createElement('div');
            toast.className = 'toast-notification show error';
            toast.style.backgroundColor = '#dc3545';
            toast.innerHTML =
                `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์`;

            document.getElementById('toast-container').appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);

            console.error('Error:', error);
        });
}

function checkEnter(event, element) {
    if (event.key === 'Enter') {
        event.preventDefault();
        element.blur();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.editable').forEach(element => {
        element.addEventListener('focus', () => {
            element.classList.add('editing');
        });
        element.addEventListener('blur', () => {
            element.classList.remove('editing');
        });
    });
});
</script>

<script>
// เพิ่มฟังก์ชันนี้ในส่วน <script> ที่มีอยู่แล้ว
function saveEmployeeData(element, projectId, fieldName) {
    const newValue = element.value;
    const selectedText = element.options[element.selectedIndex].text;

    // สร้าง toast notification container ถ้ายังไม่มี
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // แสดงสถานะกำลังโหลด
    const container = element.closest('.editable-container');
    container.classList.add('saving');

    // ส่งข้อมูลไปยัง server ด้วย AJAX
    fetch(`/projects/${projectId}/update-field`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                field: fieldName,
                value: newValue
            })
        })
        .then(response => response.json())
        .then(data => {
            // ลบคลาส saving
            container.classList.remove('saving');

            if (data.success) {
                // สร้าง toast notification
                const toast = document.createElement('div');
                toast.className = 'toast-notification show';
                toast.style.backgroundColor = '#28a745';
                toast.innerHTML =
                    `<i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> เปลี่ยนผู้รับผิดชอบเป็น ${selectedText} เรียบร้อยแล้ว`;

                document.getElementById('toast-container').appendChild(toast);

                // ซ่อนตัวเองหลังจาก 3 วินาที
                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            } else {
                // กรณีเกิดข้อผิดพลาด
                const toast = document.createElement('div');
                toast.className = 'toast-notification show error';
                toast.style.backgroundColor = '#dc3545';
                toast.innerHTML =
                    `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> ${data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'}`;

                document.getElementById('toast-container').appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);

                // หากมีข้อผิดพลาดให้เลือกค่าเดิม
                if (data.original_value) {
                    element.value = data.original_value;
                }
            }
        })
        .catch(error => {
            container.classList.remove('saving');

            // แสดงข้อความแจ้งเตือนข้อผิดพลาด
            const toast = document.createElement('div');
            toast.className = 'toast-notification show error';
            toast.style.backgroundColor = '#dc3545';
            toast.innerHTML =
                `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์`;

            document.getElementById('toast-container').appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);

            console.error('Error:', error);
        });
}

// ฟังก์ชันสำหรับบันทึกข้อมูล SDGs
function saveSdgData(checkbox, projectId, sdgId) {
    // แสดงสถานะกำลังบันทึก
    const statusElement = document.getElementById('sdgsStatus');
    statusElement.style.display = 'block';

    const isChecked = checkbox.checked;

    // สร้าง toast notification container ถ้ายังไม่มี
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // ส่งข้อมูลไปยัง server
    fetch(`/projects/${projectId}/update-sdgs`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                sdg_id: sdgId,
                selected: isChecked
            })
        })
        .then(response => response.json())
        .then(data => {
            // ซ่อนสถานะการบันทึก
            statusElement.style.display = 'none';

            if (data.success) {
                // สร้าง toast notification
                const toast = document.createElement('div');
                toast.className = 'toast-notification show';
                toast.style.backgroundColor = '#28a745';

                // ข้อความแสดงการเปลี่ยนแปลง
                const sdgLabel = document.querySelector(`label[for="sdg_${sdgId}"]`).textContent.trim();
                const actionText = isChecked ? 'เพิ่ม' : 'ลบ';

                toast.innerHTML = `
                <i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> 
                ${actionText} SDG: ${sdgLabel} เรียบร้อยแล้ว
            `;

                document.getElementById('toast-container').appendChild(toast);

                // ซ่อนตัวเองหลังจาก 3 วินาที
                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            } else {
                // กรณีเกิดข้อผิดพลาด
                const toast = document.createElement('div');
                toast.className = 'toast-notification show error';
                toast.style.backgroundColor = '#dc3545';
                toast.innerHTML = `
                <i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> 
                ${data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'}
            `;

                document.getElementById('toast-container').appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);

                // คืนสถานะเดิมของ checkbox
                checkbox.checked = !isChecked;
            }
        })
        .catch(error => {
            // ซ่อนสถานะการบันทึก
            statusElement.style.display = 'none';

            // แสดงข้อความแจ้งเตือนข้อผิดพลาด
            const toast = document.createElement('div');
            toast.className = 'toast-notification show error';
            toast.style.backgroundColor = '#dc3545';
            toast.innerHTML = `
            <i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> 
            เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์
        `;

            document.getElementById('toast-container').appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);

            // คืนสถานะเดิมของ checkbox
            checkbox.checked = !isChecked;
            console.error('Error:', error);
        });
}
</script>

<script>
// ฟังก์ชันสำหรับบันทึกข้อมูลการบูรณาการ
function saveIntegrationData(checkbox, projectId, categoryId) {
    // แสดงสถานะกำลังบันทึก
    const statusElement = document.getElementById('integrationStatus');
    statusElement.style.display = 'block';

    const isChecked = checkbox.checked;
    const detailsInput = document.getElementById(`integration_details_${categoryId}`);

    // เปิด/ปิดการใช้งาน input
    detailsInput.disabled = !isChecked;

    // เพิ่ม event listener สำหรับการกด Enter
    if (isChecked) {
        detailsInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // ป้องกันการขึ้นบรรทัดใหม่
                this.blur(); // ทำให้ input เสียโฟกัส เพื่อให้ onblur ทำงาน
            }
        });
    } else {
        detailsInput.removeEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                this.blur();
            }
        });
    }

    // สร้าง toast notification container ถ้ายังไม่มี
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // ส่งข้อมูลไปยัง server
    fetch(`/projects/${projectId}/update-integration`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                category_id: categoryId,
                selected: isChecked,
                details: detailsInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            // ซ่อนสถานะการบันทึก
            statusElement.style.display = 'none';

            if (data.success) {
                // สร้าง toast notification
                const toast = document.createElement('div');
                toast.className = 'toast-notification show';
                toast.style.backgroundColor = '#28a745';

                // ข้อความแสดงการเปลี่ยนแปลง
                const categoryName = checkbox.parentElement.textContent.trim();
                const actionText = isChecked ? 'เพิ่ม' : 'ลบ';

                toast.innerHTML = `
                <i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> 
                ${actionText} การบูรณาการ: ${categoryName} เรียบร้อยแล้ว
            `;

                document.getElementById('toast-container').appendChild(toast);

                // ซ่อนตัวเองหลังจาก 3 วินาที
                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            } else {
                // กรณีเกิดข้อผิดพลาด
                const toast = document.createElement('div');
                toast.className = 'toast-notification show error';
                toast.style.backgroundColor = '#dc3545';
                toast.innerHTML = `
                <i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> 
                ${data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'}
            `;

                document.getElementById('toast-container').appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);

                // คืนสถานะเดิมของ checkbox
                checkbox.checked = !isChecked;
                detailsInput.disabled = !checkbox.checked;
            }
        })
        .catch(error => {
            // ซ่อนสถานะการบันทึก
            statusElement.style.display = 'none';

            // แสดงข้อความแจ้งเตือนข้อผิดพลาด
            const toast = document.createElement('div');
            toast.className = 'toast-notification show error';
            toast.style.backgroundColor = '#dc3545';
            toast.innerHTML = `
            <i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> 
            เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์
        `;

            document.getElementById('toast-container').appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);

            // คืนสถานะเดิมของ checkbox
            checkbox.checked = !isChecked;
            detailsInput.disabled = !checkbox.checked;

            console.error('Error:', error);
        });
}

// ฟังก์ชันสำหรับบันทึกรายละเอียดเพิ่มเติม
function saveIntegrationDetails(input, projectId, categoryId) {
    // แสดงสถานะการบันทึก
    const statusElement = input.nextElementSibling;
    statusElement.style.display = 'block';

    // สร้าง toast notification container ถ้ายังไม่มี
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // ส่งข้อมูลไปยัง server
    fetch(`/projects/${projectId}/update-integration-details`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                category_id: categoryId,
                details: input.value
            })
        })
        .then(response => response.json())
        .then(data => {
            // ซ่อนสถานะการบันทึก
            statusElement.style.display = 'none';

            if (data.success) {
                // สร้าง toast notification
                const toast = document.createElement('div');
                toast.className = 'toast-notification show';
                toast.style.backgroundColor = '#28a745';
                toast.innerHTML = `
                <i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> 
                บันทึกรายละเอียดเพิ่มเติมเรียบร้อยแล้ว
            `;

                document.getElementById('toast-container').appendChild(toast);

                // ซ่อนตัวเองหลังจาก 3 วินาที
                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            } else {
                // กรณีเกิดข้อผิดพลาด
                const toast = document.createElement('div');
                toast.className = 'toast-notification show error';
                toast.style.backgroundColor = '#dc3545';
                toast.innerHTML = `
                <i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> 
                ${data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'}
            `;

                document.getElementById('toast-container').appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);

                // คืนค่าเดิม
                input.value = data.original_details || '';
            }
        })
        .catch(error => {
            // ซ่อนสถานะการบันทึก
            statusElement.style.display = 'none';

            // แสดงข้อความแจ้งเตือนข้อผิดพลาด
            const toast = document.createElement('div');
            toast.className = 'toast-notification show error';
            toast.style.backgroundColor = '#dc3545';
            toast.innerHTML = `
            <i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> 
            เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์
        `;

            document.getElementById('toast-container').appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);

            console.error('Error:', error);
        });
}

// เพิ่ม Event Listener สำหรับการกด Enter บน input fields เมื่อโหลดหน้า
document.addEventListener('DOMContentLoaded', function() {
    // เพิ่ม event listener สำหรับทุก input ของรายละเอียดการบูรณาการ
    const detailsInputs = document.querySelectorAll('.additional-info');
    detailsInputs.forEach(input => {
        input.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // ป้องกันการขึ้นบรรทัดใหม่หรือการ submit form
                this.blur(); // ทำให้ input เสียโฟกัส เพื่อให้ onblur ทำงาน
            }
        });
    });
});
</script>

<script>
// ฟังก์ชันสำหรับบันทึกข้อมูลหลักการและเหตุผล
function saveRationaleData(textarea, projectId) {
    // แสดงสถานะกำลังบันทึก
    const statusElement = document.getElementById('rationaleStatus');
    statusElement.style.display = 'block';

    // ค่าที่จะบันทึก
    const rationaleText = textarea.value;

    // สร้าง toast notification container ถ้ายังไม่มี
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // ส่งข้อมูลไปยัง server
    fetch(`/projects/${projectId}/update-field`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                field: 'Principles_Reasons',
                value: rationaleText
            })
        })
        .then(response => response.json())
        .then(data => {
            // ซ่อนสถานะการบันทึก
            statusElement.style.display = 'none';

            if (data.success) {
                // สร้าง toast notification
                const toast = document.createElement('div');
                toast.className = 'toast-notification show';
                toast.style.backgroundColor = '#28a745';
                toast.innerHTML = `
                <i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> 
                บันทึกหลักการและเหตุผลเรียบร้อยแล้ว
            `;

                document.getElementById('toast-container').appendChild(toast);

                // ซ่อนตัวเองหลังจาก 3 วินาที
                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            } else {
                // กรณีเกิดข้อผิดพลาด
                const toast = document.createElement('div');
                toast.className = 'toast-notification show error';
                toast.style.backgroundColor = '#dc3545';
                toast.innerHTML = `
                <i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> 
                ${data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'}
            `;

                document.getElementById('toast-container').appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            }
        })
        .catch(error => {
            // ซ่อนสถานะการบันทึก
            statusElement.style.display = 'none';

            // แสดงข้อความแจ้งเตือนข้อผิดพลาด
            const toast = document.createElement('div');
            toast.className = 'toast-notification show error';
            toast.style.backgroundColor = '#dc3545';
            toast.innerHTML = `
            <i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> 
            เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์
        `;

            document.getElementById('toast-container').appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);

            console.error('Error:', error);
        });
}

// เพิ่มเสริม event listener สำหรับการ auto-save เมื่อมีการพิมพ์แล้วหยุดชั่วขณะ
document.addEventListener('DOMContentLoaded', function() {
    const rationaleTextarea = document.getElementById('Principles_Reasons');
    if (rationaleTextarea) {
        let typingTimer;
        const doneTypingInterval = 3000; // 3 วินาทีหลังจากหยุดพิมพ์

        rationaleTextarea.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            if (rationaleTextarea.value) {
                typingTimer = setTimeout(function() {
                    saveRationaleData(rationaleTextarea, '<?php echo e($project->Id_Project); ?>');
                }, doneTypingInterval);
            }
        });

        // ยกเลิก timer เมื่อเริ่มพิมพ์ใหม่
        rationaleTextarea.addEventListener('keydown', function() {
            clearTimeout(typingTimer);
        });
    }
});
</script>


<script>
// Function to create empty output record first, then add the field
window.createAndAddField = function(containerId, fieldName) {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // First, create an empty record in the database
    fetch(`/create-empty-output/${projectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Now add the field to the UI with the new output_id
                const container = document.getElementById(containerId);
                const fieldCount = container.children.length + 1;

                const newField = document.createElement('div');
                newField.className = 'form-group location-item mt-2';
                newField.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">${fieldCount}</span>
                        <input type="text" class="form-control output-field" name="${fieldName}" 
                               placeholder="เพิ่มรายการ" data-field-type="output"
                               data-output-id="${data.output_id}"
                               onkeydown="handleOutputKeyDown(event, this)"
                               onblur="cancelEdit(this)">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                container.appendChild(newField);

                // Focus the newly added field
                const newInput = newField.querySelector('input');
                newInput.focus();

                // Update numbering
                updateNumbering();

                showToast('เพิ่มรายการใหม่เรียบร้อยแล้ว', 'success');
            } else {
                showToast('เกิดข้อผิดพลาดในการเพิ่มรายการ: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
};

// Function to handle keydown events (specifically for Enter key)
function handleOutputKeyDown(event, inputElement) {
    // If Enter key is pressed
    if (event.key === 'Enter') {
        event.preventDefault(); // Prevent form submission
        saveOutput(inputElement);
        return false;
    }

    // If Escape key is pressed
    if (event.key === 'Escape') {
        event.preventDefault();
        cancelEdit(inputElement);
        return false;
    }
}

// Function to update numbering of fields
function updateNumbering() {
    const container = document.getElementById('outputContainer');
    const fields = container.querySelectorAll('.location-item');
    fields.forEach((field, index) => {
        field.querySelector('.location-number').textContent = index + 1;
    });

    // Show/hide remove buttons based on number of fields
    const removeButtons = container.querySelectorAll('.remove-field');
    if (fields.length > 1) {
        removeButtons.forEach(btn => btn.style.display = 'block');
    } else {
        removeButtons.forEach(btn => btn.style.display = 'none');
    }
}

// Generic function to update field numbering (for any container)
function updateFieldNumbers(containerId) {
    const container = document.getElementById(containerId);
    const items = container.querySelectorAll('.location-item');
    items.forEach((item, index) => {
        item.querySelector('.location-number').textContent = `${index + 1}`;
    });
}

// Generic function to update field buttons visibility
function updateFieldButtons(containerId) {
    const container = document.getElementById(containerId);
    const buttons = container.querySelectorAll('.remove-field');
    buttons.forEach(btn => {
        btn.style.display = buttons.length > 1 ? 'block' : 'none';
    });
}

// Update removeField function to use output_id instead of value
window.removeField = function(button) {
    const field = button.closest('.form-group');
    const input = field.querySelector('.output-field');
    const outputId = input.getAttribute('data-output-id');

    // Show deletion confirmation
    if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')) {
        // Mark as deleting
        field.classList.add('deleting');
        input.disabled = true;

        // Send delete request using the output_id
        fetch(`/delete-output-by-id/${outputId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove field on success
                    field.remove();
                    // Update numbering
                    updateNumbering();
                    // Show success toast
                    showToast('ลบรายการเรียบร้อยแล้ว', 'warning');
                } else {
                    // Restore field on error
                    field.classList.remove('deleting');
                    input.disabled = false;
                    showToast('เกิดข้อผิดพลาดในการลบรายการ', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Restore field on error
                field.classList.remove('deleting');
                input.disabled = false;
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
};

// Generic field management: Add simple field without DB integration
window.addField = function(containerId, fieldName) {
    const container = document.getElementById(containerId);
    const items = container.querySelectorAll('.location-item');
    const newIndex = items.length + 1;

    const newField = document.createElement('div');
    newField.className = 'form-group location-item mt-2';
    newField.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="input-group">
                <span class="input-group-text location-number">${newIndex}</span>
                <input type="text" class="form-control" name="${fieldName}" placeholder="เพิ่มรายการ">
                <button type="button" class="btn btn-danger btn-sm remove-field" style="display: none;">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newField);
    updateFieldButtons(containerId);
    updateFieldNumbers(containerId);
}

// Listen for clicks on remove buttons (generic handler for all fields)
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-field')) {
        const item = e.target.closest('.location-item');
        const container = item.parentElement;
        const input = item.querySelector('.output-field');

        // Check if this is an output field with an ID
        if (input && input.hasAttribute('data-output-id')) {
            const outputId = input.getAttribute('data-output-id');

            // Show deletion confirmation
            if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')) {
                // Mark as deleting
                item.classList.add('deleting');
                input.disabled = true;

                // Send delete request to the server
                fetch(`/delete-output-by-id/${outputId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove field on success
                            item.remove();
                            // Update numbering and buttons
                            updateFieldButtons(container.id);
                            updateFieldNumbers(container.id);
                            // Show success message
                            showToast('ลบรายการเรียบร้อยแล้ว', 'warning');
                        } else {
                            // Restore field on error
                            item.classList.remove('deleting');
                            input.disabled = false;
                            showToast('เกิดข้อผิดพลาดในการลบรายการ', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Restore field on error
                        item.classList.remove('deleting');
                        input.disabled = false;
                        showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
                    });
            }
        } else {
            // For non-output fields, just remove without server request
            item.remove();
            updateFieldButtons(container.id);
            updateFieldNumbers(container.id);
        }
    }
});

// ปรับปรุงฟังก์ชัน saveOutput ให้ลบข้อมูลออกจาก Database กรณีที่ลบช่องสุดท้าย
function saveOutput(inputElement) {
    const value = inputElement.value.trim();
    const outputId = inputElement.getAttribute('data-output-id');
    const container = document.getElementById('outputContainer');
    const isLastItem = container.querySelectorAll('.location-item').length === 1;
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // กรณีที่ไม่มี output_id และมีข้อมูล (การกรอกข้อมูลครั้งแรกในช่องที่ยังไม่มี ID)
    if (!outputId && value) {
        // แสดงไอคอนกำลังโหลด
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // สร้างข้อมูลใหม่พร้อมค่าที่กรอกเข้ามา (one-step create)
        fetch(`/create-output-with-value/${projectId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                // นำการแสดงสถานะการโหลดออก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // เก็บ ID และค่าต้นฉบับ
                    inputElement.setAttribute('data-output-id', data.output_id);
                    inputElement.setAttribute('data-original-value', value);

                    // แสดงผลลัพธ์สำเร็จ
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
                } else {
                    // แสดงผลลัพธ์เกิดข้อผิดพลาด
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // นำการแสดงสถานะการโหลดออก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                // แสดงผลลัพธ์เกิดข้อผิดพลาด
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });

        return;
    }

    // ถ้าค่าว่างและเป็นรายการสุดท้าย
    if (!value && isLastItem && outputId) {
        // แสดง confirmation dialog
        if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')) {
            // Mark as deleting
            inputElement.classList.add('saving');
            inputElement.disabled = true;

            // ส่ง request ไปลบรายการนี้จาก Database เลย
            fetch(`/delete-output-by-id/${outputId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // แสดง toast
                        showToast('ลบรายการเรียบร้อยแล้ว', 'warning');

                        // สร้างรายการใหม่แทน (ช่องว่าง)
                        inputElement.removeAttribute('data-output-id');
                        inputElement.removeAttribute('data-original-value');
                        inputElement.value = '';
                        inputElement.disabled = false;
                        inputElement.classList.remove('saving');

                        // สร้าง record ใหม่ใน database ถ้าต้องการ ให้มีช่องว่างเสมอ
                        fetch(`/create-empty-output/${projectId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // อัปเดต ID ใหม่
                                    inputElement.setAttribute('data-output-id', data.output_id);
                                }
                            });
                    } else {
                        // กรณีเกิดข้อผิดพลาด
                        inputElement.disabled = false;
                        inputElement.classList.remove('saving');
                        showToast('เกิดข้อผิดพลาดในการลบรายการ', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    inputElement.disabled = false;
                    inputElement.classList.remove('saving');
                    showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
                });
        } else {
            // ถ้าไม่ยืนยันการลบ ให้คืนค่าเดิม
            const originalValue = inputElement.getAttribute('data-original-value') || '';
            inputElement.value = originalValue;
        }
        return; // จบการทำงาน
    }

    // ถ้าค่าว่างแต่ไม่ใช่รายการสุดท้าย - ไม่ต้องบันทึก
    if (!value && !isLastItem) {
        return;
    }

    // ทำงานปกติกรณีมีค่าและมี output_id (โค้ดเดิม)
    if (outputId && value) {
        // Mark as saving
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // Send data to server using output_id
        fetch(`/update-output-by-id/${outputId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                // Remove saving indicator
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // Store the value as the original value
                    inputElement.setAttribute('data-original-value', value);

                    // Visual feedback for success
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
                } else {
                    // Visual feedback for error
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Remove saving indicator
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                // Visual feedback for error
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
}
// Function to cancel edit
function cancelEdit(inputElement) {
    const originalValue = inputElement.getAttribute('data-original-value');
    // If there's an original value and the current value is different, restore original
    if (originalValue !== null && originalValue !== undefined && inputElement.value !== originalValue) {
        if (inputElement.value.trim() !== '') {
            // If current value is not empty, confirm cancellation
            if (confirm('คุณต้องการยกเลิกการแก้ไขหรือไม่?')) {
                inputElement.value = originalValue;
            } else {
                // If user doesn't want to cancel, save changes
                saveOutput(inputElement);
            }
        } else {
            // If current value is empty, restore original
            inputElement.value = originalValue;
        }
    }
}

// Helper function to show toast notifications
function showToast(message, type = 'success') {
    // Create toast container if it doesn't exist
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-notification';

    // Set background color and icon based on type
    if (type === 'success') {
        toast.style.backgroundColor = '#28a745';
        toast.innerHTML = `<i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'warning') {
        toast.style.backgroundColor = '#ffc107';
        toast.style.color = '#212529';
        toast.innerHTML = `<i class='bx bx-info-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'error') {
        toast.style.backgroundColor = '#dc3545';
        toast.innerHTML = `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'info') {
        toast.style.backgroundColor = '#17a2b8';
        toast.innerHTML =
            `<i class='bx bx-loader-alt bx-spin' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    }

    // Add to container and animate
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Initialize output fields with existing data if available
document.addEventListener('DOMContentLoaded', function() {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // Fetch existing outputs from server
    fetch(`/get-outputs/${projectId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.outputs.length > 0) {
                // Clear the default empty input
                document.getElementById('outputContainer').innerHTML = '';

                // Add each output from the database
                data.outputs.forEach((output, index) => {
                    const newField = document.createElement('div');
                    newField.className = 'form-group location-item mt-2';
                    newField.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text location-number">${index + 1}</span>
                            <input type="text" class="form-control output-field" name="outputs[]" 
                                placeholder="เพิ่มรายการ" data-field-type="output"
                                value="${output.Name_Output || ''}" data-original-value="${output.Name_Output || ''}"
                                data-output-id="${output.Id_Output}"
                                onkeydown="handleOutputKeyDown(event, this)"
                                onblur="cancelEdit(this)">
                            <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeField(this)">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </div>
                `;
                    document.getElementById('outputContainer').appendChild(newField);
                });

                // Update visibility of remove buttons
                updateNumbering();
            }
        })
        .catch(error => {
            console.error('Error fetching outputs:', error);
            showToast('เกิดข้อผิดพลาดในการโหลดข้อมูล', 'error');
        });

    // Initialize any other containers with dynamic fields
    ['outcomeContainer', 'resultContainer'].forEach(containerId => {
        if (document.getElementById(containerId)) {
            updateFieldButtons(containerId);
            updateFieldNumbers(containerId);
        }
    });
});
</script>

<script>
// Code for Outcome section
window.createAndAddOutcomeField = function(containerId, fieldName) {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // Show loading toast
    showToast('กำลังเพิ่มรายการใหม่...', 'info');

    // First, create an empty record in the database
    fetch(`/create-empty-outcome/${projectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Now add the field to the UI with the new outcome_id
                const container = document.getElementById(containerId);
                const fieldCount = container.children.length + 1;

                const newField = document.createElement('div');
                newField.className = 'form-group location-item mt-2';
                newField.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">${fieldCount}</span>
                        <input type="text" class="form-control outcome-field" name="${fieldName}" 
                               placeholder="เพิ่มรายการ" data-field-type="outcome"
                               data-outcome-id="${data.outcome_id}"
                               onkeydown="handleOutcomeKeyDown(event, this)"
                               onblur="cancelOutcomeEdit(this)">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeOutcomeField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                container.appendChild(newField);

                // Focus the newly added field
                const newInput = newField.querySelector('input');
                newInput.focus();

                // Update numbering
                updateOutcomeNumbering();

                showToast('เพิ่มรายการใหม่เรียบร้อยแล้ว', 'success');
            } else {
                showToast('เกิดข้อผิดพลาดในการเพิ่มรายการ: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
};

function handleOutcomeKeyDown(event, inputElement) {
    if (event.key === 'Enter') {
        event.preventDefault();
        saveOutcome(inputElement);
        return false;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        cancelOutcomeEdit(inputElement);
        return false;
    }
}

function updateOutcomeNumbering() {
    const container = document.getElementById('outcomeContainer');
    const fields = container.querySelectorAll('.location-item');
    fields.forEach((field, index) => {
        field.querySelector('.location-number').textContent = index + 1;
    });

    const removeButtons = container.querySelectorAll('.remove-field');
    if (fields.length > 1) {
        removeButtons.forEach(btn => btn.style.display = 'block');
    } else {
        removeButtons.forEach(btn => btn.style.display = 'none');
    }
}

window.removeOutcomeField = function(button) {
    const field = button.closest('.form-group');
    const input = field.querySelector('.outcome-field');
    const outcomeId = input.getAttribute('data-outcome-id');

    if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')) {
        field.classList.add('deleting');
        input.disabled = true;

        fetch(`/delete-outcome-by-id/${outcomeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    field.remove();
                    updateOutcomeNumbering();
                    showToast('ลบรายการเรียบร้อยแล้ว', 'warning');
                } else {
                    field.classList.remove('deleting');
                    input.disabled = false;
                    showToast('เกิดข้อผิดพลาดในการลบรายการ', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                field.classList.remove('deleting');
                input.disabled = false;
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
};

// ปรับฟังก์ชัน saveOutcome ให้รองรับการลบข้อมูลเมื่อค่าว่างและเป็นรายการเดียว
function saveOutcome(inputElement) {
    const value = inputElement.value.trim();
    const outcomeId = inputElement.getAttribute('data-outcome-id');
    const container = document.getElementById('outcomeContainer');
    const isLastItem = container.querySelectorAll('.location-item').length === 1;
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // กรณีที่ไม่มี outcome_id และมีข้อมูล (การกรอกข้อมูลครั้งแรกในช่องที่ยังไม่มี ID)
    if (!outcomeId && value) {
        // แสดงไอคอนกำลังโหลด
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // สร้างข้อมูลใหม่พร้อมค่าที่กรอกเข้ามา (one-step create)
        fetch(`/create-outcome-with-value/${projectId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                // นำการแสดงสถานะการโหลดออก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // เก็บ ID และค่าต้นฉบับ
                    inputElement.setAttribute('data-outcome-id', data.outcome_id);
                    inputElement.setAttribute('data-original-value', value);

                    // แสดงผลลัพธ์สำเร็จ
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
                } else {
                    // แสดงผลลัพธ์เกิดข้อผิดพลาด
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // นำการแสดงสถานะการโหลดออก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                // แสดงผลลัพธ์เกิดข้อผิดพลาด
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });

        return;
    }

    // ถ้าค่าว่างและเป็นรายการสุดท้าย
    if (!value && isLastItem && outcomeId) {
        // แสดง confirmation dialog
        if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่? (เมื่อลบรายการสุดท้ายจะเพิ่มรายการว่างใหม่อัตโนมัติ)')) {
            // Mark as deleting
            inputElement.classList.add('saving');
            inputElement.disabled = true;

            // ส่ง request ไปลบรายการนี้
            fetch(`/delete-outcome-by-id/${outcomeId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // แสดง toast
                        showToast('ลบรายการเรียบร้อยแล้ว', 'warning');

                        // สร้างรายการใหม่แทน (ช่องว่าง)
                        inputElement.removeAttribute('data-outcome-id');
                        inputElement.removeAttribute('data-original-value');
                        inputElement.value = '';
                        inputElement.disabled = false;
                        inputElement.classList.remove('saving');

                        // สร้าง record ใหม่ใน database
                        fetch(`/create-empty-outcome/${projectId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // อัปเดต ID ใหม่
                                    inputElement.setAttribute('data-outcome-id', data.outcome_id);
                                }
                            });
                    } else {
                        // กรณีเกิดข้อผิดพลาด
                        inputElement.disabled = false;
                        inputElement.classList.remove('saving');
                        showToast('เกิดข้อผิดพลาดในการลบรายการ', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    inputElement.disabled = false;
                    inputElement.classList.remove('saving');
                    showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
                });
        } else {
            // ถ้าไม่ยืนยันการลบ ให้คืนค่าเดิม
            const originalValue = inputElement.getAttribute('data-original-value') || '';
            inputElement.value = originalValue;
        }
        return; // จบการทำงาน
    }

    // ถ้าค่าว่างแต่ไม่ใช่รายการสุดท้าย - ไม่ต้องบันทึก
    if (!value && !isLastItem) {
        return;
    }

    // โค้ดเดิม - บันทึกข้อมูล
    if (outcomeId && value) {
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        fetch(`/update-outcome-by-id/${outcomeId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    inputElement.setAttribute('data-original-value', value);

                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
                } else {
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                inputElement.classList.remove('saving');
                inputElement.disabled = false;
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
}

function cancelOutcomeEdit(inputElement) {
    const originalValue = inputElement.getAttribute('data-original-value');
    if (originalValue !== null && originalValue !== undefined && inputElement.value !== originalValue) {
        if (inputElement.value.trim() !== '') {
            if (confirm('คุณต้องการยกเลิกการแก้ไขหรือไม่?')) {
                inputElement.value = originalValue;
            } else {
                saveOutcome(inputElement);
            }
        } else {
            inputElement.value = originalValue;
        }
    }
}

// Code for Expected Results section
window.createAndAddResultField = function(containerId, fieldName) {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    showToast('กำลังเพิ่มรายการใหม่...', 'info');

    fetch(`/create-empty-expected-result/${projectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById(containerId);
                const fieldCount = container.children.length + 1;

                const newField = document.createElement('div');
                newField.className = 'form-group location-item mt-2';
                newField.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">${fieldCount}</span>
                        <input type="text" class="form-control result-field" name="${fieldName}" 
                               placeholder="เพิ่มรายการ" data-field-type="result"
                               data-result-id="${data.result_id}"
                               onkeydown="handleResultKeyDown(event, this)"
                               onblur="cancelResultEdit(this)">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeResultField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                container.appendChild(newField);

                const newInput = newField.querySelector('input');
                newInput.focus();

                updateResultNumbering();

                showToast('เพิ่มรายการใหม่เรียบร้อยแล้ว', 'success');
            } else {
                showToast('เกิดข้อผิดพลาดในการเพิ่มรายการ: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
};

function handleResultKeyDown(event, inputElement) {
    if (event.key === 'Enter') {
        event.preventDefault();
        saveResult(inputElement);
        return false;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        cancelResultEdit(inputElement);
        return false;
    }
}

function updateResultNumbering() {
    const container = document.getElementById('resultContainer');
    const fields = container.querySelectorAll('.location-item');
    fields.forEach((field, index) => {
        field.querySelector('.location-number').textContent = index + 1;
    });

    const removeButtons = container.querySelectorAll('.remove-field');
    if (fields.length > 1) {
        removeButtons.forEach(btn => btn.style.display = 'block');
    } else {
        removeButtons.forEach(btn => btn.style.display = 'none');
    }
}

window.removeResultField = function(button) {
    const field = button.closest('.form-group');
    const input = field.querySelector('.result-field');
    const resultId = input.getAttribute('data-result-id');

    if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')) {
        field.classList.add('deleting');
        input.disabled = true;

        fetch(`/delete-expected-result-by-id/${resultId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    field.remove();
                    updateResultNumbering();
                    showToast('ลบรายการเรียบร้อยแล้ว', 'warning');
                } else {
                    field.classList.remove('deleting');
                    input.disabled = false;
                    showToast('เกิดข้อผิดพลาดในการลบรายการ', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                field.classList.remove('deleting');
                input.disabled = false;
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
};

// ปรับฟังก์ชัน saveResult ให้รองรับการลบข้อมูลเมื่อค่าว่างและเป็นรายการเดียว
function saveResult(inputElement) {
    const value = inputElement.value.trim();
    const resultId = inputElement.getAttribute('data-result-id');
    const container = document.getElementById('resultContainer');
    const isLastItem = container.querySelectorAll('.location-item').length === 1;
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // กรณีที่ไม่มี result_id และมีข้อมูล (การกรอกข้อมูลครั้งแรกในช่องที่ยังไม่มี ID)
    if (!resultId && value) {
        // แสดงไอคอนกำลังโหลด
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // สร้างข้อมูลใหม่พร้อมค่าที่กรอกเข้ามา (one-step create)
        fetch(`/create-expected-result-with-value/${projectId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                // นำการแสดงสถานะการโหลดออก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // เก็บ ID และค่าต้นฉบับ
                    inputElement.setAttribute('data-result-id', data.result_id);
                    inputElement.setAttribute('data-original-value', value);

                    // แสดงผลลัพธ์สำเร็จ
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
                } else {
                    // แสดงผลลัพธ์เกิดข้อผิดพลาด
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // นำการแสดงสถานะการโหลดออก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                // แสดงผลลัพธ์เกิดข้อผิดพลาด
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });

        return;
    }

    // ถ้าค่าว่างและเป็นรายการสุดท้าย
    if (!value && isLastItem && resultId) {
        // แสดง confirmation dialog
        if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่? (เมื่อลบรายการสุดท้ายจะเพิ่มรายการว่างใหม่อัตโนมัติ)')) {
            // Mark as deleting
            inputElement.classList.add('saving');
            inputElement.disabled = true;

            // ส่ง request ไปลบรายการนี้
            fetch(`/delete-expected-result-by-id/${resultId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // แสดง toast
                        showToast('ลบรายการเรียบร้อยแล้ว', 'warning');

                        // สร้างรายการใหม่แทน (ช่องว่าง)
                        inputElement.removeAttribute('data-result-id');
                        inputElement.removeAttribute('data-original-value');
                        inputElement.value = '';
                        inputElement.disabled = false;
                        inputElement.classList.remove('saving');

                        // สร้าง record ใหม่ใน database
                        fetch(`/create-empty-expected-result/${projectId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // อัปเดต ID ใหม่
                                    inputElement.setAttribute('data-result-id', data.result_id);
                                }
                            });
                    } else {
                        // กรณีเกิดข้อผิดพลาด
                        inputElement.disabled = false;
                        inputElement.classList.remove('saving');
                        showToast('เกิดข้อผิดพลาดในการลบรายการ', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    inputElement.disabled = false;
                    inputElement.classList.remove('saving');
                    showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
                });
        } else {
            // ถ้าไม่ยืนยันการลบ ให้คืนค่าเดิม
            const originalValue = inputElement.getAttribute('data-original-value') || '';
            inputElement.value = originalValue;
        }
        return; // จบการทำงาน
    }

    // ถ้าค่าว่างแต่ไม่ใช่รายการสุดท้าย - ไม่ต้องบันทึก
    if (!value && !isLastItem) {
        return;
    }

    // ทำงานปกติกรณีมีค่าและมี result_id
    if (resultId && value) {
        // Mark as saving
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // Send data to server using result_id
        fetch(`/update-expected-result-by-id/${resultId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                // Remove saving indicator
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // Store the value as the original value
                    inputElement.setAttribute('data-original-value', value);

                    // Visual feedback for success
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
                } else {
                    // Visual feedback for error
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Remove saving indicator
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                // Visual feedback for error
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
}

function cancelResultEdit(inputElement) {
    const originalValue = inputElement.getAttribute('data-original-value');
    if (originalValue !== null && originalValue !== undefined && inputElement.value !== originalValue) {
        if (inputElement.value.trim() !== '') {
            if (confirm('คุณต้องการยกเลิกการแก้ไขหรือไม่?')) {
                inputElement.value = originalValue;
            } else {
                saveResult(inputElement);
            }
        } else {
            inputElement.value = originalValue;
        }
    }
}

// Add initialization for outcomes and expected results to the DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // Initialize outcomes
    fetch(`/get-outcomes/${projectId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.outcomes.length > 0) {
                document.getElementById('outcomeContainer').innerHTML = '';

                data.outcomes.forEach((outcome, index) => {
                    const newField = document.createElement('div');
                    newField.className = 'form-group location-item mt-2';
                    newField.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">${index + 1}</span>
                        <input type="text" class="form-control outcome-field" name="outcomes[]" 
                            placeholder="เพิ่มรายการ" data-field-type="outcome"
                            value="${outcome.Name_Outcome || ''}" data-original-value="${outcome.Name_Outcome || ''}"
                            data-outcome-id="${outcome.Id_Outcome}"
                            onkeydown="handleOutcomeKeyDown(event, this)"
                            onblur="cancelOutcomeEdit(this)">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeOutcomeField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                    document.getElementById('outcomeContainer').appendChild(newField);
                });

                updateOutcomeNumbering();
            }
        })
        .catch(error => {
            console.error('Error fetching outcomes:', error);
            showToast('เกิดข้อผิดพลาดในการโหลดข้อมูล', 'error');
        });

    // Initialize expected results
    fetch(`/get-expected-results/${projectId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.results.length > 0) {
                document.getElementById('resultContainer').innerHTML = '';

                data.results.forEach((result, index) => {
                    const newField = document.createElement('div');
                    newField.className = 'form-group location-item mt-2';
                    newField.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">${index + 1}</span>
                        <input type="text" class="form-control result-field" name="expected_results[]" 
                            placeholder="เพิ่มรายการ" data-field-type="result"
                            value="${result.Name_Expected_Results || ''}" data-original-value="${result.Name_Expected_Results || ''}"
                            data-result-id="${result.Id_Expected_Results}"
                            onkeydown="handleResultKeyDown(event, this)"
                            onblur="cancelResultEdit(this)">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeResultField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                    document.getElementById('resultContainer').appendChild(newField);
                });

                updateResultNumbering();
            }
        })
        .catch(error => {
            console.error('Error fetching expected results:', error);
            showToast('เกิดข้อผิดพลาดในการโหลดข้อมูล', 'error');
        });

    // The rest of your existing DOMContentLoaded code...
});
</script>

<script>
// Code for Location section
window.createAndAddLocationField = function(containerId, fieldName) {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // Show loading toast
    showToast('กำลังเพิ่มสถานที่ใหม่...', 'info');

    // First, create an empty record in the database with 'Null' text value
    fetch(`/create-empty-location/${projectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: ''
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Now add the field to the UI with the new location_id
                const container = document.getElementById(containerId);
                const fieldCount = container.children.length + 1;

                const newField = document.createElement('div');
                newField.className = 'form-group location-item mt-2';
                newField.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">${fieldCount}</span>
                        <input type="text" class="form-control location-field" name="${fieldName}" 
                               placeholder="กรอกสถานที่" data-field-type="location"
                               data-location-id="${data.location_id}"
                               data-original-value="Null"
                               onkeydown="handleLocationKeyDown(event, this)"
                               onblur="cancelLocationEdit(this)"
                               style="min-width: 800px;">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeLocationField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
                `;
                container.appendChild(newField);

                // Focus the newly added field
                const newInput = newField.querySelector('input');
                newInput.focus();

                // Update numbering
                updateLocationNumbering();

                showToast('เพิ่มสถานที่ใหม่เรียบร้อยแล้ว', 'success');
            } else {
                showToast('เกิดข้อผิดพลาดในการเพิ่มสถานที่: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
};

function handleLocationKeyDown(event, inputElement) {
    if (event.key === 'Enter') {
        event.preventDefault();
        saveLocation(inputElement);
        return false;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        cancelLocationEdit(inputElement);
        return false;
    }
}

function updateLocationNumbering() {
    const container = document.getElementById('locationContainer');
    const fields = container.querySelectorAll('.location-item');
    fields.forEach((field, index) => {
        field.querySelector('.location-number').textContent = index + 1;
    });

    const removeButtons = container.querySelectorAll('.remove-field');
    if (fields.length > 1) {
        removeButtons.forEach(btn => btn.style.display = 'block');
    } else {
        removeButtons.forEach(btn => btn.style.display = 'none');
    }
}

window.removeLocationField = function(button) {
    const field = button.closest('.form-group');
    const input = field.querySelector('.location-field');
    const locationId = input.getAttribute('data-location-id');

    if (confirm('คุณต้องการลบสถานที่นี้ใช่หรือไม่?')) {
        field.classList.add('deleting');
        input.disabled = true;

        fetch(`/delete-location-by-id/${locationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    field.remove();
                    updateLocationNumbering();
                    showToast('ลบสถานที่เรียบร้อยแล้ว', 'warning');
                } else {
                    field.classList.remove('deleting');
                    input.disabled = false;
                    showToast('เกิดข้อผิดพลาดในการลบสถานที่', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                field.classList.remove('deleting');
                input.disabled = false;
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
};

// ฟังก์ชันสำหรับบันทึกข้อมูลสถานที่
function saveLocation(inputElement) {
    const value = inputElement.value.trim();
    const locationId = inputElement.getAttribute('data-location-id');
    const container = document.getElementById('locationContainer');
    const isLastItem = container.querySelectorAll('.location-item').length === 1;
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // กรณีที่ไม่มี location_id และมีข้อมูล (การกรอกข้อมูลครั้งแรกในช่องที่ยังไม่มี ID)
    if (!locationId && value) {
        // แสดงไอคอนกำลังโหลด
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // สร้างข้อมูลใหม่พร้อมค่าที่กรอกเข้ามา (one-step create)
        fetch(`/create-location-with-value/${projectId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                // นำการแสดงสถานะการโหลดออก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // เก็บ ID และค่าต้นฉบับ
                    inputElement.setAttribute('data-location-id', data.location_id);
                    inputElement.setAttribute('data-original-value', value);

                    // แสดงผลลัพธ์สำเร็จ
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกสถานที่เรียบร้อยแล้ว', 'success');
                } else {
                    // แสดงผลลัพธ์เกิดข้อผิดพลาด
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // นำการแสดงสถานะการโหลดออก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                // แสดงผลลัพธ์เกิดข้อผิดพลาด
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });

        return;
    }

    // ถ้าค่าว่างและเป็นรายการสุดท้าย
    if (!value && isLastItem && locationId) {
        // แสดง confirmation dialog
        if (confirm('คุณต้องการลบสถานที่นี้ใช่หรือไม่? (เมื่อลบสถานที่สุดท้ายจะเพิ่มรายการว่างใหม่อัตโนมัติ)')) {
            // Mark as deleting
            inputElement.classList.add('saving');
            inputElement.disabled = true;

            // ส่ง request ไปลบรายการนี้
            fetch(`/delete-location-by-id/${locationId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // แสดง toast
                        showToast('ลบสถานที่เรียบร้อยแล้ว', 'warning');

                        // สร้างรายการใหม่แทน (ช่องว่าง)
                        inputElement.removeAttribute('data-location-id');
                        inputElement.removeAttribute('data-original-value');
                        inputElement.value = '';
                        inputElement.disabled = false;
                        inputElement.classList.remove('saving');

                        // สร้าง record ใหม่ใน database
                        fetch(`/create-empty-location/${projectId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // อัปเดต ID ใหม่
                                    inputElement.setAttribute('data-location-id', data.location_id);
                                }
                            });
                    } else {
                        // กรณีเกิดข้อผิดพลาด
                        inputElement.disabled = false;
                        inputElement.classList.remove('saving');
                        showToast('เกิดข้อผิดพลาดในการลบสถานที่', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    inputElement.disabled = false;
                    inputElement.classList.remove('saving');
                    showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
                });
        } else {
            // ถ้าไม่ยืนยันการลบ ให้คืนค่าเดิม
            const originalValue = inputElement.getAttribute('data-original-value') || '';
            inputElement.value = originalValue;
        }
        return; // จบการทำงาน
    }

    // ถ้าค่าว่างแต่ไม่ใช่รายการสุดท้าย - ไม่ต้องบันทึก
    if (!value && !isLastItem) {
        return;
    }

    // ทำงานปกติกรณีมีค่า
    if (locationId && value) {
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        fetch(`/update-location-by-id/${locationId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    inputElement.setAttribute('data-original-value', value);

                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกสถานที่เรียบร้อยแล้ว', 'success');
                } else {
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                inputElement.classList.remove('saving');
                inputElement.disabled = false;
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
}

function cancelLocationEdit(inputElement) {
    const originalValue = inputElement.getAttribute('data-original-value');
    if (originalValue !== null && originalValue !== undefined && inputElement.value !== originalValue) {
        if (inputElement.value.trim() !== '') {
            if (confirm('คุณต้องการยกเลิกการแก้ไขหรือไม่?')) {
                inputElement.value = originalValue;
            } else {
                saveLocation(inputElement);
            }
        } else {
            inputElement.value = originalValue;
        }
    }
}

// เพิ่มการโหลดข้อมูลสถานที่เมื่อเปิดหน้า
document.addEventListener('DOMContentLoaded', function() {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // Fetch existing locations from server
    fetch(`/get-locations/${projectId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.locations.length > 0) {
                // Clear the default empty input
                document.getElementById('locationContainer').innerHTML = '';

                // Add each location from the database
                data.locations.forEach((location, index) => {
                    const newField = document.createElement('div');
                    newField.className = 'form-group location-item mt-2';
                    newField.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">${index + 1}</span>
                        <input type="text" class="form-control location-field" name="location[]" 
                            placeholder="กรอกสถานที่" data-field-type="location"
                            value="${location.Name_Location || ''}" data-original-value="${location.Name_Location || ''}"
                            data-location-id="${location.Id_Location}"
                            onkeydown="handleLocationKeyDown(event, this)"
                            onblur="cancelLocationEdit(this)"
                            style="min-width: 800px;">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeLocationField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                    document.getElementById('locationContainer').appendChild(newField);
                });

                // Update visibility of remove buttons
                updateLocationNumbering();
            }
        })
        .catch(error => {
            console.error('Error fetching locations:', error);
            showToast('เกิดข้อผิดพลาดในการโหลดข้อมูลสถานที่', 'error');
        });
});
</script>

<script>
// ฟังก์ชันสำหรับสร้างและเพิ่มกลุ่มเป้าหมายใหม่
window.createAndAddTargetGroupField = function(containerId, groupFieldName, countFieldName, unitFieldName) {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // แสดงสถานะการโหลด
    showToast('กำลังเพิ่มกลุ่มเป้าหมายใหม่...', 'info');

    // ส่งคำขอเพื่อสร้างรายการในฐานข้อมูล
    fetch(`/create-empty-target/${projectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // สร้าง element ใหม่
                const container = document.getElementById(containerId);
                const fieldCount = container.children.length + 1;

                const newField = document.createElement('div');
                newField.className = 'form-group target-group-item mt-2';
                newField.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text target-group-number">${fieldCount}</span>
                        <input type="text" class="form-control target-group-field" name="${groupFieldName}" 
                               placeholder="กรอกกลุ่มเป้าหมาย" data-field-type="target-group"
                               data-target-id="${data.target_id}"
                               onkeydown="handleTargetGroupKeyDown(event, this)" 
                               onblur="cancelTargetGroupEdit(this)">
                        <input type="number" class="form-control target-count-field" name="${countFieldName}" 
                               placeholder="จำนวน" data-field-type="target-count"
                               data-target-id="${data.target_id}"
                               onkeydown="handleTargetCountKeyDown(event, this)" 
                               onblur="cancelTargetCountEdit(this)">
                        <input type="text" class="form-control target-unit-field" name="${unitFieldName}" 
                               placeholder="หน่วย" data-field-type="target-unit"
                               data-target-id="${data.target_id}"
                               onkeydown="handleTargetUnitKeyDown(event, this)" 
                               onblur="cancelTargetUnitEdit(this)">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeTargetGroupField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                container.appendChild(newField);

                // Focus ที่ช่องกลุ่มเป้าหมาย
                const newInput = newField.querySelector('.target-group-field');
                newInput.focus();

                // อัปเดตการแสดงผลหมายเลข
                updateTargetGroupNumbering();

                showToast('เพิ่มกลุ่มเป้าหมายเรียบร้อยแล้ว', 'success');
            } else {
                showToast('เกิดข้อผิดพลาดในการเพิ่มกลุ่มเป้าหมาย: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
};

// ฟังก์ชันจัดการการกดคีย์สำหรับกลุ่มเป้าหมาย
function handleTargetGroupKeyDown(event, inputElement) {
    if (event.key === 'Enter') {
        event.preventDefault();
        saveTargetGroup(inputElement);
        // โฟกัสไปที่ช่องถัดไปคือจำนวน
        inputElement.nextElementSibling.focus();
        return false;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        cancelTargetGroupEdit(inputElement);
        return false;
    }
}

// ฟังก์ชันจัดการการกดคีย์สำหรับจำนวน
function handleTargetCountKeyDown(event, inputElement) {
    if (event.key === 'Enter') {
        event.preventDefault();
        saveTargetCount(inputElement);
        // โฟกัสไปที่ช่องถัดไปคือหน่วย
        inputElement.nextElementSibling.focus();
        return false;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        cancelTargetCountEdit(inputElement);
        return false;
    }
}

// ฟังก์ชันจัดการการกดคีย์สำหรับหน่วย
function handleTargetUnitKeyDown(event, inputElement) {
    if (event.key === 'Enter') {
        event.preventDefault();
        saveTargetUnit(inputElement);
        return false;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        cancelTargetUnitEdit(inputElement);
        return false;
    }
}

// ฟังก์ชันอัปเดตหมายเลขลำดับ
function updateTargetGroupNumbering() {
    const container = document.getElementById('targetGroupContainer');
    const fields = container.querySelectorAll('.target-group-item');
    fields.forEach((field, index) => {
        field.querySelector('.target-group-number').textContent = index + 1;
    });

    // จัดการการแสดงปุ่มลบตามจำนวนรายการ
    const removeButtons = container.querySelectorAll('.remove-field');
    if (fields.length > 1) {
        removeButtons.forEach(btn => btn.style.display = 'block');
    } else {
        removeButtons.forEach(btn => btn.style.display = 'none');
    }
}

// ฟังก์ชันลบรายการกลุ่มเป้าหมาย
window.removeTargetGroupField = function(button) {
    const field = button.closest('.target-group-item');
    const input = field.querySelector('.target-group-field');
    const targetId = input.getAttribute('data-target-id');

    // แสดง dialog ยืนยันการลบ
    if (confirm('คุณต้องการลบกลุ่มเป้าหมายนี้ใช่หรือไม่?')) {
        // แสดงสถานะการลบ
        field.classList.add('deleting');
        input.disabled = true;

        // ส่งคำขอลบไปยังเซิร์ฟเวอร์
        fetch(`/delete-target-by-id/${targetId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // ลบจาก DOM
                    field.remove();
                    updateTargetGroupNumbering();
                    showToast('ลบกลุ่มเป้าหมายเรียบร้อยแล้ว', 'warning');
                } else {
                    // กรณีเกิดข้อผิดพลาด
                    field.classList.remove('deleting');
                    input.disabled = false;
                    showToast('เกิดข้อผิดพลาดในการลบกลุ่มเป้าหมาย', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                field.classList.remove('deleting');
                input.disabled = false;
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
};

// ฟังก์ชันบันทึกกลุ่มเป้าหมาย
function saveTargetGroup(inputElement) {
    const value = inputElement.value.trim();
    const targetId = inputElement.getAttribute('data-target-id');
    const projectId = '<?php echo e($project->Id_Project); ?>';
    const container = document.getElementById('targetGroupContainer');
    const isLastItem = container.querySelectorAll('.target-group-item').length === 1;

    // ถ้าไม่มี ID แต่มีค่า (กรณีกรอกข้อมูลครั้งแรก)
    if (!targetId && value) {
        // แสดงสถานะการบันทึก
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // สร้างข้อมูลใหม่พร้อมค่า
        fetch(`/create-target-with-value/${projectId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: value,
                    count: inputElement.nextElementSibling.value || 0,
                    unit: inputElement.nextElementSibling.nextElementSibling.value || ''
                })
            })
            .then(response => response.json())
            .then(data => {
                // ลบสถานะการบันทึก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // เก็บ ID และค่าต้นฉบับ
                    inputElement.setAttribute('data-target-id', data.target_id);
                    inputElement.setAttribute('data-original-value', value);

                    // อัพเดต data-target-id ให้กับ input จำนวนและหน่วย
                    const countInput = inputElement.nextElementSibling;
                    const unitInput = countInput.nextElementSibling;
                    countInput.setAttribute('data-target-id', data.target_id);
                    unitInput.setAttribute('data-target-id', data.target_id);

                    // แสดงผลลัพธ์สำเร็จ
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกกลุ่มเป้าหมายเรียบร้อยแล้ว', 'success');
                } else {
                    // แสดงผลลัพธ์เกิดข้อผิดพลาด
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                inputElement.classList.remove('saving');
                inputElement.disabled = false;
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });

        return;
    }

    // เพิ่มกรณีเมื่อผู้ใช้ลบข้อความทั้งหมดในกลุ่มเป้าหมาย (value เป็นค่าว่าง)
    if (targetId && !value) {
        // ถ้าเป็นรายการสุดท้าย ให้เคลียร์ค่าแต่ไม่ลบจากฐานข้อมูล
        if (isLastItem) {
            // แสดงสถานะการบันทึก
            inputElement.classList.add('saving');
            inputElement.disabled = true;

            // อัปเดตข้อมูลให้เป็นค่าว่างในฐานข้อมูล
            fetch(`/update-target-by-id/${targetId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: '' // ส่งค่าว่างไป
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // ลบสถานะการบันทึก
                    inputElement.classList.remove('saving');
                    inputElement.disabled = false;

                    if (data.success) {
                        // เก็บค่าว่างเป็นค่าต้นฉบับ
                        inputElement.setAttribute('data-original-value', '');
                        inputElement.value = '';

                        showToast('ล้างข้อมูลกลุ่มเป้าหมายเรียบร้อยแล้ว', 'success');
                    } else {
                        // กรณีเกิดข้อผิดพลาด ให้คืนค่าเดิม
                        const originalValue = inputElement.getAttribute('data-original-value') || '';
                        inputElement.value = originalValue;

                        inputElement.classList.add('save-error');
                        setTimeout(() => {
                            inputElement.classList.remove('save-error');
                        }, 2000);

                        showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    inputElement.classList.remove('saving');
                    inputElement.disabled = false;
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
                });
        } else {
            // ถ้าไม่ใช่รายการสุดท้าย สามารถลบออกจาก DOM และฐานข้อมูลได้เลย
            if (confirm('คุณต้องการลบกลุ่มเป้าหมายนี้ใช่หรือไม่?')) {
                const fieldItem = inputElement.closest('.target-group-item');

                // แสดงสถานะการลบ
                fieldItem.classList.add('deleting');
                inputElement.disabled = true;

                // ส่งคำขอลบไปยังเซิร์ฟเวอร์
                fetch(`/delete-target-by-id/${targetId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // ลบจาก DOM
                            fieldItem.remove();
                            updateTargetGroupNumbering();
                            showToast('ลบกลุ่มเป้าหมายเรียบร้อยแล้ว', 'warning');
                        } else {
                            // กรณีเกิดข้อผิดพลาด
                            fieldItem.classList.remove('deleting');
                            inputElement.disabled = false;

                            // คืนค่าเดิม
                            const originalValue = inputElement.getAttribute('data-original-value') || '';
                            inputElement.value = originalValue;

                            showToast('เกิดข้อผิดพลาดในการลบกลุ่มเป้าหมาย', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        fieldItem.classList.remove('deleting');
                        inputElement.disabled = false;

                        // คืนค่าเดิม
                        const originalValue = inputElement.getAttribute('data-original-value') || '';
                        inputElement.value = originalValue;

                        showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
                    });
            } else {
                // ถ้ายกเลิกการลบ ให้คืนค่าเดิม
                const originalValue = inputElement.getAttribute('data-original-value') || '';
                inputElement.value = originalValue;
            }
        }
        return;
    }

    // โค้ดเดิมสำหรับกรณีมีค่าและมี ID (อัปเดตค่า)
    if (targetId && value) {
        // แสดงสถานะการบันทึก
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // ส่งคำขออัปเดตไปที่เซิร์ฟเวอร์
        fetch(`/update-target-by-id/${targetId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: value
                })
            })
            .then(response => response.json())
            .then(data => {
                // ลบสถานะการบันทึก
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // เก็บค่าต้นฉบับ
                    inputElement.setAttribute('data-original-value', value);

                    // แสดงผลลัพธ์สำเร็จ
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกกลุ่มเป้าหมายเรียบร้อยแล้ว', 'success');
                } else {
                    // แสดงผลลัพธ์เกิดข้อผิดพลาด
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                inputElement.classList.remove('saving');
                inputElement.disabled = false;
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
}

// ฟังก์ชันบันทึกจำนวน
function saveTargetCount(inputElement) {
    const value = inputElement.value.trim();
    const targetId = inputElement.getAttribute('data-target-id');
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // ถ้าไม่มี ID
    if (!targetId) {
        return;
    }

    // แสดงสถานะการบันทึก
    inputElement.classList.add('saving');
    inputElement.disabled = true;

    // ส่งคำขออัปเดตไปที่เซิร์ฟเวอร์
    fetch(`/update-target-by-id/${targetId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                count: value
            })
        })
        .then(response => response.json())
        .then(data => {
            // ลบสถานะการบันทึก
            inputElement.classList.remove('saving');
            inputElement.disabled = false;

            if (data.success) {
                // เก็บค่าต้นฉบับ
                inputElement.setAttribute('data-original-value', value);

                // แสดงผลลัพธ์สำเร็จ
                inputElement.classList.add('save-success');
                setTimeout(() => {
                    inputElement.classList.remove('save-success');
                }, 2000);

                showToast('บันทึกจำนวนเรียบร้อยแล้ว', 'success');
            } else {
                // แสดงผลลัพธ์เกิดข้อผิดพลาด
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            inputElement.classList.remove('saving');
            inputElement.disabled = false;
            inputElement.classList.add('save-error');
            setTimeout(() => {
                inputElement.classList.remove('save-error');
            }, 2000);

            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// ฟังก์ชันบันทึกหน่วย
function saveTargetUnit(inputElement) {
    const value = inputElement.value.trim();
    const targetId = inputElement.getAttribute('data-target-id');
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // ถ้าไม่มี ID
    if (!targetId) {
        return;
    }

    // แสดงสถานะการบันทึก
    inputElement.classList.add('saving');
    inputElement.disabled = true;

    // ส่งคำขออัปเดตไปที่เซิร์ฟเวอร์
    fetch(`/update-target-by-id/${targetId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                unit: value
            })
        })
        .then(response => response.json())
        .then(data => {
            // ลบสถานะการบันทึก
            inputElement.classList.remove('saving');
            inputElement.disabled = false;

            if (data.success) {
                // เก็บค่าต้นฉบับ
                inputElement.setAttribute('data-original-value', value);

                // แสดงผลลัพธ์สำเร็จ
                inputElement.classList.add('save-success');
                setTimeout(() => {
                    inputElement.classList.remove('save-success');
                }, 2000);

                showToast('บันทึกหน่วยเรียบร้อยแล้ว', 'success');
            } else {
                // แสดงผลลัพธ์เกิดข้อผิดพลาด
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            inputElement.classList.remove('saving');
            inputElement.disabled = false;
            inputElement.classList.add('save-error');
            setTimeout(() => {
                inputElement.classList.remove('save-error');
            }, 2000);

            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// ฟังก์ชันยกเลิกการแก้ไขกลุ่มเป้าหมาย
function cancelTargetGroupEdit(inputElement) {
    const originalValue = inputElement.getAttribute('data-original-value');
    if (originalValue !== null && originalValue !== undefined && inputElement.value !== originalValue) {
        inputElement.value = originalValue;
    }
}

// ฟังก์ชันยกเลิกการแก้ไขจำนวน
function cancelTargetCountEdit(inputElement) {
    const originalValue = inputElement.getAttribute('data-original-value');
    if (originalValue !== null && originalValue !== undefined && inputElement.value !== originalValue) {
        inputElement.value = originalValue;
    }
}

// ฟังก์ชันยกเลิกการแก้ไขหน่วย
function cancelTargetUnitEdit(inputElement) {
    const originalValue = inputElement.getAttribute('data-original-value');
    if (originalValue !== null && originalValue !== undefined && inputElement.value !== originalValue) {
        inputElement.value = originalValue;
    }
}

// ฟังก์ชันบันทึกรายละเอียดกลุ่มเป้าหมาย
function saveTargetDetails(textareaElement) {
    const value = textareaElement.value.trim();
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // แสดงสถานะการบันทึก
    textareaElement.classList.add('saving');
    textareaElement.disabled = true;

    // ส่งคำขออัปเดตไปที่เซิร์ฟเวอร์
    fetch(`/update-target-details/${projectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                details: value
            })
        })
        .then(response => response.json())
        .then(data => {
            // ลบสถานะการบันทึก
            textareaElement.classList.remove('saving');
            textareaElement.disabled = false;

            if (data.success) {
                // เก็บค่าต้นฉบับ
                textareaElement.setAttribute('data-original-value', value);

                // แสดงผลลัพธ์สำเร็จ
                textareaElement.classList.add('save-success');
                setTimeout(() => {
                    textareaElement.classList.remove('save-success');
                }, 2000);

                showToast('บันทึกรายละเอียดกลุ่มเป้าหมายเรียบร้อยแล้ว', 'success');
            } else {
                // แสดงผลลัพธ์เกิดข้อผิดพลาด
                textareaElement.classList.add('save-error');
                setTimeout(() => {
                    textareaElement.classList.remove('save-error');
                }, 2000);

                showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            textareaElement.classList.remove('saving');
            textareaElement.disabled = false;
            textareaElement.classList.add('save-error');
            setTimeout(() => {
                textareaElement.classList.remove('save-error');
            }, 2000);

            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// ฟังก์ชันสลับการแสดงผลของรายละเอียดพื้นที่เป้าหมาย
function toggleTargetAreaDetails() {
    const checkbox = document.getElementById('targetAreaCheckbox');
    const detailsContainer = document.getElementById('targetAreaDetails');

    if (checkbox.checked) {
        detailsContainer.style.display = 'block';
    } else {
        detailsContainer.style.display = 'none';
        // บันทึกการเปลี่ยนแปลงว่าไม่มีพื้นที่เป้าหมาย
        const projectId = '<?php echo e($project->Id_Project); ?>';
        fetch(`/update-target-details/${projectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                details: '' // เปลี่ยนจาก value เป็น details ให้ตรงกับพารามิเตอร์ที่ controller คาดหวัง
            })
        });
    }
}

// โหลดข้อมูลกลุ่มเป้าหมายเมื่อเปิดหน้า
document.addEventListener('DOMContentLoaded', function() {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // โหลดข้อมูลกลุ่มเป้าหมาย
    fetch(`/get-targets/${projectId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.targets.length > 0) {
                // ล้าง container
                document.getElementById('targetGroupContainer').innerHTML = '';

                // เพิ่มข้อมูลจากฐานข้อมูล
                data.targets.forEach((target, index) => {
                    const newField = document.createElement('div');
                    newField.className = 'form-group target-group-item mt-2';
                    newField.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text target-group-number">${index + 1}</span>
                        <input type="text" class="form-control target-group-field" name="target_group[]" 
                            placeholder="กรอกกลุ่มเป้าหมาย" data-field-type="target-group"
                            value="${target.Name_Target || ''}" data-original-value="${target.Name_Target || ''}"
                            data-target-id="${target.Id_Target_Project}"
                            onkeydown="handleTargetGroupKeyDown(event, this)"
                            onblur="cancelTargetGroupEdit(this)">
                        <input type="number" class="form-control target-count-field" name="target_count[]" 
                            placeholder="จำนวน" data-field-type="target-count"
                            value="${target.Quantity_Target || ''}" data-original-value="${target.Quantity_Target || ''}"
                            data-target-id="${target.Id_Target_Project}"
                            onkeydown="handleTargetCountKeyDown(event, this)"
                            onblur="cancelTargetCountEdit(this)">
                        <input type="text" class="form-control target-unit-field" name="target_unit[]" 
                            placeholder="หน่วย" data-field-type="target-unit"
                            value="${target.Unit_Target || ''}" data-original-value="${target.Unit_Target || ''}"
                            data-target-id="${target.Id_Target_Project}"
                            onkeydown="handleTargetUnitKeyDown(event, this)"
                            onblur="cancelTargetUnitEdit(this)">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeTargetGroupField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                    document.getElementById('targetGroupContainer').appendChild(newField);
                });

                // อัปเดตปุ่มลบ
                updateTargetGroupNumbering();
            }

            // โหลดข้อมูลรายละเอียดกลุ่มเป้าหมาย
            if (data.target_details && data.target_details.length > 0) {
                const checkbox = document.getElementById('targetAreaCheckbox');
                const detailsContainer = document.getElementById('targetAreaDetails');
                const textarea = document.querySelector('textarea[name="target_details"]');

                checkbox.checked = true;
                detailsContainer.style.display = 'block';

                // ใช้ข้อมูลจาก target details
                const details = data.target_details[0].Details_Target || '';
                textarea.value = details;
                textarea.setAttribute('data-original-value', details);
            }
        })
        .catch(error => {
            console.error('Error fetching target groups:', error);
            showToast('เกิดข้อผิดพลาดในการโหลดข้อมูลกลุ่มเป้าหมาย', 'error');
        });
});

// ฟังก์ชันบันทึกรายละเอียดกลุ่มเป้าหมาย
function saveTargetDetails(textareaElement) {
    const value = textareaElement.value.trim();
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // ป้องกันการบันทึกซ้ำ
    if (textareaElement.classList.contains('saving')) {
        return;
    }

    // แสดงสถานะการบันทึก
    textareaElement.classList.add('saving');
    textareaElement.disabled = true;

    // ส่งคำขออัปเดตไปที่เซิร์ฟเวอร์
    fetch(`/update-target-details/${projectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                value: value
            })
        })
        .then(response => response.json())
        .then(data => {
            // ลบสถานะการบันทึก
            textareaElement.classList.remove('saving');
            textareaElement.disabled = false;

            if (data.success) {
                // เก็บค่าต้นฉบับ
                textareaElement.setAttribute('data-original-value', value);

                // แสดงผลลัพธ์สำเร็จ
                textareaElement.classList.add('save-success');
                setTimeout(() => {
                    textareaElement.classList.remove('save-success');
                }, 2000);

                showToast('บันทึกรายละเอียดกลุ่มเป้าหมายเรียบร้อยแล้ว', 'success');
            } else {
                // แสดงผลลัพธ์เกิดข้อผิดพลาด
                textareaElement.classList.add('save-error');
                setTimeout(() => {
                    textareaElement.classList.remove('save-error');
                }, 2000);

                showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            textareaElement.classList.remove('saving');
            textareaElement.disabled = false;
            textareaElement.classList.add('save-error');
            setTimeout(() => {
                textareaElement.classList.remove('save-error');
            }, 2000);

            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// ฟังก์ชันจัดการการกดคีย์สำหรับรายละเอียดกลุ่มเป้าหมาย
function handleTargetDetailsKeyDown(event, textareaElement) {
    // ตรวจสอบว่ากด Enter หรือไม่ (ไม่ต้องกด Ctrl ร่วมด้วย)
    if (event.key === 'Enter') {
        event.preventDefault(); // ป้องกันการขึ้นบรรทัดใหม่
        saveTargetDetails(textareaElement);
        return false;
    }
}

// ฟังก์ชันสลับการแสดงผลของรายละเอียดพื้นที่เป้าหมาย
function toggleTargetAreaDetails() {
    const checkbox = document.getElementById('targetAreaCheckbox');
    const detailsContainer = document.getElementById('targetAreaDetails');

    if (checkbox.checked) {
        detailsContainer.style.display = 'block';
    } else {
        detailsContainer.style.display = 'none';
        // บันทึกการเปลี่ยนแปลงว่าไม่มีพื้นที่เป้าหมาย
        const projectId = '<?php echo e($project->Id_Project); ?>';
        fetch(`/update-target-details/${projectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                value: ''
            })
        });
    }
}

// เพิ่มการโหลดข้อมูลพื้นที่/ชุมชนเป้าหมาย
document.addEventListener('DOMContentLoaded', function() {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // โหลดรายละเอียดกลุ่มเป้าหมาย
    fetch(`/get-target-details/${projectId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.target_details) {
                // มีข้อมูลพื้นที่เป้าหมาย
                const checkbox = document.getElementById('targetAreaCheckbox');
                const detailsContainer = document.getElementById('targetAreaDetails');
                const textarea = document.querySelector('.target-details-field');

                checkbox.checked = true;
                detailsContainer.style.display = 'block';
                textarea.value = data.target_details;
                textarea.setAttribute('data-original-value', data.target_details);
            }
        })
        .catch(error => {
            console.error('Error fetching target details:', error);
        });

    // เพิ่ม event listener ให้กับ textarea
    const textarea = document.querySelector('.target-details-field');
    if (textarea) {
        // เพิ่ม event listener สำหรับการกดคีย์ (เพียงครั้งเดียว)
        textarea.addEventListener('keydown', function(event) {
            handleTargetDetailsKeyDown(event, this);
        });
    }
});
</script>

<script>
// ============ ตัวชี้วัด ============
document.addEventListener('DOMContentLoaded', function() {
    // โหลดข้อมูลตัวชี้วัดเมื่อเปิดหน้า
    const projectId = '<?php echo e($project->Id_Project); ?>';
    loadIndicators(projectId);

    // เพิ่ม event listeners ให้กับกล่องเลือกประเภทตัวชี้วัด
    document.getElementById('quantitative').addEventListener('change', function() {
        toggleIndicatorType(this, 'quantitative');
    });

    document.getElementById('qualitative').addEventListener('change', function() {
        toggleIndicatorType(this, 'qualitative');
    });
});

// โหลดข้อมูลตัวชี้วัดจากฐานข้อมูล
function loadIndicators(projectId) {
    fetch(`/get-indicators/${projectId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // แยกประเภทตัวชี้วัด
                const quantitativeData = data.indicators.filter(item => item.Indicators_Id === 1);
                const qualitativeData = data.indicators.filter(item => item.Indicators_Id === 2);

                // อัปเดตสถานะ checkboxes
                document.getElementById('quantitative').checked = quantitativeData.length > 0;
                document.getElementById('qualitative').checked = qualitativeData.length > 0;

                // แสดง/ซ่อนส่วนของตัวชี้วัดตามข้อมูลที่มี
                document.getElementById('quantitative-inputs').style.display = quantitativeData.length > 0 ?
                    'block' : 'none';
                document.getElementById('qualitative-inputs').style.display = qualitativeData.length > 0 ? 'block' :
                    'none';

                // แสดงข้อมูลในแต่ละส่วน
                if (quantitativeData.length > 0) {
                    initializeIndicatorItems('quantitative-items', quantitativeData, 'quantitative');
                }

                if (qualitativeData.length > 0) {
                    initializeIndicatorItems('qualitative-items', qualitativeData, 'qualitative');
                }
            } else {
                showToast('เกิดข้อผิดพลาดในการโหลดข้อมูลตัวชี้วัด: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// แสดงข้อมูลตัวชี้วัดในรายการ
function initializeIndicatorItems(containerId, data, type) {
    const container = document.getElementById(containerId);
    container.innerHTML = ''; // เคลียร์ข้อมูลเดิม

    data.forEach((item, index) => {
        const newItem = document.createElement('div');
        newItem.className = 'form-group location-item mt-2';
        newItem.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text location-number">${index + 1}</span>
                    <input type="text" class="form-control indicator-field" 
                           name="${type}[]" 
                           placeholder="เพิ่ม${type === 'quantitative' ? 'รายการ' : 'ข้อความ'}" 
                           value="${item.Details_Indicators || ''}" 
                           data-original-value="${item.Details_Indicators || ''}"
                           data-indicator-id="${item.Id_Project_has_Indicators}"
                           onkeydown="handleIndicatorKeyDown(event, this, '${type}')"
                           onblur="cancelIndicatorEdit(this, '${type}')">
                    <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeIndicator(this, '${type}')">
                        <i class='bx bx-trash'></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
    });

    // อัปเดตปุ่มลบ
    updateIndicatorButtons(type);
}

// ปรับปรุงฟังก์ชัน toggleIndicatorType
function toggleIndicatorType(checkbox, type) {
    const projectId = '<?php echo e($project->Id_Project); ?>';
    const container = document.getElementById(`${type}-inputs`);
    const isChecked = checkbox.checked;
    const indicatorType = type === 'quantitative' ? 1 : 2;

    // แสดง/ซ่อนส่วนของตัวชี้วัด
    container.style.display = isChecked ? 'block' : 'none';

    if (isChecked) {
        // ถ้าเปิดใช้งานและไม่มีรายการ ให้สร้างรายการเปล่า
        const itemsContainer = document.getElementById(`${type}-items`);
        if (itemsContainer.children.length === 0) {
            createEmptyIndicator(projectId, type, indicatorType);
        }
    } else {
        // ถ้าปิดใช้งาน ให้ยืนยันการลบข้อมูลทั้งหมด
        if (document.getElementById(`${type}-items`).children.length > 0) {
            if (confirm(
                    `คุณต้องการลบข้อมูลตัวชี้วัด${type === 'quantitative' ? 'เชิงปริมาณ' : 'เชิงคุณภาพ'}ทั้งหมดใช่หรือไม่?`
                )) {
                // ส่งคำขอลบไปยังเซิร์ฟเวอร์
                deleteIndicatorsByType(projectId, indicatorType, type, checkbox, container);
            } else {
                // ถ้าไม่ยืนยันการลบ ให้กลับมาเลือกช่อง
                checkbox.checked = true;
                container.style.display = 'block';
            }
        }
    }
}

// ฟังก์ชันลบตัวชี้วัดทั้งหมดตามประเภท
function deleteIndicatorsByType(projectId, indicatorType, type, checkbox, container) {
    // แสดง loading toast
    showToast('กำลังลบข้อมูล...', 'info');

    fetch(`/delete-indicators-by-type/${projectId}/${indicatorType}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // เคลียร์รายการทั้งหมดในส่วนแสดงผล
                document.getElementById(`${type}-items`).innerHTML = '';

                // ยกเลิกการเลือก checkbox
                checkbox.checked = false;

                // ซ่อนส่วนแสดงผล
                container.style.display = 'none';

                showToast(
                    `ลบข้อมูลตัวชี้วัด${type === 'quantitative' ? 'เชิงปริมาณ' : 'เชิงคุณภาพ'}ทั้งหมดเรียบร้อยแล้ว`,
                    'warning');
            } else {
                // กรณีมีข้อผิดพลาด
                checkbox.checked = true;
                container.style.display = 'block';
                showToast('เกิดข้อผิดพลาด: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            checkbox.checked = true;
            container.style.display = 'block';
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// ลบตัวชี้วัดทั้งหมดตามประเภท
function deleteAllIndicatorsOfType(projectId, indicatorType, type, checkbox, container) {
    fetch(`/delete-all-indicators/${projectId}/${indicatorType}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // เคลียร์รายการทั้งหมด
                document.getElementById(`${type}-items`).innerHTML = '';
                showToast(`ลบตัวชี้วัด${type === 'quantitative' ? 'เชิงปริมาณ' : 'เชิงคุณภาพ'}ทั้งหมดเรียบร้อยแล้ว`,
                    'warning');
            } else {
                // กรณีมีข้อผิดพลาด
                checkbox.checked = true;
                container.style.display = 'block';
                showToast('เกิดข้อผิดพลาด: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            checkbox.checked = true;
            container.style.display = 'block';
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// สร้างตัวชี้วัดเปล่า
function createEmptyIndicator(projectId, type, indicatorType) {
    showToast(`กำลังเพิ่มตัวชี้วัด${type === 'quantitative' ? 'เชิงปริมาณ' : 'เชิงคุณภาพ'}...`, 'info');

    fetch(`/create-empty-indicator/${projectId}/${indicatorType}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById(`${type}-items`);

                const newItem = document.createElement('div');
                newItem.className = 'form-group location-item mt-2';
                newItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">1</span>
                        <input type="text" class="form-control indicator-field" 
                               name="${type}[]" 
                               placeholder="เพิ่ม${type === 'quantitative' ? 'รายการ' : 'ข้อความ'}" 
                               data-indicator-id="${data.indicator_id}"
                               data-original-value=""
                               onkeydown="handleIndicatorKeyDown(event, this, '${type}')"
                               onblur="cancelIndicatorEdit(this, '${type}')">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeIndicator(this, '${type}')" style="display: none;">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                container.appendChild(newItem);

                // โฟกัสที่ช่องกรอกข้อมูลใหม่
                const input = newItem.querySelector('input');
                input.focus();

                showToast(`เพิ่มตัวชี้วัด${type === 'quantitative' ? 'เชิงปริมาณ' : 'เชิงคุณภาพ'}เรียบร้อยแล้ว`,
                    'success');
            } else {
                showToast('เกิดข้อผิดพลาด: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// เพิ่มรายการตัวชี้วัด
window.addQuantitativeItem = function() {
    addNewIndicator('quantitative', 1);
};

window.addQualitativeItem = function() {
    addNewIndicator('qualitative', 2);
};

function addNewIndicator(type, indicatorId) {
    const projectId = '<?php echo e($project->Id_Project); ?>';

    showToast(`กำลังเพิ่ม${type === 'quantitative' ? 'รายการเชิงปริมาณ' : 'รายการเชิงคุณภาพ'}...`, 'info');

    fetch(`/create-empty-indicator/${projectId}/${indicatorId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById(`${type}-items`);
                const fieldCount = container.children.length + 1;

                const newItem = document.createElement('div');
                newItem.className = 'form-group location-item mt-2';
                newItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">${fieldCount}</span>
                        <input type="text" class="form-control indicator-field" 
                               name="${type}[]" 
                               placeholder="เพิ่ม${type === 'quantitative' ? 'รายการ' : 'ข้อความ'}" 
                               data-indicator-id="${data.indicator_id}"
                               data-original-value=""
                               onkeydown="handleIndicatorKeyDown(event, this, '${type}')"
                               onblur="cancelIndicatorEdit(this, '${type}')">
                        <button type="button" class="btn btn-danger btn-sm remove-field" onclick="removeIndicator(this, '${type}')">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            `;
                container.appendChild(newItem);

                // โฟกัสที่ช่องกรอกข้อมูลใหม่
                const input = newItem.querySelector('input');
                input.focus();

                // อัปเดตปุ่มลบ
                updateIndicatorButtons(type);

                showToast(`เพิ่ม${type === 'quantitative' ? 'รายการเชิงปริมาณ' : 'รายการเชิงคุณภาพ'}เรียบร้อยแล้ว`,
                    'success');
            } else {
                showToast('เกิดข้อผิดพลาด: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// จัดการการกดปุ่มบนช่องกรอกข้อมูล
function handleIndicatorKeyDown(event, inputElement, type) {
    if (event.key === 'Enter') {
        event.preventDefault();
        saveIndicator(inputElement, type);
        return false;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        cancelIndicatorEdit(inputElement, type);
        return false;
    }
}

// บันทึกข้อมูลตัวชี้วัด
function saveIndicator(inputElement, type) {
    const value = inputElement.value.trim();
    const indicatorId = inputElement.getAttribute('data-indicator-id');
    const projectId = '<?php echo e($project->Id_Project); ?>';
    const container = document.getElementById(`${type}-items`);
    const isLastItem = container.querySelectorAll('.form-group').length === 1;

    // กรณีที่ไม่มี indicator_id และมีข้อมูล (การกรอกข้อมูลครั้งแรก)
    if (!indicatorId && value) {
        // แสดงสถานะกำลังบันทึก
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // สร้างข้อมูลใหม่พร้อมค่า
        fetch(`/create-indicator-with-value/${projectId}/${type === 'quantitative' ? 1 : 2}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    Details_Indicators: value
                })
            })
            .then(response => response.json())
            .then(data => {
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // เก็บ ID และค่าต้นฉบับ
                    inputElement.setAttribute('data-indicator-id', data.indicator_id);
                    inputElement.setAttribute('data-original-value', value);

                    // แสดงผลลัพธ์สำเร็จ
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกตัวชี้วัดเรียบร้อยแล้ว', 'success');
                } else {
                    // แสดงผลลัพธ์เกิดข้อผิดพลาด
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                inputElement.classList.remove('saving');
                inputElement.disabled = false;
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });

        return;
    }

    // กรณีที่ค่าว่างและเป็นรายการสุดท้าย (ไม่ลบรายการสุดท้าย แค่ลบข้อมูลเท่านั้น)
    if (!value && isLastItem && indicatorId) {
        // แสดงสถานะการบันทึก
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // อัปเดตค่าให้เป็นค่าว่าง
        fetch(`/update-indicator/${indicatorId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    Details_Indicators: '' // ใช้ชื่อฟิลด์ที่ถูกต้อง
                })
            })
            .then(response => response.json())
            .then(data => {
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // เก็บค่าว่างเป็นค่าต้นฉบับ
                    inputElement.setAttribute('data-original-value', '');

                    // แสดงผลลัพธ์สำเร็จ
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('ล้างข้อมูลตัวชี้วัดเรียบร้อยแล้ว', 'success');
                } else {
                    // แสดงผลลัพธ์เกิดข้อผิดพลาด
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                inputElement.classList.remove('saving');
                inputElement.disabled = false;
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });

        return;
    }

    // กรณีค่าว่างแต่ไม่ใช่รายการสุดท้าย - ยืนยันการลบ
    if (!value && !isLastItem && indicatorId) {
        if (confirm(`คุณต้องการลบตัวชี้วัด${type === 'quantitative' ? 'เชิงปริมาณ' : 'เชิงคุณภาพ'}นี้ใช่หรือไม่?`)) {
            removeIndicator(inputElement.nextElementSibling, type); // ส่งปุ่มลบไปยังฟังก์ชัน removeIndicator
        } else {
            // ถ้ายกเลิกการลบ ให้คืนค่าเดิม
            const originalValue = inputElement.getAttribute('data-original-value') || '';
            inputElement.value = originalValue;
        }
        return;
    }

    // กรณีมีค่าและมี ID (อัปเดตข้อมูล)
    if (indicatorId && value) {
        // แสดงสถานะกำลังบันทึก
        inputElement.classList.add('saving');
        inputElement.disabled = true;

        // ส่งชื่อฟิลด์ที่ถูกต้อง
        fetch(`/update-indicator/${indicatorId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    Details_Indicators: value
                })
            })
            .then(response => response.json())
            .then(data => {
                inputElement.classList.remove('saving');
                inputElement.disabled = false;

                if (data.success) {
                    // เก็บค่าต้นฉบับ
                    inputElement.setAttribute('data-original-value', value);

                    // แสดง visual feedback
                    inputElement.classList.add('save-success');
                    setTimeout(() => {
                        inputElement.classList.remove('save-success');
                    }, 2000);

                    showToast('บันทึกตัวชี้วัดเรียบร้อยแล้ว', 'success');
                } else {
                    // แสดง visual feedback สำหรับข้อผิดพลาด
                    inputElement.classList.add('save-error');
                    setTimeout(() => {
                        inputElement.classList.remove('save-error');
                    }, 2000);

                    showToast('เกิดข้อผิดพลาด: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                inputElement.classList.remove('saving');
                inputElement.disabled = false;
                inputElement.classList.add('save-error');
                setTimeout(() => {
                    inputElement.classList.remove('save-error');
                }, 2000);

                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
}

// ยกเลิกการแก้ไข
function cancelIndicatorEdit(inputElement, type) {
    const originalValue = inputElement.getAttribute('data-original-value');
    if (originalValue !== null && originalValue !== undefined && inputElement.value !== originalValue) {
        if (confirm('คุณต้องการยกเลิกการแก้ไขหรือไม่?')) {
            inputElement.value = originalValue;
        } else {
            saveIndicator(inputElement, type);
        }
    }
}

// ลบรายการตัวชี้วัด
window.removeIndicator = function(button, type) {
    const field = button.closest('.form-group');
    const input = field.querySelector('.indicator-field');
    const indicatorId = input.getAttribute('data-indicator-id');
    const container = document.getElementById(`${type}-items`);
    const isLastItem = container.querySelectorAll('.form-group').length === 1;

    // ถ้าเป็นรายการสุดท้าย ไม่ให้ลบ
    if (isLastItem) {
        showToast('ไม่สามารถลบรายการสุดท้ายได้ หากต้องการลบให้ยกเลิกการเลือกประเภทตัวชี้วัดด้านบน', 'warning');
        return;
    }

    if (confirm(`คุณต้องการลบตัวชี้วัด${type === 'quantitative' ? 'เชิงปริมาณ' : 'เชิงคุณภาพ'}นี้ใช่หรือไม่?`)) {
        // แสดงสถานะกำลังลบ
        field.classList.add('deleting');
        input.disabled = true;

        fetch(`/delete-indicator/${indicatorId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    field.remove();
                    updateIndicatorButtons(type);
                    showToast(
                        `ลบตัวชี้วัด${type === 'quantitative' ? 'เชิงปริมาณ' : 'เชิงคุณภาพ'}เรียบร้อยแล้ว`,
                        'warning');
                } else {
                    field.classList.remove('deleting');
                    input.disabled = false;
                    showToast('เกิดข้อผิดพลาด: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                field.classList.remove('deleting');
                input.disabled = false;
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
};

// อัปเดตลำดับหมายเลขและการแสดงปุ่มลบ
function updateIndicatorButtons(type) {
    const container = document.getElementById(`${type}-items`);
    const fields = container.querySelectorAll('.form-group');

    // อัปเดตลำดับหมายเลข
    fields.forEach((field, index) => {
        field.querySelector('.location-number').textContent = index + 1;
    });

    // อัปเดตการแสดงปุ่มลบ
    const removeButtons = container.querySelectorAll('.remove-field');
    if (fields.length > 1) {
        removeButtons.forEach(btn => btn.style.display = 'block');
    } else {
        removeButtons.forEach(btn => btn.style.display = 'none');
    }
}

// แสดง Toast notification
function showToast(message, type = 'success') {
    // สร้าง container ถ้ายังไม่มี
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // สร้าง toast
    const toast = document.createElement('div');
    toast.className = 'toast-notification';

    // กำหนดสีและไอคอนตามประเภท
    if (type === 'success') {
        toast.style.backgroundColor = '#28a745';
        toast.innerHTML = `<i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'warning') {
        toast.style.backgroundColor = '#ffc107';
        toast.style.color = '#212529';
        toast.innerHTML = `<i class='bx bx-info-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'error') {
        toast.style.backgroundColor = '#dc3545';
        toast.innerHTML = `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'info') {
        toast.style.backgroundColor = '#17a2b8';
        toast.innerHTML =
            `<i class='bx bx-loader-alt bx-spin' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    }

    // เพิ่มเข้าใน container
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);

    // ลบหลังจาก 3 วินาที
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<script>
// ฟังก์ชันบันทึกประเภทโครงการแบบ inline
function saveProjectType(radioElement, projectId, typeValue) {
    // แสดงสถานะกำลังบันทึก
    const savingIndicator = document.getElementById('project-type-saving-indicator');
    savingIndicator.style.display = 'inline-block';

    // ส่งข้อมูลไปยัง server ด้วย AJAX
    fetch(`/projects/${projectId}/update-field`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                field: 'Project_Type',
                value: typeValue
            })
        })
        .then(response => response.json())
        .then(data => {
            // ซ่อนสถานะการบันทึก
            savingIndicator.style.display = 'none';

            if (data.success) {
                // สลับการแสดงผลของรายละเอียดตามประเภทโครงการ
                toggleProjectTypeDetails(typeValue);

                // แสดง toast notification สำเร็จ
                showToast(`เปลี่ยนเป็น${typeValue === 'S' ? 'โครงการระยะสั้น' : 'โครงการระยะยาว'}เรียบร้อยแล้ว`,
                    'success');
            } else {
                // กรณีมีข้อผิดพลาด คืนค่าเดิม
                if (typeValue === 'S') {
                    document.getElementById('longTermProject').checked = true;
                } else {
                    document.getElementById('shortTermProject').checked = true;
                }

                showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // ซ่อนสถานะการบันทึก
            savingIndicator.style.display = 'none';

            // คืนค่าเดิมในกรณีเกิดข้อผิดพลาด
            if (typeValue === 'S') {
                document.getElementById('longTermProject').checked = true;
            } else {
                document.getElementById('shortTermProject').checked = true;
            }

            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
}

// ฟังก์ชันสลับการแสดงผลของรายละเอียดตามประเภทโครงการ
function toggleProjectTypeDetails(typeValue) {
    const shortTermBox = document.getElementById('textbox-planType-1');
    const longTermBox = document.getElementById('textbox-planType-2');

    if (typeValue === 'S') {
        shortTermBox.style.display = 'block';
        if (longTermBox) longTermBox.style.display = 'none';
    } else {
        shortTermBox.style.display = 'none';
        if (longTermBox) longTermBox.style.display = 'block';
    }
}

// เมื่อโหลดหน้าให้กำหนดการแสดงผลเริ่มต้นตามประเภทโครงการที่เลือก
document.addEventListener('DOMContentLoaded', function() {
    const projectType = document.querySelector('input[name="Project_Type"]:checked').value;
    toggleProjectTypeDetails(projectType);
});
</script>

<script>
// สำหรับการจัดการกับวัตถุประสงค์โครงการ
document.addEventListener('DOMContentLoaded', function() {
    // เตรียม CSRF token สำหรับ AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // สลับระหว่างการเลือกวัตถุประสงค์จากรายการและการกรอกเอง
    document.getElementById('toggleObjectiveInput').addEventListener('click', function() {
        const manualInput = document.getElementById('objective_manual');
        const selectInput = document.getElementById('objective_select');

        if (manualInput.style.display === 'none') {
            manualInput.style.display = 'block';
            this.innerHTML = '<i class="bx bx-list-ul"></i> เลือกจากรายการ';
            selectInput.disabled = true;
        } else {
            manualInput.style.display = 'none';
            this.innerHTML = '<i class="bx bx-edit"></i> กรอกวัตถุประสงค์ด้วยตนเอง';
            selectInput.disabled = false;
        }
    });

    // เพิ่มวัตถุประสงค์ใหม่
    document.getElementById('addObjectiveBtn').addEventListener('click', function() {
        const projectId = document.getElementById('objectivesContainer').dataset.projectId;

        // ตรวจสอบว่าผู้ใช้เลือกวิธีไหนในการเพิ่มวัตถุประสงค์
        let objectiveText = '';
        let objectiveType = '';
        let sourceId = null;

        if (document.getElementById('objective_manual').style.display === 'none') {
            // กรณีเลือกจากรายการ
            const selectElement = document.getElementById('objective_select');
            if (selectElement.selectedIndex <= 0) {
                showToast('กรุณาเลือกวัตถุประสงค์ก่อนเพิ่ม', 'warning');
                return;
            }
            objectiveText = selectElement.options[selectElement.selectedIndex].text;
            objectiveType = 'selected';
            sourceId = selectElement.value;
        } else {
            // กรณีกรอกเอง
            objectiveText = document.getElementById('objective_manual').value.trim();
            if (!objectiveText) {
                showToast('กรุณากรอกวัตถุประสงค์ก่อนเพิ่ม', 'warning');
                return;
            }
            objectiveType = 'manual';
        }

        // แสดงสถานะการโหลด
        showToast('กำลังเพิ่มวัตถุประสงค์...', 'info');

        // ส่งข้อมูลไปบันทึกที่เซิร์ฟเวอร์
        fetch('/projects/objectives/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    project_id: projectId,
                    description: objectiveText,
                    type: objectiveType,
                    source_id: sourceId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // สร้างข้อมูล HTML สำหรับวัตถุประสงค์ใหม่
                    const newItem = document.createElement('div');
                    newItem.className =
                        'objective-item mb-2 p-3 border rounded bg-light position-relative';
                    newItem.setAttribute('data-id', data.objective_id);

                    // สร้าง HTML สำหรับแสดงผลวัตถุประสงค์
                    newItem.innerHTML = `
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2 delete-objective" 
                            data-id="${data.objective_id}"></button>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="fw-bold mb-1">วัตถุประสงค์:</div>
                            <div class="objective-text editable-objective" 
                                 data-project-id="${projectId}" 
                                 data-objective-id="${data.objective_id}" 
                                 data-type="${objectiveType}"
                                 ${sourceId ? `data-source-id="${sourceId}"` : ''}
                                 onclick="makeEditable(this)">
                                ${objectiveText}
                            </div>
                            <input type="hidden" name="Objective_Project[]" value="${objectiveText}">
                        </div>
                    </div>
                `;

                    // เพิ่มข้อมูลลงในหน้าเว็บ
                    document.getElementById('objectivesContainer').appendChild(newItem);

                    // เพิ่ม event listener สำหรับปุ่มลบ
                    newItem.querySelector('.delete-objective').addEventListener('click',
                        function() {
                            deleteObjective(this.getAttribute('data-id'));
                        });

                    // รีเซ็ตฟอร์ม
                    document.getElementById('objective_select').selectedIndex = 0;
                    document.getElementById('objective_manual').value = '';

                    showToast('เพิ่มวัตถุประสงค์เรียบร้อยแล้ว', 'success');
                } else {
                    showToast('เกิดข้อผิดพลาด: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    });

    // ตั้งค่า event listeners สำหรับปุ่มลบที่มีอยู่แล้ว
    document.querySelectorAll('.delete-objective').forEach(button => {
        button.addEventListener('click', function() {
            deleteObjective(this.getAttribute('data-id'));
        });
    });
});

// ฟังก์ชันลบวัตถุประสงค์
function deleteObjective(objectiveId) {
    if (confirm('คุณต้องการลบวัตถุประสงค์นี้ใช่หรือไม่?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        showToast('กำลังลบวัตถุประสงค์...', 'info');

        fetch(`/projects/objectives/delete/${objectiveId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // ลบวัตถุประสงค์จากหน้าเว็บ
                    const objectiveItem = document.querySelector(`.objective-item[data-id="${objectiveId}"]`);
                    if (objectiveItem) {
                        objectiveItem.remove();
                    }
                    showToast('ลบวัตถุประสงค์เรียบร้อยแล้ว', 'warning');
                } else {
                    showToast('เกิดข้อผิดพลาด: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }
}

// ฟังก์ชันทำให้วัตถุประสงค์สามารถแก้ไขได้
function makeEditable(element) {
    // ตรวจสอบว่าไม่ได้อยู่ในโหมดแก้ไขอยู่แล้ว
    if (element.classList.contains('editing')) return;

    const originalText = element.textContent.trim();
    const projectId = element.getAttribute('data-project-id');
    const objectiveId = element.getAttribute('data-objective-id');
    const objectiveType = element.getAttribute('data-type');
    const sourceId = element.getAttribute('data-source-id');

    // เปลี่ยนเป็น contenteditable
    element.setAttribute('contenteditable', 'true');
    element.classList.add('editing');
    element.focus();

    // สร้าง selection range ที่จุดสิ้นสุดของข้อความ
    const range = document.createRange();
    range.selectNodeContents(element);
    range.collapse(false);
    const selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);

    // บันทึกการแก้ไข
    function saveEdit() {
        const newText = element.textContent.trim();

        // หากไม่มีการเปลี่ยนแปลง
        if (newText === originalText) {
            cancelEdit();
            return;
        }

        // ถ้าค่าว่าง ยกเลิกการแก้ไข
        if (!newText) {
            cancelEdit();
            showToast('วัตถุประสงค์ไม่สามารถเป็นค่าว่างได้', 'warning');
            return;
        }

        // แสดงสถานะกำลังบันทึก
        element.classList.add('saving');
        element.removeAttribute('contenteditable');

        // ส่งข้อมูลไปอัปเดตที่เซิร์ฟเวอร์
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/projects/objectives/update/${objectiveId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    description: newText,
                    type: 'manual', // เมื่อแก้ไขแล้วให้ถือว่าเป็นการกรอกด้วยตนเอง
                    source_id: null // ล้าง ID แหล่งที่มา เพราะไม่ได้เลือกจาก dropdown แล้ว
                })
            })
            .then(response => response.json())
            .then(data => {
                element.classList.remove('saving', 'editing');

                if (data.success) {
                    // อัปเดตค่าใน hidden input
                    const hiddenInput = element.parentNode.querySelector('input[type="hidden"]');
                    if (hiddenInput) {
                        hiddenInput.value = newText;
                    }

                    // อัปเดตรูปแบบ (เปลี่ยนเป็นแบบ manual)
                    element.setAttribute('data-type', 'manual');
                    element.removeAttribute('data-source-id');

                    showToast('อัปเดตวัตถุประสงค์เรียบร้อยแล้ว', 'success');
                } else {
                    element.textContent = originalText;
                    showToast('เกิดข้อผิดพลาด: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                element.classList.remove('saving', 'editing');
                element.textContent = originalText;
                showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            });
    }

    // ยกเลิกการแก้ไข
    function cancelEdit() {
        element.removeAttribute('contenteditable');
        element.classList.remove('editing');
        element.textContent = originalText;
    }

    // เพิ่ม Event Listeners
    element.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            saveEdit();
        } else if (e.key === 'Escape') {
            e.preventDefault();
            cancelEdit();
        }
    }, {
        once: true
    });

    element.addEventListener('blur', saveEdit, {
        once: true
    });
}

// ฟังก์ชันแสดง toast notification
function showToast(message, type = 'success') {
    // สร้าง toast container ถ้ายังไม่มี
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // สร้าง toast element
    const toast = document.createElement('div');
    toast.className = 'toast-notification';

    // กำหนด style ตาม type
    if (type === 'success') {
        toast.style.backgroundColor = '#28a745';
        toast.innerHTML = `<i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'warning') {
        toast.style.backgroundColor = '#ffc107';
        toast.style.color = '#212529';
        toast.innerHTML = `<i class='bx bx-info-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'error') {
        toast.style.backgroundColor = '#dc3545';
        toast.innerHTML = `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'info') {
        toast.style.backgroundColor = '#17a2b8';
        toast.innerHTML =
            `<i class='bx bx-loader-alt bx-spin' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    }

    // เพิ่มลงใน container และแสดง animation
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);

    // ลบหลัง 3 วินาที
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<script>
// JavaScript for managing platforms, programs, and KPIs
let platformCount = 1;

// Add a new platform
window.addPlatform = function() {
    const container = document.getElementById('platform-container');
    const platformTemplate = document.querySelector('.platform-card').cloneNode(true);

    platformTemplate.querySelector('.card-title').textContent = `แพลตฟอร์มที่ ${platformCount + 1}`;

    // Clear values in all inputs and update indices
    const inputs = platformTemplate.querySelectorAll('input');
    inputs.forEach(input => {
        const name = input.name.replace(/\[\d+\]/, `[${platformCount}]`);
        input.name = name;
        input.value = '';
    });

    // Reset KPI section - remove any extra KPI rows
    const kpiContainer = platformTemplate.querySelector('.kpi-container');
    const kpiGroup = kpiContainer.querySelector('.kpi-group');
    const kpiRows = kpiGroup.querySelectorAll('.d-flex');

    // Keep only the first KPI row and clear its value
    for (let i = 1; i < kpiRows.length; i++) {
        kpiRows[i].remove();
    }
    const firstKpiInput = kpiGroup.querySelector('input[type="text"]');
    if (firstKpiInput) firstKpiInput.value = '';

    // Show the remove button
    const removeBtn = platformTemplate.querySelector('.remove-platform-btn');
    removeBtn.style.display = 'block';

    container.appendChild(platformTemplate);
    platformCount++;
    updatePlatformNumbers();
    toggleRemovePlatformButtons();
}

// Remove a platform
window.removePlatform = function(button) {
    if (confirm('คุณต้องการลบแพลตฟอร์มนี้ใช่หรือไม่?')) {
        const platformCard = button.closest('.platform-card');
        platformCard.remove();
        updatePlatformNumbers();
        toggleRemovePlatformButtons();
    }
}

// Update platform numbering
function updatePlatformNumbers() {
    const platformContainer = document.getElementById('platform-container');
    const platformCards = platformContainer.querySelectorAll('.platform-card');
    platformCards.forEach((card, index) => {
        card.querySelector('.card-title').textContent = `แพลตฟอร์มที่ ${index + 1}`;
        const inputs = card.querySelectorAll('input');
        inputs.forEach(input => {
            const name = input.name.replace(/\[\d+\]/, `[${index}]`);
            input.name = name;
        });
    });
    platformCount = platformCards.length;
}

// Add a new KPI
window.addKpi = function(btn) {
    const kpiContainer = btn.closest('.kpi-container');
    const kpiGroup = kpiContainer.querySelector('.kpi-group');
    const kpiTemplate = kpiGroup.querySelector('.d-flex').cloneNode(true);

    // Clear value of the new KPI input
    const kpiInput = kpiTemplate.querySelector('input[type="text"]');
    kpiInput.value = '';

    // Update hidden inputs
    const hiddenInputs = kpiTemplate.querySelectorAll('input[type="hidden"]');
    hiddenInputs.forEach(input => {
        input.value = '';
    });

    // Show the remove button
    const removeBtn = kpiTemplate.querySelector('.remove-field');
    removeBtn.style.display = 'block';

    kpiGroup.appendChild(kpiTemplate);
    updateKpiNumbers(kpiContainer);
    updateRemoveButtons(kpiContainer);
}

// Remove a KPI
window.removeKpi = function(btn) {
    if (confirm('คุณต้องการลบ KPI นี้ใช่หรือไม่?')) {
        const kpiRow = btn.closest('.d-flex');
        const kpiContainer = btn.closest('.kpi-container');
        const kpiGroup = kpiContainer.querySelector('.kpi-group');

        if (kpiGroup.querySelectorAll('.d-flex').length > 1) {
            kpiRow.remove();
            updateKpiNumbers(kpiContainer);
            updateRemoveButtons(kpiContainer);
        } else {
            alert('ต้องมี KPI อย่างน้อย 1 รายการ');
        }
    }
}

// Update KPI numbering
function updateKpiNumbers(kpiContainer) {
    const kpiGroup = kpiContainer.querySelector('.kpi-group');
    const kpiRows = kpiGroup.querySelectorAll('.d-flex');

    kpiRows.forEach((row, index) => {
        // Update number label
        row.querySelector('.location-number').textContent = index + 1;

        // Update input names with correct indices
        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            // Extract platform and program indices from the first input's name
            const namePattern = /platforms\[(\d+)\]\[programs\]\[(\d+)\]\[kpis\]\[\d+\]/;
            const match = input.name.match(namePattern);

            if (match) {
                const platformIndex = match[1];
                const programIndex = match[2];
                // Replace only the KPI index
                input.name = input.name.replace(
                    /platforms\[\d+\]\[programs\]\[\d+\]\[kpis\]\[\d+\]/,
                    `platforms[${platformIndex}][programs][${programIndex}][kpis][${index}]`
                );
            }
        });
    });
}

// Update remove buttons visibility
function updateRemoveButtons(kpiContainer) {
    const kpiGroup = kpiContainer.querySelector('.kpi-group');
    const removeButtons = kpiGroup.querySelectorAll('.remove-field');

    // Show remove buttons only if there's more than one KPI
    if (removeButtons.length > 1) {
        removeButtons.forEach(btn => {
            btn.style.display = 'block';
        });
    } else {
        removeButtons.forEach(btn => {
            btn.style.display = 'none';
        });
    }
}

// Toggle platform remove buttons
function toggleRemovePlatformButtons() {
    const platformContainer = document.getElementById('platform-container');
    const platformCards = platformContainer.querySelectorAll('.platform-card');

    // Hide the first platform's remove button always
    if (platformCards.length > 0) {
        const removeButtons = platformContainer.querySelectorAll('.remove-platform-btn');

        // Hide all remove buttons if there's only one platform
        if (platformCards.length <= 1) {
            removeButtons.forEach(button => {
                button.style.display = 'none';
            });
        } else {
            // Otherwise show all but the first platform's remove button
            removeButtons[0].style.display = 'none';
            for (let i = 1; i < removeButtons.length; i++) {
                removeButtons[i].style.display = 'block';
            }
        }
    }
}

// Initialize when document loads
document.addEventListener('DOMContentLoaded', function() {
    toggleRemovePlatformButtons();

    // Initialize each KPI container
    const kpiContainers = document.querySelectorAll('.kpi-container');
    kpiContainers.forEach(container => {
        updateRemoveButtons(container);
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to the date inputs for inline editing
    document.querySelectorAll('.editable-date').forEach(input => {
        input.addEventListener('change', function() {
            saveDateField(this);
        });
    });
});

function saveDateField(inputElement) {
    const newValue = inputElement.value;
    const fieldName = inputElement.getAttribute('data-field');
    const projectId = inputElement.getAttribute('data-project-id');

    // Show loading indicator
    inputElement.classList.add('saving');
    inputElement.disabled = true;

    // Send data to server
    fetch(`/projects/${projectId}/update-field`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                field: fieldName,
                value: newValue
            })
        })
        .then(response => response.json())
        .then(data => {
            inputElement.classList.remove('saving');
            inputElement.disabled = false;

            if (data.success) {
                showToast('บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
            } else {
                showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        })
        .catch(error => {
            inputElement.classList.remove('saving');
            inputElement.disabled = false;
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            console.error('Error:', error);
        });
}

function showToast(message, type = 'success') {
    // Create toast container if it doesn't exist
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-notification';

    // Set background color and icon based on type
    if (type === 'success') {
        toast.style.backgroundColor = '#28a745';
        toast.innerHTML = `<i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'warning') {
        toast.style.backgroundColor = '#ffc107';
        toast.style.color = '#212529';
        toast.innerHTML = `<i class='bx bx-info-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'error') {
        toast.style.backgroundColor = '#dc3545';
        toast.innerHTML = `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'info') {
        toast.style.backgroundColor = '#17a2b8';
        toast.innerHTML =
            `<i class='bx bx-loader-alt bx-spin' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    }

    // Add to container and animate
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<script>
// JavaScript for managing platforms, programs, and KPIs
let platformCount = 1;

// Add a new platform
window.addPlatform = function() {
    const container = document.getElementById('platform-container');
    const platformTemplate = document.querySelector('.platform-card').cloneNode(true);

    platformTemplate.querySelector('.card-title').textContent = `แพลตฟอร์มที่ ${platformCount + 1}`;

    // Clear values in all inputs and update indices
    const inputs = platformTemplate.querySelectorAll('input');
    inputs.forEach(input => {
        const name = input.name.replace(/\[\d+\]/, `[${platformCount}]`);
        input.name = name;
        input.value = '';
    });

    // Reset KPI section - remove any extra KPI rows
    const kpiContainer = platformTemplate.querySelector('.kpi-container');
    const kpiGroup = kpiContainer.querySelector('.kpi-group');
    const kpiRows = kpiGroup.querySelectorAll('.d-flex');

    // Keep only the first KPI row and clear its value
    for (let i = 1; i < kpiRows.length; i++) {
        kpiRows[i].remove();
    }
    const firstKpiInput = kpiGroup.querySelector('input[type="text"]');
    if (firstKpiInput) firstKpiInput.value = '';

    // Show the remove button
    const removeBtn = platformTemplate.querySelector('.remove-platform-btn');
    removeBtn.style.display = 'block';

    container.appendChild(platformTemplate);
    platformCount++;
    updatePlatformNumbers();
    toggleRemovePlatformButtons();
}

// Remove a platform
window.removePlatform = function(button) {
    if (confirm('คุณต้องการลบแพลตฟอร์มนี้ใช่หรือไม่?')) {
        const platformCard = button.closest('.platform-card');
        platformCard.remove();
        updatePlatformNumbers();
        toggleRemovePlatformButtons();
    }
}

// Update platform numbering
function updatePlatformNumbers() {
    const platformContainer = document.getElementById('platform-container');
    const platformCards = platformContainer.querySelectorAll('.platform-card');
    platformCards.forEach((card, index) => {
        card.querySelector('.card-title').textContent = `แพลตฟอร์มที่ ${index + 1}`;
        const inputs = card.querySelectorAll('input');
        inputs.forEach(input => {
            const name = input.name.replace(/\[\d+\]/, `[${index}]`);
            input.name = name;
        });
    });
    platformCount = platformCards.length;
}

// Add a new KPI
window.addKpi = function(btn) {
    const kpiContainer = btn.closest('.kpi-container');
    const kpiGroup = kpiContainer.querySelector('.kpi-group');
    const kpiTemplate = kpiGroup.querySelector('.d-flex').cloneNode(true);

    // Clear value of the new KPI input
    const kpiInput = kpiTemplate.querySelector('input[type="text"]');
    kpiInput.value = '';

    // Update hidden inputs
    const hiddenInputs = kpiTemplate.querySelectorAll('input[type="hidden"]');
    hiddenInputs.forEach(input => {
        input.value = '';
    });

    // Show the remove button
    const removeBtn = kpiTemplate.querySelector('.remove-field');
    removeBtn.style.display = 'block';

    kpiGroup.appendChild(kpiTemplate);
    updateKpiNumbers(kpiContainer);
    updateRemoveButtons(kpiContainer);
}

// Remove a KPI
window.removeKpi = function(btn) {
    if (confirm('คุณต้องการลบ KPI นี้ใช่หรือไม่?')) {
        const kpiRow = btn.closest('.d-flex');
        const kpiContainer = btn.closest('.kpi-container');
        const kpiGroup = kpiContainer.querySelector('.kpi-group');

        if (kpiGroup.querySelectorAll('.d-flex').length > 1) {
            kpiRow.remove();
            updateKpiNumbers(kpiContainer);
            updateRemoveButtons(kpiContainer);
        } else {
            alert('ต้องมี KPI อย่างน้อย 1 รายการ');
        }
    }
}

// Update KPI numbering
function updateKpiNumbers(kpiContainer) {
    const kpiGroup = kpiContainer.querySelector('.kpi-group');
    const kpiRows = kpiGroup.querySelectorAll('.d-flex');

    kpiRows.forEach((row, index) => {
        // Update number label
        row.querySelector('.location-number').textContent = index + 1;

        // Update input names with correct indices
        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            // Extract platform and program indices from the first input's name
            const namePattern = /platforms\[(\d+)\]\[programs\]\[(\d+)\]\[kpis\]\[\d+\]/;
            const match = input.name.match(namePattern);

            if (match) {
                const platformIndex = match[1];
                const programIndex = match[2];
                // Replace only the KPI index
                input.name = input.name.replace(
                    /platforms\[\d+\]\[programs\]\[\d+\]\[kpis\]\[\d+\]/,
                    `platforms[${platformIndex}][programs][${programIndex}][kpis][${index}]`
                );
            }
        });
    });
}

// Update remove buttons visibility
function updateRemoveButtons(kpiContainer) {
    const kpiGroup = kpiContainer.querySelector('.kpi-group');
    const removeButtons = kpiGroup.querySelectorAll('.remove-field');

    // Show remove buttons only if there's more than one KPI
    if (removeButtons.length > 1) {
        removeButtons.forEach(btn => {
            btn.style.display = 'block';
        });
    } else {
        removeButtons.forEach(btn => {
            btn.style.display = 'none';
        });
    }
}

// Toggle platform remove buttons
function toggleRemovePlatformButtons() {
    const platformContainer = document.getElementById('platform-container');
    const platformCards = platformContainer.querySelectorAll('.platform-card');

    // Hide the first platform's remove button always
    if (platformCards.length > 0) {
        const removeButtons = platformContainer.querySelectorAll('.remove-platform-btn');

        // Hide all remove buttons if there's only one platform
        if (platformCards.length <= 1) {
            removeButtons.forEach(button => {
                button.style.display = 'none';
            });
        } else {
            // Otherwise show all but the first platform's remove button
            removeButtons[0].style.display = 'none';
            for (let i = 1; i < removeButtons.length; i++) {
                removeButtons[i].style.display = 'block';
            }
        }
    }
}

// Save platform data
window.savePlatformData = function() {
    // Show loading indicator
    showToast('กำลังบันทึกข้อมูล...', 'info');

    // Collect all platform data
    const formData = new FormData();
    const projectId = document.querySelector('input[name="project_id"]').value;

    // Get all platform data from form
    const platformCards = document.querySelectorAll('.platform-card');
    const platformsData = [];

    platformCards.forEach((card, platformIndex) => {
        const platformId = card.querySelector(`input[name="platforms[${platformIndex}][platform_id]"]`)
            .value;
        const platformName = card.querySelector(`input[name="platforms[${platformIndex}][name]"]`).value;

        const platformData = {
            platform_id: platformId,
            name: platformName,
            programs: []
        };

        // Get all programs for this platform
        const programInputs = card.querySelectorAll(
            `input[name^="platforms[${platformIndex}][programs]"][name$="[name]"]`);
        programInputs.forEach(programInput => {
            // Extract program index from name attribute
            const programMatch = programInput.name.match(/platforms\[\d+\]\[programs\]\[(\d+)\]/);
            if (programMatch) {
                const programIndex = programMatch[1];
                const programId = card.querySelector(
                    `input[name="platforms[${platformIndex}][programs][${programIndex}][program_id]"]`
                ).value;
                const programName = programInput.value;

                const programData = {
                    program_id: programId,
                    name: programName,
                    kpis: []
                };

                // Get all KPIs for this program
                const kpiInputs = card.querySelectorAll(
                    `input[name^="platforms[${platformIndex}][programs][${programIndex}][kpis]"][name$="[name]"]`
                );
                kpiInputs.forEach(kpiInput => {
                    // Extract KPI index from name attribute
                    const kpiMatch = kpiInput.name.match(
                        /platforms\[\d+\]\[programs\]\[\d+\]\[kpis\]\[(\d+)\]/);
                    if (kpiMatch) {
                        const kpiIndex = kpiMatch[1];
                        const kpiId = card.querySelector(
                            `input[name="platforms[${platformIndex}][programs][${programIndex}][kpis][${kpiIndex}][kpi_id]"]`
                        ).value;
                        const kpiName = kpiInput.value;

                        programData.kpis.push({
                            kpi_id: kpiId,
                            name: kpiName
                        });
                    }
                });

                platformData.programs.push(programData);
            }
        });

        platformsData.push(platformData);
    });

    // Send data to server
    fetch(`/api/projects/${projectId}/save-platforms`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                platforms: platformsData
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showToast('บันทึกข้อมูลยุทธศาสตร์เรียบร้อยแล้ว', 'success');

                // Update platform IDs in hidden fields
                if (data.platforms) {
                    data.platforms.forEach((platform, index) => {
                        const platformIdField = document.querySelector(
                            `input[name="platforms[${index}][platform_id]"]`);
                        if (platformIdField && platform.id) {
                            platformIdField.value = platform.id;
                        }

                        // Update program IDs
                        if (platform.programs) {
                            platform.programs.forEach((program, programIndex) => {
                                const programIdField = document.querySelector(
                                    `input[name="platforms[${index}][programs][${programIndex}][program_id]"]`
                                );
                                if (programIdField && program.id) {
                                    programIdField.value = program.id;
                                }

                                // Update KPI IDs
                                if (program.kpis) {
                                    program.kpis.forEach((kpi, kpiIndex) => {
                                        const kpiIdField = document.querySelector(
                                            `input[name="platforms[${index}][programs][${programIndex}][kpis][${kpiIndex}][kpi_id]"]`
                                        );
                                        if (kpiIdField && kpi.id) {
                                            kpiIdField.value = kpi.id;
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            } else {
                showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
        });
};

// Helper function to show toast notifications
function showToast(message, type = 'success') {
    // Create toast container if it doesn't exist
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-notification';

    // Set background color and icon based on type
    if (type === 'success') {
        toast.style.backgroundColor = '#28a745';
        toast.innerHTML = `<i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'warning') {
        toast.style.backgroundColor = '#ffc107';
        toast.style.color = '#212529';
        toast.innerHTML = `<i class='bx bx-info-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'error') {
        toast.style.backgroundColor = '#dc3545';
        toast.innerHTML = `<i class='bx bx-error-circle' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    } else if (type === 'info') {
        toast.style.backgroundColor = '#17a2b8';
        toast.innerHTML =
            `<i class='bx bx-loader-alt bx-spin' style='margin-right:8px; font-size:20px;'></i> ${message}`;
    }

    // Add to container and animate
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Initialize when document loads
document.addEventListener('DOMContentLoaded', function() {
    toggleRemovePlatformButtons();

    // Initialize each KPI container
    const kpiContainers = document.querySelectorAll('.kpi-container');
    kpiContainers.forEach(container => {
        updateRemoveButtons(container);
    });
});
</script>

<script>
// Speaker inline editing functionality
let originalSpeakerValue = "<?php echo e($project->Name_Speaker); ?>";

// Start editing the speaker field
function startSpeakerEdit() {
    // Hide display view, show edit view
    document.getElementById('speaker-display').style.display = 'none';
    document.getElementById('speaker-editor').style.display = 'flex';

    // Focus on the input and select all text
    const input = document.getElementById('speaker-input');
    input.focus();
    input.select();

    // Add event listeners for keyboard shortcuts
    input.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            saveSpeaker();
        } else if (event.key === 'Escape') {
            event.preventDefault();
            cancelSpeakerEdit();
        }
    });
}

// Save speaker changes
function saveSpeaker() {
    const input = document.getElementById('speaker-input');
    const newValue = input.value.trim();
    const projectId = '<?php echo e($project->Id_Project); ?>';

    // Hide editor, show saving indicator
    document.getElementById('speaker-editor').style.display = 'none';
    document.getElementById('speaker-saving').style.display = 'block';

    // Send data to server
    fetch(`/api/projects/${projectId}/speaker`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                'value': newValue
            })
        })
        .then(response => response.json())
        .then(data => {
            // Hide saving indicator
            document.getElementById('speaker-saving').style.display = 'none';

            if (data.success) {
                // Update display and show it
                const displayElement = document.getElementById('speaker-value');
                displayElement.textContent = newValue || 'คลิกเพื่อเพิ่มชื่อวิทยากร';
                document.getElementById('speaker-display').style.display = 'block';

                // Update original value
                originalSpeakerValue = newValue;

                // Show success toast
                showToast('บันทึกข้อมูลวิทยากรเรียบร้อยแล้ว', 'success');
            } else {
                // Show error and revert to edit mode
                document.getElementById('speaker-editor').style.display = 'flex';
                showToast(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
            }
        })
        .catch(error => {
            // Hide saving indicator, show error
            document.getElementById('speaker-saving').style.display = 'none';
            document.getElementById('speaker-editor').style.display = 'flex';
            showToast('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์', 'error');
            console.error('Error:', error);
        });
}

// Cancel speaker editing
function cancelSpeakerEdit() {
    // Reset input value to original
    document.getElementById('speaker-input').value = originalSpeakerValue;

    // Hide editor, show display
    document.getElementById('speaker-editor').style.display = 'none';
    document.getElementById('speaker-display').style.display = 'block';
}

// Add this to your editBigFormProject.js file or within a script tag
document.addEventListener('DOMContentLoaded', function() {
    initializeSpeaker();
});

// Initialize speaker from database if it exists
function initializeSpeaker() {
    const speakerValue = "<?php echo e($project->Name_Speaker); ?>";
    originalSpeakerValue = speakerValue;

    // Update display text
    const displayElement = document.getElementById('speaker-value');
    displayElement.textContent = speakerValue ? speakerValue : 'คลิกเพื่อเพิ่มชื่อวิทยากร';

    // Set input value
    document.getElementById('speaker-input').value = speakerValue;
}

// Add this to your JavaScript code
document.addEventListener('DOMContentLoaded', function() {
    const speakerField = document.getElementById('Name_Speaker');
    if (speakerField) {
        speakerField.addEventListener('focus', function() {
            const placeholder = this.querySelector('.placeholder-text');
            if (placeholder) {
                placeholder.remove();
                this.innerHTML = '';
            }
        });

        speakerField.addEventListener('blur', function() {
            if (this.innerHTML.trim() === '' || this.innerHTML.trim() === '<br>') {
                this.innerHTML =
                    '<span class="placeholder-text" style="color: #6c757d;">กรุณากรอกชื่อวิทยากร</span>';
            }
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle between short-term and long-term project sections
    const shortTermRadio = document.getElementById('shortTermProject');
    const longTermRadio = document.getElementById('longTermProject');
    const shortProjectSection = document.getElementById('shortProjectSection');
    const longProjectSection = document.getElementById('longProjectSection');

    // Initialize project type display
    if (shortTermRadio.checked) {
        shortProjectSection.classList.remove('hidden');
        longProjectSection.classList.add('hidden');
    } else if (longTermRadio.checked) {
        longProjectSection.classList.remove('hidden');
        shortProjectSection.classList.add('hidden');
    }

    // Setup event listeners for radio buttons
    shortTermRadio.addEventListener('change', function() {
        if (this.checked) {
            shortProjectSection.classList.remove('hidden');
            longProjectSection.classList.add('hidden');
        }
    });

    longTermRadio.addEventListener('change', function() {
        if (this.checked) {
            longProjectSection.classList.remove('hidden');
            shortProjectSection.classList.add('hidden');
        }
    });

    // Function to add a new method field for short projects
    window.addMethodField = function() {
        const methodContainer = document.getElementById('methodContainer');
        const methodItems = methodContainer.querySelectorAll('.location-item');
        const newIndex = methodItems.length + 1;

        const template = `
            <div class="form-group location-item mt-2">
                <div class="d-flex align-items-center">
                    <div class="input-group">
                        <span class="input-group-text location-number">${newIndex}</span>
                        <input type="text" class="form-control method-field"
                            name="Details_Short_Project[]" placeholder="เพิ่มรายการ">
                        <button type="button" class="btn btn-danger btn-sm remove-field"
                            onclick="removeMethodField(this)">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        methodContainer.insertAdjacentHTML('beforeend', template);

        // Show all remove buttons if there's more than one item
        if (newIndex > 1) {
            const removeButtons = methodContainer.querySelectorAll('.remove-field');
            removeButtons.forEach(button => {
                button.style.display = 'block';
            });
        }

        // Focus on the newly added input field
        const newInput = methodContainer.lastElementChild.querySelector('.method-field');
        newInput.focus();
    };

    // Function to remove a method field
    window.removeMethodField = function(button) {
        const methodContainer = document.getElementById('methodContainer');
        const methodItems = methodContainer.querySelectorAll('.location-item');

        // Don't remove if there's only one item
        if (methodItems.length <= 1) {
            alert('ต้องมีวิธีการดำเนินงานอย่างน้อย 1 รายการ');
            return;
        }

        // Ask for confirmation before removing
        if (!confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')) {
            return;
        }

        // Remove the item
        const item = button.closest('.location-item');
        item.remove();

        // Hide the remove button on the first item if there's only one left
        const remainingItems = methodContainer.querySelectorAll('.location-item');
        if (remainingItems.length === 1) {
            remainingItems[0].querySelector('.remove-field').style.display = 'none';
        }

        // Update numbering
        remainingItems.forEach((item, index) => {
            item.querySelector('.location-number').textContent = index + 1;
        });
    };

    // Function to handle changes in PDCA month checkboxes
    const pdcaCheckboxes = document.querySelectorAll('.checkbox-container input[type="checkbox"]');
    pdcaCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // This is where you would typically handle AJAX saving, but since we're
            // moving away from inline editing, we'll collect all this data when the form submits
            console.log('Checkbox changed:', this.name, 'to', this.checked);
        });
    });

    // Auto-resize textareas for PDCA details
    const pdcaTextareas = document.querySelectorAll('.plan-textarea');
    pdcaTextareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Initialize height
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    });

    // Initialize remove button visibility for method fields
    const methodContainer = document.getElementById('methodContainer');
    if (methodContainer) {
        const methodItems = methodContainer.querySelectorAll('.location-item');
        if (methodItems.length <= 1) {
            methodItems.forEach(item => {
                const removeBtn = item.querySelector('.remove-field');
                if (removeBtn) removeBtn.style.display = 'none';
            });
        }
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle between select and manual input for indicators
    document.getElementById('toggleIndicatorInput').addEventListener('click', function() {
        const selectField = document.getElementById('Success_Indicators');
        const textareaField = document.getElementById('Success_Indicators_Other');

        if (textareaField.style.display === 'none') {
            selectField.disabled = true;
            textareaField.style.display = 'block';
        } else {
            selectField.disabled = false;
            textareaField.style.display = 'none';
            textareaField.value = '';
        }
    });

    // Toggle between select and manual input for targets
    document.getElementById('toggleTargetInput').addEventListener('click', function() {
        const selectField = document.getElementById('Value_Target');
        const textareaField = document.getElementById('Value_Target_Other');

        if (textareaField.style.display === 'none') {
            selectField.disabled = true;
            textareaField.style.display = 'block';
        } else {
            selectField.disabled = false;
            textareaField.style.display = 'none';
            textareaField.value = '';
        }
    });

    // Populate target dropdown when indicator is selected
    document.getElementById('Success_Indicators').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const targetValue = selectedOption.getAttribute('data-target-value');
        const targetSelect = document.getElementById('Value_Target');

        // Clear existing options
        targetSelect.innerHTML = '';

        // Add default option
        const defaultOption = document.createElement('option');
        defaultOption.text = 'กรอกค่าเป้าหมาย';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        targetSelect.add(defaultOption);

        // Add target value option if available
        if (targetValue) {
            const option = document.createElement('option');
            option.text = targetValue;
            option.value = targetValue;
            targetSelect.add(option);
        }
    });

    // Add indicator to the list
    document.getElementById('addIndicatorBtn').addEventListener('click', function() {
        // Get indicator value
        let indicatorValue = '';
        let indicatorSelect = document.getElementById('Success_Indicators');
        let indicatorOther = document.getElementById('Success_Indicators_Other');

        if (indicatorOther.style.display === 'block' && indicatorOther.value.trim() !== '') {
            indicatorValue = indicatorOther.value.trim();
        } else if (indicatorSelect.value) {
            indicatorValue = indicatorSelect.value;
        } else {
            alert('กรุณากรอกตัวชี้วัดความสำเร็จ');
            return;
        }

        // Get target value
        let targetValue = '';
        let targetSelect = document.getElementById('Value_Target');
        let targetOther = document.getElementById('Value_Target_Other');

        if (targetOther.style.display === 'block' && targetOther.value.trim() !== '') {
            targetValue = targetOther.value.trim();
        } else if (targetSelect.value) {
            targetValue = targetSelect.value;
        } else {
            alert('กรุณากรอกค่าเป้าหมาย');
            return;
        }

        // Get target type (1 = quantitative, 2 = qualitative)
        const targetType = document.querySelector('input[name="target_type"]:checked')?.value || '1';

        // Create a new indicator item
        const template = document.getElementById('indicatorItemTemplate').innerHTML;
        const id = new Date().getTime();
        let newIndicatorHtml = template
            .replace(/__ID__/g, id)
            .replace(/__INDICATOR__/g, indicatorValue)
            .replace(/__TARGET__/g, targetValue)
            .replace(/__TARGET_TYPE__/g, targetType);

        // Add to container
        const container = document.getElementById('indicatorsContainer');
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newIndicatorHtml;
        container.appendChild(tempDiv.firstElementChild);

        // Reset form
        indicatorSelect.selectedIndex = 0;
        indicatorOther.value = '';
        targetSelect.innerHTML = '<option value="" disabled selected>กรอกค่าเป้าหมาย</option>';
        targetOther.value = '';

        // Add event listener to delete button
        setupDeleteButtons();
    });

    // Function to set up delete buttons
    function setupDeleteButtons() {
        document.querySelectorAll('.delete-indicator').forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.indicator-item');
                item.remove();
            });
        });
    }

    // Initialize delete buttons for existing items
    setupDeleteButtons();
});
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/Project/editBigFormProject.blade.php ENDPATH**/ ?>