<div class="modal fade" id="ModalAddStrategic" tabindex="-1" aria-labelledby="ModalAddStrategicLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAddStrategicLabel">เพิ่มข้อมูลแผนยุทธศาสตร์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addstrategic" action="<?php echo e(route('strategic.add')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="Name_Strategic_Plan" class="form-label">ชื่อยุทธศาสตร์</label>
                        <input type="text" class="form-control" id="Name_Strategic_Plan" name="Name_Strategic_Plan" placeholder="กรอกชื่อยุทธศาสตร์" required>
                    </div>
                    <div class="mb-3">
                        <label for="Goals_Strategic" class="form-label">เป้าหมายเชิงยุทธศาสตร์</label>
                        <textarea class="form-control" id="Goals_Strategic" name="Goals_Strategic" placeholder="กรอกเป้าหมายเชิงยุทธศาสตร์" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="Fiscal_Year_Quarter_Add" class="form-label">ปีงบประมาณและไตรมาส</label>
                        <select class="form-control" id="Fiscal_Year_Quarter_Add" name="Fiscal_Year_Quarter_Add" required>
                            <option value="">เลือกปีงบประมาณและไตรมาส</option>
                            <?php $__currentLoopData = $quarters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($quarter->Id_Quarter_Project); ?>">
                                    ปีงบประมาณ <?php echo e($quarter->Fiscal_Year); ?> ไตรมาส <?php echo e($quarter->Quarter); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH /app/resources/views/strategic/addStrategic.blade.php ENDPATH**/ ?>