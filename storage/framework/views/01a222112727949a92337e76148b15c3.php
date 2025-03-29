<div class="modal fade" id="ModalAddStrategy" tabindex="-1" aria-labelledby="ModalAddStrategyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAddStrategyLabel">เพิ่มข้อมูลกลยุทธ์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addstrategY" action="<?php echo e(route('strategy.add', $strategic->Id_Strategic)); ?>" method="POST">
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
                    <!-- strategy -->
                    <input type="hidden" name="Strategic_Id" value="<?php echo e($strategic->Id_Strategic); ?>">
                    <div class="mb-3">
                        <label for="Name_Strategy" class="form-label">ชื่อกลยุทธ์</label>
                        <input type="text" class="form-control" id="Name_Strategy" name="Name_Strategy" placeholder="กรอกชื่อกลยุทธ์" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">ถัดไป</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /app/resources/views/strategy/addStrategy.blade.php ENDPATH**/ ?>