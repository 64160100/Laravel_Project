<link rel="stylesheet" href="<?php echo e(asset('css/fiscalYearQuarter.css')); ?>">


<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-start align-items-center">
            <a href="<?php echo e(route('setting')); ?>" class="back-btn">
                <i class='bx bxs-left-arrow-square'></i>
            </a>
            <h1 class="ms-3">ปีงบประมาณและไตรมาส</h1>
        </div>
        <form action="<?php echo e(route('fiscalYearQuarter.create')); ?>" method="GET">
            <button class="btn-add">สร้างปีงบประมาณ</button>
        </form>
    </div>
    
    <table class="table table-striped">
        <thead class="table-header">
            <tr>
                <th>ลำดับ</th>
                <th>ปีงบประมาณ</th>
                <th>ไตรมาส</th>
                <th>การดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $fiscalYearsAndQuarters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->Fiscal_Year); ?></td>
                <td><?php echo e($item->Quarter); ?></td>
                <td>
                    <div class="btn-manage">
                        <form action="<?php echo e(route('fiscalYearQuarter.edit', $item->Id_Quarter_Project)); ?>" method="GET">
                            <button class="btn-edit">
                                <i class='bx bx-edit'></i>&nbsp;แก้ไข
                            </button>
                        </form>
                        <form action="<?php echo e(route('fiscalYearQuarter.destroy', $item->Id_Quarter_Project)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-delete " onclick="return confirm('คุณยืนยันที่จะลบข้อมูลนี้หรือไม่');">
                                <i class='bx bx-trash'></i>&nbsp;ลบ
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/fiscalYearQuarter/index.blade.php ENDPATH**/ ?>