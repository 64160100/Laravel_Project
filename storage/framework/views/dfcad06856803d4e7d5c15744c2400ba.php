<?php $__env->startSection('content'); ?>

<head>
    <link rel="stylesheet" href="<?php echo e(asset('css/storageFiles.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

</head>

<div class="file-storage-container">
    <!-- Page Header -->
    <div class="header-container">
        <a href="<?php echo e(route('proposeProject')); ?>" class="back-btn1">
            <i class='bx bxs-left-arrow-square'></i>
        </a>
        <h1>ไฟล์จัดเก็บ</h1>
    </div>

    <div class="row">
        <!-- Upload Form -->
        <?php if($employee->IsAdmin === 'Y' || ($employee->IsResponsible === 'Y' && $employee->Id_Employee ===
        $project->Employee_Id)): ?>
        <div class="col-md-4">
            <div class="card upload-card animate__animated animate__fadeIn">
                <div class="card-header">
                    <i class="fas fa-cloud-upload-alt mr-2"></i> อัปโหลดไฟล์ใหม่
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('StorageFiles.store')); ?>" method="POST" enctype="multipart/form-data"
                        id="uploadForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="project_id" value="<?php echo e($project_id); ?>">

                        <div class="mb-4">
                            <label for="project_name_display" class="form-label fw-bold">โครงการ</label>
                            <input type="text" id="project_name_display" class="form-control"
                                value="<?php echo e($project->Name_Project); ?>" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">เลือกไฟล์</label>
                            <div class="file-input-container">
                                <input type="file" name="file" id="fileInput" class="custom-file-input"
                                    accept=".pdf,image/*">
                                <label class="custom-file-label" for="fileInput">เลือกไฟล์...</label>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i> ประเภทไฟล์ที่อนุญาต: PDF, รูปภาพ (JPG, PNG, GIF)
                                <br>
                                <i class="fas fa-exclamation-circle mr-1"></i> ขนาดสูงสุด: 10 MB
                            </small>
                        </div>

                        <div id="fileInfo"></div>

                        <button type="submit" class="btn-upload">
                            <i class="fas fa-upload"></i> อัปโหลดไฟล์
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Files Table -->
        <div
            class="col-md-<?php echo e($employee->IsAdmin === 'Y' || ($employee->IsResponsible === 'Y' && $employee->Id_Employee === $project->Employee_Id) ? '8' : '12'); ?>">
            <div class="card files-card animate__animated animate__fadeIn">
                <div class="card-header">
                    <i class="fas fa-folder-open mr-2"></i> ไฟล์ที่จัดเก็บไว้
                </div>
                <div class="card-body">
                    <?php if(count($files) > 0): ?>
                    <div class="table-responsive">
                        <table class="file-table">
                            <thead>
                                <tr>
                                    <th style="width: 40%">ชื่อไฟล์</th>
                                    <th style="width: 15%">ประเภท</th>
                                    <th style="width: 15%">ขนาด</th>
                                    <th style="width: 30%">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($employee->IsAdmin === 'Y' || ($employee->IsResponsible === 'Y' &&
                                        $employee->Id_Employee === $project->Employee_Id)): ?>
                                        <span class="file-name"
                                            data-id="<?php echo e($file->Id_Storage_File); ?>"><?php echo e($file->Name_Storage_File); ?></span>
                                        <input type="text" class="form-control file-name-input d-none"
                                            data-id="<?php echo e($file->Id_Storage_File); ?>"
                                            value="<?php echo e($file->Name_Storage_File); ?>">
                                        <?php else: ?>
                                        <span><?php echo e($file->Name_Storage_File); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="file-type-badge"><?php echo e($file->Type_Storage_File); ?></span>
                                    </td>
                                    <td>
                                        <span class="file-size-badge"><?php echo e($file->getHumanReadableSize()); ?></span>
                                    </td>
                                    <td>
                                        <div class="file-actions">
                                            <a href="<?php echo e(route('StorageFiles.view', $file->Id_Storage_File)); ?>"
                                                target="_blank" class="btn-action btn-view">
                                                <i class="fas fa-eye"></i> ดู
                                            </a>
                                            <a href="<?php echo e(route('StorageFiles.download', $file->Id_Storage_File)); ?>"
                                                class="btn-action btn-download">
                                                <i class="fas fa-download"></i> ดาวน์โหลด
                                            </a>
                                            <?php if($employee->IsAdmin === 'Y' || ($employee->IsResponsible === 'Y' &&
                                            $employee->Id_Employee === $project->Employee_Id)): ?>
                                            <form action="<?php echo e(route('StorageFiles.destroy', $file->Id_Storage_File)); ?>"
                                                method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn-action btn-delete"
                                                    onclick="return confirm('คุณแน่ใจที่จะลบไฟล์นี้หรือไม่?')">
                                                    <i class="fas fa-trash-alt"></i> ลบ
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <h5>ไม่พบไฟล์</h5>
                        <p>ยังไม่มีไฟล์ที่จัดเก็บไว้ในโครงการนี้</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toast-container" class="toast-container"></div>

<script>
document.querySelectorAll('.file-name').forEach(function(element) {
    element.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        var input = document.querySelector('.file-name-input[data-id="' + id + '"]');
        this.classList.add('d-none');
        input.classList.remove('d-none');
        input.focus();
    });
});

document.querySelectorAll('.file-name-input').forEach(function(element) {
    element.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission
            saveFileName.call(this);
        }
    });
});

let isSaving = false;

function saveFileName() {
    if (isSaving) return; // Prevent multiple submissions

    isSaving = true;
    var id = this.getAttribute('data-id');
    var span = document.querySelector('.file-name[data-id="' + id + '"]');
    var newName = this.value;

    fetch('<?php echo e(route("StorageFiles.updateName")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                id: id,
                name: newName
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                span.textContent = newName;
                showToast('บันทึกชื่อไฟล์เรียบร้อยแล้ว', '#28a745');
            } else {
                showToast('Failed to update file name', '#dc3545');
            }
            this.classList.add('d-none');
            span.classList.remove('d-none');
            isSaving = false;
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to update file name', '#dc3545');
            this.classList.add('d-none');
            span.classList.remove('d-none');
            isSaving = false;
        });
}

function showToast(message, backgroundColor) {
    // Create toast container if it doesn't exist
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    const toast = document.createElement('div');
    toast.className = 'toast-notification show';
    toast.style.backgroundColor = backgroundColor;
    toast.innerHTML = `
        <i class='bx bx-check' style='margin-right:8px; font-size:20px;'></i> 
        ${message}
    `;
    document.getElementById('toast-container').appendChild(toast);

    // Hide the toast after 3 seconds
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}
</script>

<script>
document.getElementById('fileInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var fileInfo = document.getElementById('fileInfo');
    if (file) {
        var fileSize = (file.size / (1024 * 1024)).toFixed(2);
        var fileType = file.type;
        var isValid = (fileType === 'application/pdf' || fileType.startsWith('image/')) && file.size <= 10 *
            1024 * 1024;

        fileInfo.innerHTML = `
            <div class="alert ${isValid ? 'alert-success' : 'alert-danger'}">
                <strong>ไฟล์:</strong> ${file.name}<br>
                <strong>ขนาด:</strong> ${fileSize} MB<br>
                <strong>ประเภท:</strong> ${fileType}
                ${!isValid ? '<br><strong>ข้อผิดพลาด:</strong> ไฟล์ต้องเป็น PDF หรือรูปภาพและไม่เกิน 10 MB.' : ''}
            </div>`;
    } else {
        fileInfo.innerHTML = '';
    }
});

document.getElementById('uploadForm').onsubmit = function(event) {
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];
    if (file) {
        var fileType = file.type;
        var fileSize = file.size / (1024 * 1024);
        if ((fileType !== 'application/pdf' && !fileType.startsWith('image/')) || fileSize > 10) {
            event.preventDefault();
            alert('กรุณาอัปโหลดเฉพาะไฟล์ PDF หรือรูปภาพที่ไม่เกิน 10 MB.');
        }
    }
};
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/StorageFiles/index.blade.php ENDPATH**/ ?>