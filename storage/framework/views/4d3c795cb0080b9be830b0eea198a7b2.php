    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="<?php echo e(asset('css/button.css')); ?>"> -->
    <link rel="stylesheet" href="<?php echo e(asset('css/viewStrategy.css')); ?>">
    <title>ข้อมูลแผนยุทธศาสตร์</title>


<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?php echo e(route('strategic.index')); ?>" class="back-btn">
                <i class='bx bxs-left-arrow-square'></i>
            </a>
            <div class="header-bar">
                <h3><?php echo e($strategic->Name_Strategic_Plan); ?></h3>
                <a class='bx bxs-down-arrow ms-3' style='color:#ffffff' data-bs-toggle="collapse" href="#collapseExample"
                role="button" aria-expanded="false" aria-controls="collapseExample"></a>
                <a class='bx bx-table ms-3' style='color:#ffffff; cursor: pointer;' data-bs-toggle="modal"
                data-bs-target="#strategicAnalysisModal" title="แสดงการวิเคราะห์บริบทเชิงกลยุทธ์"></a>
            </div>
            <div>
                <button class='btn-add' data-bs-toggle="modal" data-bs-target="#ModalAddStrategy">เพิ่มข้อมูล</button>
            </div>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="text-box mt-2">
                <?php echo e($strategic->Goals_Strategic); ?>

            </div>
        </div>

        <div>
            <table>
                <thead class="table-header">
                    <tr style="text-align: center;">
                        <th>กลยุทธ์</th>
                        <th>วัตถุประสงค์เชิงกลยุทธ์<br>(Strategic Objectives : SO)</th>
                        <th>ตัวชี้วัดกลยุทธ์</th>
                        <th>ค่าเป้าหมาย</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <?php $__currentLoopData = $strategy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php 
                        $rowspan = max(count($strategy->kpis ?? []), 1);  
                    ?>

                    <?php if($strategy->kpis->isNotEmpty()): ?>
                        <?php $__currentLoopData = $strategy->kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kpi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="<?php echo e($index == 0 ? 'strategy-start' : 'strategy-row'); ?>">
                                <?php if($index == 0): ?>
                                    <td rowspan="<?php echo e($rowspan); ?>"><?php echo e($strategy->Name_Strategy); ?></td>
                                    <td rowspan="<?php echo e($rowspan); ?>">
                                        <?php $__currentLoopData = $strategy->strategicObjectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($objective->Details_Strategic_Objectives); ?> <br><br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                <?php endif; ?>
                                <td><?php echo e($kpi->Name_Kpi); ?></td>
                                <td><?php echo e($kpi->Target_Value); ?></td>

                                <?php if($index == 0): ?>
                                    <td rowspan="<?php echo e($rowspan); ?>">
                                        <div class="btn-manage">
                                            <form action="<?php echo e(route('strategy.edit', $strategy->Id_Strategy)); ?>" method="GET">
                                                <button type="submit" class="btn-edit">
                                                    <i class='bx bx-edit'></i>&nbsp;แก้ไข
                                                </button>
                                            </form>

                                            <form action="<?php echo e(route('strategy.destroy', $strategy->Id_Strategy)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn-delete " onclick="return confirm('คุณยืนยันที่จะลบข้อมูลนี้หรือไม่');">
                                                    <i class='bx bx-trash'></i>&nbsp;ลบ
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <tr class="<?php echo e($strategy->Name_Strategy ? 'strategy-start' : 'strategy-row'); ?>">
                            <td rowspan="1"><?php echo e($strategy->Name_Strategy); ?></td>
                            <td rowspan="1">
                                <?php $__currentLoopData = $strategy->strategicObjectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($objective->Details_Strategic_Objectives); ?> <br><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="btn-manage">
                                    <form action="<?php echo e(route('strategy.edit', $strategy->Id_Strategy)); ?>" method="GET">
                                        <button type="submit" class="btn-edit">
                                            <i class='bx bx-edit'></i>&nbsp;แก้ไข
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('strategy.destroy', $strategy->Id_Strategy)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-delete" onclick="return confirm('คุณยืนยันที่จะลบข้อมูลนี้หรือไม่');">
                                            <i class='bx bx-trash'></i> ลบ
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>

        </div>
    </div>
    <?php echo $__env->make('strategy.modelStrategy', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('strategy.addStrategy', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/strategy/viewStrategy.blade.php ENDPATH**/ ?>