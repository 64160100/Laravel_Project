<?php $__currentLoopData = $strategic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="ModalEditStrategic<?php echo e($strategic->Id_Strategic); ?>" tabindex="-1" aria-labelledby="ModalEditStrategicLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditStrategicLabel">แก้ไขข้อมูลแผนยุทธศาสตร์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('strategic.update', $strategic->Id_Strategic)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Name_Strategic_Plan">ชื่อแผนยุทธศาสตร์</label>
                        <input type="text" class="form-control" id="Name_Strategic_Plan" name="Name_Strategic_Plan" value="<?php echo e($strategic->Name_Strategic_Plan); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Goals_Strategic">เป้าหมายยุทธศาสตร์</label>
                        <textarea class="form-control" id="Goals_Strategic" name="Goals_Strategic" required><?php echo e($strategic->Goals_Strategic); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Fiscal_Year_Quarter_Add">ปีงบประมาณและไตรมาส</label>
                        <select class="form-control" id="Fiscal_Year_Quarter_Add" name="Fiscal_Year_Quarter_Add" required>
                            <option value="">เลือกปีงบประมาณและไตรมาส</option>
                            <?php $__currentLoopData = $quarters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quarter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($quarter->Id_Quarter_Project); ?>" <?php echo e(optional($strategic->quarterProjects->first())->Quarter_Project_Id == $quarter->Id_Quarter_Project ? 'selected' : ''); ?>>
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
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /app/resources/views/strategic/editStrategic.blade.php ENDPATH**/ ?>