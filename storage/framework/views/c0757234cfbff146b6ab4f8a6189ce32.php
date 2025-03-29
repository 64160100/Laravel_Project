<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เป้าหมายการพัฒนาที่ยั่งยืน</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/sdg.css')); ?>">


</head>
<body>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?php echo e(route('setting')); ?>" class="back-btn">
                <i class='bx bxs-left-arrow-square'></i>
            </a>
            <h1 class="ms-3">เป้าหมายการพัฒนาที่ยั่งยืน (Sustainable Development Goals: SDGs)</h1>
            <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#addSdg">
                เพิ่มข้อมูล
            </button>
        </div>
        
        <div>
            <table class="table table-striped">
                <thead class="table-header">
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อเป้าหมาย</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <?php $__currentLoopData = $sdg; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Sdg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($Sdg->id_SDGs); ?></td>
                        <td><?php echo e($Sdg->Name_SDGs); ?></td>
                        <td class="btn-manage">
                            <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editSdg<?php echo e($Sdg->id_SDGs); ?>" id="<?php echo e($Sdg->id_SDGs); ?>">
                                <i class='bx bx-edit'></i>&nbsp;แก้ไข
                            </button>
                            <form action="<?php echo e(route('deleteSDG', $Sdg->id_SDGs)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?> 
                                <button type="submit" class="btn-delete" onclick="return confirm('คุณต้องการลบเป้าหมายการพัฒนา(SDGs)นี้ใช่หรือไม่?')">
                                    <i class='bx bx-trash'></i>&nbsp;ลบ
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
    </div>

    <!-- modal create -->
    <div class="modal fade" id="addSdg" tabindex="-1" aria-labelledby="addSdgLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?php echo e(route('createSDG')); ?>" method="POST">
                <div class="modal-content">
                        <?php echo csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSdgLabel">เพิ่มเป้าหมายการพัฒนา </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                            <div class="mb-3">
                                <label for="Name_SDGs" class="col-form-label">ชื่อเป้าหมาย :</label>
                                <input type="text" class="form-control" id="Name_SDGs" name="Name_SDGs" placeholder="กรอกชื่อเป้าหมาย" required>
                            </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end modal -->
    <?php echo $__env->make('SDG.editSDG', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    

    
<?php $__env->stopSection(); ?>    
</body>
</html>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/SDG/Sdg.blade.php ENDPATH**/ ?>