<link rel="stylesheet" href="<?php echo e(asset('css/fiscalYearQuarter.css')); ?>">


<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-start align-items-center">
        <a href="<?php echo e(route('fiscalYearQuarter.index')); ?>" class="back-btn">
            <i class='bx bxs-left-arrow-square'></i>
        </a>
        <h1 class="ms-3">แก้ไขปีงบประมาณและไตรมาส</h1>
    </div>

    <form action="<?php echo e(route('fiscalYearQuarter.update', $fiscalYearQuarter->Id_Quarter_Project)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="card p-3 mt-3">
            <div class="form-group">
                <label for="Fiscal_Year">ปีงบประมาณ</label>
                <input type="number" name="Fiscal_Year" class="form-control" value="<?php echo e($fiscalYearQuarter->Fiscal_Year); ?>" required>
            </div>
            <div class="form-group">
                <label for="Quarter">ไตรมาส</label>
                <input type="number" name="Quarter" class="form-control" value="<?php echo e($fiscalYearQuarter->Quarter); ?>" required min="1" max="4">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">อัปเดต</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/fiscalYearQuarter/edit.blade.php ENDPATH**/ ?>