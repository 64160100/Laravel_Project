    <link rel="stylesheet" href="<?php echo e(asset('css/button.css')); ?>">

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>เพิ่มตัวชี้วัดกลยุทธ์</h1>

    <form action="<?php echo e(route('kpi.addKpi', $Id_Strategy)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div id="kpi-container">
            <div class="card p-3">
                <div class="kpi-entry mb-3">
                    <label for="Name_Kpi" class="form-label">ตัวชี้วัดกลยุทธ์</label>
                    <textarea class="form-control" name="Name_Kpi[]" placeholder="กรอกตัวชี้วัดกลยุทธ์" required></textarea>
                    <label for="Target_Value" class="form-label mt-3">ค่าเป้าหมาย</label>
                    <input type="text" class="form-control" name="Target_Value[]" placeholder="กรอกค่าเป้าหมาย" required>
                </div>
                <button type="button" class="btn-add" id="add-kpi">เพิ่มตัวชี้วัด</button>
            </div>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-kpi').addEventListener('click', function() {
        const kpiContainer = document.getElementById('kpi-container');
        const newKpiEntry = document.createElement('div');
        newKpiEntry.classList.add('card', 'p-3', 'kpi-entry', 'mb-3');
        newKpiEntry.innerHTML = `
            <div class="kpi-entry">
                <label for="Name_Kpi" class="form-label">ตัวชี้วัดกลยุทธ์</label>
                <textarea class="form-control" name="Name_Kpi[]" placeholder="กรอกตัวชี้วัดกลยุทธ์" required></textarea>
                <label for="Target_Value" class="form-label mt-3">ค่าเป้าหมาย</label>
                <input type="text" class="form-control" name="Target_Value[]" placeholder="กรอกค่าเป้าหมาย" required>
                <button type="button" class="btn btn-danger remove-kpi mt-3">ลบ</button>
            </div>        
        `;
        kpiContainer.appendChild(newKpiEntry);
    });

    document.getElementById('kpi-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-kpi')) {
            // event.target.parentElement.remove();
            event.target.closest('.card').remove();

        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/strategy/addKpi.blade.php ENDPATH**/ ?>