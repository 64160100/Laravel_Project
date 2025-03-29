    <link rel="stylesheet" href="<?php echo e(asset('css/button.css')); ?>">

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>เพิ่มวัตถุประสงค์เชิงกลยุทธ์(Strategic Objectives : SO)</h1>

    <form action="<?php echo e(route('StrategicObjectives.add', $Id_Strategy)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div id="objective-container">
            <div class="card p-3">
                <label>รายละเอียดวัตถุประสงค์เชิงกลยุทธ์</label>
                <div class="objective-entry mb-3">
                    <label for="Details_Strategic_Objectives" class="form-label"></label>
                    <textarea class="form-control" name="Details_Strategic_Objectives[]" placeholder="กรอกรายละเอียดวัตถุประสงค์เชิงกลยุทธ์" required></textarea>
                </div>
            <button type="button" class="btn-add" id="add-objective">เพิ่มวัตถุประสงค์</button>       
            </div>
        </div>
    
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">ถัดไป</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-objective').addEventListener('click', function() {
        const objectiveContainer = document.getElementById('objective-container');
        const newObjectiveEntry = document.createElement('div');
        newObjectiveEntry.classList.add('card', 'p-3', 'mb-3');
        newObjectiveEntry.innerHTML = `
            <div class="objective-entry">
                <label for="Details_Strategic_Objectives" class="form-label">รายละเอียดวัตถุประสงค์เชิงกลยุทธ์</label>
                <textarea class="form-control" name="Details_Strategic_Objectives[]" placeholder="กรอกรายละเอียดวัตถุประสงค์เชิงกลยุทธ์" required></textarea>
                <button type="button" class="btn btn-danger remove-objective mt-3">ลบ</button>
            </div>
        `;
        objectiveContainer.appendChild(newObjectiveEntry);
    });

    document.getElementById('objective-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-objective')) {
            event.target.closest('.card').remove();
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/strategy/addStrategicObjectives.blade.php ENDPATH**/ ?>