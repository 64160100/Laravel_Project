<hade>
    <link rel="stylesheet" href="<?php echo e(asset('css/createFirstForm.css')); ?>">
    <style>
    /* Project Search List Styling */
    #project-list {
        position: absolute;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-top: 5px;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 0;
    }

    #project-list li {
        padding: 8px 12px;
        list-style: none;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
    }

    #project-list li:hover {
        background-color: #f8f9fa;
    }

    #project-list li.loading,
    #project-list li.error,
    #project-list li.no-results {
        color: #6c757d;
        font-style: italic;
        cursor: default;
    }

    #project-list li.error {
        color: #dc3545;
    }

    .indicator-item {
        transition: all 0.3s ease;
    }

    .indicator-item:hover {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .content-box {
        background-color: #fff;
        border-radius: 0.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    </style>
</hade>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card">
        <h3 class="card-header">แก้ไขข้อมูลโครงการ</h3>

        <div class="card-body">
            <form action="<?php echo e(route('updateProject', ['Id_Project' => $project->Id_Project])); ?>" method="POST"
                class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- ความสอดคล้องกับยุทธศาสตร์ส่วนงาน -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            1. ความสอดคล้องกับยุทธศาสตร์ส่วนงาน
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
                                <label for="Name_Strategy" class="form-label">ชื่อกลยุทธ์<span class="text-danger">
                                        *</span></label>
                                <select class="form-select <?php $__errorArgs = ['Name_Strategy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="Name_Strategy" id="Name_Strategy" required>
                                    <option value="" selected disabled>เลือกกลยุทธ์</option>
                                    <?php if($strategies->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $strategies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($strategy->Id_Strategy); ?>"
                                        <?php echo e($project->Strategy_Id == $strategy->Id_Strategy ? 'selected' : ''); ?>>
                                        <?php echo e($strategy->Name_Strategy); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <option value="" disabled>ไม่มีกลยุทธ์ที่เกี่ยวข้อง</option>
                                    <?php endif; ?>
                                </select>
                                <?php $__errorArgs = ['Name_Strategy'];
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

                <!-- ลักษณะโครงการ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            2. ลักษณะโครงการ
                        </h4>
                    </div>
                    <div class="form-group-radio">
                        <div class="radio-item">
                            <input type="radio" name="Description_Project" value="N" id="newProject"
                                onchange="toggleTextbox(this, 'textbox-projectType-')"
                                <?php echo e($project->Description_Project == 'N' ? 'checked' : ''); ?> disabled>
                            <label for="newProject">โครงการใหม่</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" name="Description_Project" value="C" id="continuousProject"
                                onchange="toggleTextbox(this, 'textbox-projectType-')"
                                <?php echo e($project->Description_Project == 'C' ? 'checked' : ''); ?> disabled>
                            <label for="continuousProject">โครงการต่อเนื่อง</label>
                        </div>
                    </div>
                    <div class="form-group"
                        style="<?php echo e($project->Description_Project == 'C' ? 'display: block;' : 'display: none;'); ?>">
                        <label for="textbox-projectType-2" class="form-label">ค้นหาโครงการเดิม</label>
                        <input type="text" id="textbox-projectType-2" class="form-control" data-group="projectType"
                            placeholder="กรอกชื่อโครงการเดิม" value="<?php echo e($project->oldProjectName); ?>" readonly>
                        <ul id="project-list" style="display: none;"></ul>
                    </div>
                </div>

                <!-- ชื่อโครงการ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            3. ชื่อโครงการ
                        </h4>
                    </div>
                    <div id="projectDetails">
                        <div class="form-group">
                            <label for="Name_Project" class="form-label">สร้างชื่อโครงการ <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['Name_Project'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="Name_Project" name="Name_Project" placeholder="กรอกชื่อโครงการ" required
                                value="<?php echo e($project->Name_Project); ?>" title="กรุณากรอกชื่อโครงการ">
                            <?php $__errorArgs = ['Name_Project'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php else: ?>
                            <div class="invalid-feedback">กรุณากรอกชื่อโครงการ</div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div id="projectContainer">
                            <?php echo csrf_field(); ?>
                            <?php $__currentLoopData = $project->subProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subProject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-group mb-2 dynamic-field">
                                <div class="input-group">
                                    <span class="input-group-text">1.<?php echo e($index + 1); ?></span>
                                    <input type="text" class="form-control" name="Name_Sub_Project[]"
                                        value="<?php echo e($subProject->Name_Sub_Project); ?>" readonly>
                                    <button type="button" class="btn btn-danger" onclick="removeField(this)">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div>
                            <button type="button" class="btn-addlist"
                                onclick="addField1('projectContainer', 'Name_Sub_Project[]')">
                                <i class='bx bx-plus-circle'></i>เพิ่มชื่อโครงการย่อย
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ตัวชี้วัดความสำเร็จของโครงการและค่าเป้าหมาย (รวมเป็นหัวข้อเดียว) -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            4. ตัวชี้วัดความสำเร็จของโครงการและค่าเป้าหมาย
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
                            <?php $__currentLoopData = $project->successIndicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $indicator->valueTargets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                        <div class="target-value"><?php echo e($target->Value_Target); ?></div>
                                        <input type="hidden" name="targets[]" value="<?php echo e($target->Value_Target); ?>">
                                        <input type="hidden" name="target_types[]"
                                            value="<?php echo e($target->Type_Value_Target); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- แหล่งงบประมาณ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            5. แหล่งงบประมาณ
                        </h4>
                    </div>
                    <div id="budgetDetails">
                        <div class="form-group-radio mb-3">
                            <div class="radio-group">
                                <input type="radio" name="Status_Budget" value="N" id="non_income"
                                    onchange="toggleIncomeForm(this)"
                                    <?php echo e($project->Status_Budget == 'N' ? 'checked' : ''); ?>>
                                <label for="non_income">ไม่ใช้งบประมาณ</label>

                                <input type="radio" name="Status_Budget" value="Y" id="income_seeking"
                                    onchange="toggleIncomeForm(this)"
                                    <?php echo e($project->Status_Budget == 'Y' ? 'checked' : ''); ?>>
                                <label for="income_seeking">ใช้งบประมาณ</label>
                            </div>
                        </div>

                        <div id="incomeForm" class="income-form"
                            style="<?php echo e($project->Status_Budget == 'Y' ? 'display: block;' : 'display: none;'); ?>">
                            <!-- แหล่งที่มาของงบประมาณ -->
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold">แหล่งที่มาของงบประมาณ:</label>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <?php $__currentLoopData = $budgetSources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check mb-2 d-flex align-items-center">
                                            <input type="checkbox" id="<?php echo e($source->Id_Budget_Source); ?>"
                                                name="budget_source[]" value="<?php echo e($source->Id_Budget_Source); ?>"
                                                class="form-check-input" data-id="<?php echo e($source->Id_Budget_Source); ?>"
                                                onchange="handleSourceCheckbox(this)"
                                                <?php echo e(in_array($source->Id_Budget_Source, $project->projectBudgetSources->pluck('Budget_Source_Id')->toArray()) ? 'checked' : ''); ?>>
                                            <label class="form-check-label d-flex align-items-center w-100"
                                                for="<?php echo e($source->Id_Budget_Source); ?>">
                                                <span class="label-text me-2"><?php echo e($source->Name_Budget_Source); ?></span>
                                                <div class="input-group" style="max-width: 200px;">
                                                    <input type="number" name="amount_<?php echo e($source->Id_Budget_Source); ?>"
                                                        class="form-control form-control-sm" placeholder="จำนวนเงิน"
                                                        value="<?php echo e($project->projectBudgetSources->firstWhere('Budget_Source_Id', $source->Id_Budget_Source)->budgetSourceTotal->Amount_Total ?? ''); ?>"
                                                        <?php echo e(in_array($source->Id_Budget_Source, $project->projectBudgetSources->pluck('Budget_Source_Id')->toArray()) ? '' : 'disabled'); ?>>
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
                                                <input type="radio" name="Expense_Status" value="O" id="single_day"
                                                    onchange="toggleDateForm(this)"
                                                    <?php echo e($expenseStatus == 'O' ? 'checked' : ''); ?>>
                                                <label for="single_day">วันเดียว</label>

                                                <input type="radio" name="Expense_Status" value="M" id="multiple_days"
                                                    onchange="toggleDateForm(this)"
                                                    <?php echo e($expenseStatus == 'M' ? 'checked' : ''); ?>>
                                                <label for="multiple_days">หลายวัน</label>
                                            </div>
                                        </div>

                                        <!-- แบบฟอร์มงบประมาณตามวันที่ (อยู่ในกรอบเดียวกัน) -->
                                        <div class="mt-4">
                                            <div id="budgetFormsContainer">
                                                <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="budget-form mb-4 pb-3 border-bottom"
                                                    data-form-index="<?php echo e($loop->index); ?>">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div style="flex: 1;">
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-3">
                                                                    <label class="form-label">วันที่ดำเนินการ</label>
                                                                    <input type="date" name="date[]"
                                                                        class="form-control" style="width: 200px;"
                                                                        value="<?php echo e($expense->Date_Expense); ?>">
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <label
                                                                        class="form-label">รายละเอียดค่าใช้จ่ายสำหรับวันนี้</label>
                                                                    <textarea name="budget_details[]"
                                                                        class="form-control"
                                                                        placeholder="ระบุรายละเอียดค่าใช้จ่ายสำหรับวันที่นี้"
                                                                        rows="2"><?php echo e($expense->Details_Expense); ?></textarea>
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
                                                                <tr class="category-row"
                                                                    id="category-row-<?php echo e($loop->index); ?>"
                                                                    data-row-id="<?php echo e($loop->index); ?>">
                                                                    <td class="align-middle text-center">1</td>
                                                                    <td class="align-middle">
                                                                        <select class="form-select category-select"
                                                                            name="budget_category[<?php echo e($loop->index); ?>][]"
                                                                            data-row-id="<?php echo e($loop->index); ?>"
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
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>

                                        <!-- ปุ่มเพิ่มแบบฟอร์ม (สำหรับหลายวัน) -->
                                        <div class="mt-3 mb-3" id="addBudgetFormBtnContainer"
                                            style="<?php echo e($expenseStatus == 'M' ? 'display: block;' : 'display: none;'); ?>">
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

                <!-- ผู้รับผิดชอบโครงการ -->
                <div class="content-box">
                    <div class="section-header">
                        <h4>
                            6. ผู้รับผิดชอบโครงการ
                        </h4>
                    </div>
                    <div id="responsibleDetails">
                        <div class="form-group">
                            <label for="employee_id" class="form-label">เลือกผู้รับผิดชอบ</label>
                            <select class="form-select <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="employee_id"
                                name="employee_id">
                                <option value="" selected disabled>เลือกผู้รับผิดชอบ</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->Id_Employee); ?>"
                                    <?php echo e($project->Employee_Id == $employee->Id_Employee ? 'selected' : ''); ?>>
                                    <?php echo e($employee->Firstname); ?> <?php echo e($employee->Lastname); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
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

                <!-- ปุ่มเสร็จสิ้น -->
                <div class="mt-3 mb-3">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bx bx-check-circle"></i> เสร็จสิ้น
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('js/createFirstForm.js')); ?>"></script>
<script src="<?php echo e(asset('js/editProjectBugget.js')); ?>"></script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/Project/editProject.blade.php ENDPATH**/ ?>