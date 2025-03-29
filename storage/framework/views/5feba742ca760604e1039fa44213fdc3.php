<head>
    <link rel="stylesheet" href="<?php echo e(asset('css/setting.css')); ?>">
</head>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>ตั้งค่าระบบ</h1>
    <p class="text-style">จัดการตั้งค่าทั้งหมดของระบบ</p>

    <a href="<?php echo e(route('strategic.index')); ?>" class="link-style">
        <div class="card-style">
            <div class="icon-style">
                <i class='bx bx-target-lock'></i>
            </div>
            <div>
                <h2>ตั้งค่าแผนยุทธศาสตร์และกลยุทธ์</h2>
                <p class="text-style">กำหนดข้อมูลยุทธศาสตร์และกลยุทธ์</p>
            </div>
        </div>
    </a>

    <a href="<?php echo e(route('fiscalYearQuarter.index')); ?>" class="link-style">
        <div class="card-style">
            <div class="icon-style">
                <i class='bx bx-calendar'></i>
            </div>
            <div>
                <h2>ตั้งค่าไตรมาส</h2>
                <p class="text-style">กำหนดไตรมาสและปีงบประมาณ</p>
            </div>
        </div>
    </a>

    <a href="<?php echo e(route('showSdg')); ?>" class="link-style">
        <div class="card-style">
            <div class="icon-style">
                <i class='bx bx-leaf'></i>
            </div>
            <div>
                <h2>ตั้งค่าเป้าหมายการพัฒนาที่ยั่งยืน</h2>
                <p class="text-style">กำหนดเป้าหมายการพัฒนาองค์กรในระยะยาว</p>
            </div>
        </div>
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/setting.blade.php ENDPATH**/ ?>