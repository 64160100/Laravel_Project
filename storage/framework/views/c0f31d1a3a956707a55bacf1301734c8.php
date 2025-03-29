<?php $__currentLoopData = $sdg; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Sdg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="modal fade" id="editSdg<?php echo e($Sdg->id_SDGs); ?>" tabindex="-1" aria-labelledby="editSdgLabel<?php echo e($Sdg->id_SDGs); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo e(route('editSDG', $Sdg->id_SDGs)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSdgLabel<?php echo e($Sdg->id_SDGs); ?>">แก้ไขเป้าหมายการพัฒนา</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Name_SDGs<?php echo e($Sdg->id_SDGs); ?>" class="col-form-label">ชื่อเป้าหมาย:</label>
                        <input type="text" class="form-control" id="Name_SDGs<?php echo e($Sdg->id_SDGs); ?>" name="Name_SDGs" value="<?php echo e($Sdg->Name_SDGs); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH /app/resources/views/SDG/editSDG.blade.php ENDPATH**/ ?>