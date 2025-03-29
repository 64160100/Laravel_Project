<!DOCTYPE html>
<html>

<head>
    <title>แก้ไขข้อมูลผู้ใช้งาน</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/editUser.css')); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    .header-container {
        display: flex;
        align-items: center;
    }

    .header-container a {
        margin-right: 10px;
    }

    .back-btn {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        border: 1px solid #ccc;
        padding: 10px 20px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: auto;
        max-width: 300px;
        text-decoration: none;
    }

    .back-btn:hover {
        transform: translateX(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .back-btn:active {
        transform: translateX(-2px) scale(0.98);
    }

    .back-btn i {
        color: white;
        font-size: 24px;
    }

    /* Password section styles */
    .password-section {
        margin-top: 30px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .password-section h3 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
        font-size: 18px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .password-form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .password-form-group {
        flex: 1;
        min-width: 250px;
    }

    .password-toggle {
        position: relative;
    }

    .password-toggle i {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
    }

    .update-password-btn {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .update-password-btn:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .update-password-btn i {
        font-size: 18px;
    }

    .password-feedback {
        margin-top: 15px;
        padding: 10px;
        border-radius: 5px;
        display: none;
    }

    .password-feedback.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .password-feedback.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .password-requirements {
        margin-top: 10px;
        font-size: 12px;
        color: #666;
    }

    .form-control.error {
        border-color: #dc3545;
    }
    </style>
</head>

<body>
    <?php $__env->startSection('content'); ?>
    <div class="header-container">
        <a href="<?php echo e(route('account.employee')); ?>" class="back-btn">
            <i class='bx bxs-left-arrow-square'></i>
        </a>
        <h1>แก้ไขข้อมูลผู้ใช้งาน</h1>
    </div>

    <!-- Form for editing employee information -->
    <div class="form-container">
        <div class="form-row">
            <div class="form-group">
                <label for="Id_Employee">รหัสพนักงาน:</label>
                <input type="text" class="form-control" id="Id_Employee" name="Id_Employee"
                    value="<?php echo e($employee->Id_Employee); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="Fullname_Employee">ชื่อ-นามสกุล:</label>
                <input type="text" class="form-control" id="Fullname_Employee" name="Fullname_Employee"
                    value="<?php echo e($employee->Prefix_Name . ' ' . $employee->Firstname . ' ' . $employee->Lastname); ?>"
                    disabled>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="Position_Name">ตำแหน่ง:</label>
                <input type="text" class="form-control" id="Position_Name" name="Position_Name"
                    value="<?php echo e($employee->Position_Name); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="Department_Name">ฝ่าย:</label>
                <input type="text" class="form-control" id="Department_Name" name="Department_Name"
                    value="<?php echo e($employee->Department_Name); ?>" disabled>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="Email">อีเมล:</label>
                <input type="email" class="form-control" id="Email" name="Email" value="<?php echo e($employee->Email); ?>"
                    disabled>
            </div>
            <div class="form-group">
                <label for="Phone">เบอร์โทร:</label>
                <input type="text" class="form-control" id="Phone" name="Phone" value="<?php echo e($employee->Phone); ?>" disabled>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>สิทธิ์การเข้าถึง:</label>

                <?php if(isset($currentUser) && $currentUser->IsAdmin === 'Y'): ?>
                <!-- Admin can edit permissions -->
                <ul style="list-style-type: none; padding-left: 0;">
                    <li>
                        <input type="checkbox" id="IsManager" name="IsManager" value="Y"
                            <?php echo e($employee->IsManager === 'Y' ? 'checked' : ''); ?>

                            onchange="updatePermission('IsManager', this.checked)">
                        <label for="IsManager">หัวหน้าฝ่าย</label>
                    </li>
                    <li>
                        <input type="checkbox" id="IsDirector" name="IsDirector" value="Y"
                            <?php echo e($employee->IsDirector === 'Y' ? 'checked' : ''); ?>

                            onchange="updatePermission('IsDirector', this.checked)">
                        <label for="IsDirector">ผู้อำนวยการ</label>
                    </li>
                    <li>
                        <input type="checkbox" id="IsFinance" name="IsFinance" value="Y"
                            <?php echo e($employee->IsFinance === 'Y' ? 'checked' : ''); ?>

                            onchange="updatePermission('IsFinance', this.checked)">
                        <label for="IsFinance">การเงิน</label>
                    </li>
                    <li>
                        <input type="checkbox" id="IsResponsible" name="IsResponsible" value="Y"
                            <?php echo e($employee->IsResponsible === 'Y' ? 'checked' : ''); ?>

                            onchange="updatePermission('IsResponsible', this.checked)">
                        <label for="IsResponsible">ผู้รับผิดชอบ</label>
                    </li>
                    <li>
                        <input type="checkbox" id="IsAdmin" name="IsAdmin" value="Y"
                            <?php echo e($employee->IsAdmin === 'Y' ? 'checked' : ''); ?>

                            onchange="updatePermission('IsAdmin', this.checked)">
                        <label for="IsAdmin">ผู้ดูแลระบบ</label>
                    </li>
                    <li>
                        <input type="checkbox" id="IsGeneralEmployees" name="IsGeneralEmployees" value="Y"
                            <?php echo e($employee->IsGeneralEmployees === 'Y' ? 'checked' : ''); ?>

                            onchange="updatePermission('IsGeneralEmployees', this.checked)">
                        <label for="IsGeneralEmployees">พนักงานทั่วไป</label>
                    </li>
                </ul>
                <?php else: ?>
                <!-- Non-admin can only view permissions -->
                <ul style="list-style-type: none; padding-left: 0;">
                    <li>
                        <i
                            class="bx <?php echo e($employee->IsManager === 'Y' ? 'bx-check-square text-success' : 'bx-square text-muted'); ?>"></i>
                        <span>หัวหน้าฝ่าย</span>
                    </li>
                    <li>
                        <i
                            class="bx <?php echo e($employee->IsDirector === 'Y' ? 'bx-check-square text-success' : 'bx-square text-muted'); ?>"></i>
                        <span>ผู้อำนวยการ</span>
                    </li>
                    <li>
                        <i
                            class="bx <?php echo e($employee->IsFinance === 'Y' ? 'bx-check-square text-success' : 'bx-square text-muted'); ?>"></i>
                        <span>การเงิน</span>
                    </li>
                    <li>
                        <i
                            class="bx <?php echo e($employee->IsResponsible === 'Y' ? 'bx-check-square text-success' : 'bx-square text-muted'); ?>"></i>
                        <span>ผู้รับผิดชอบ</span>
                    </li>
                    <li>
                        <i
                            class="bx <?php echo e($employee->IsAdmin === 'Y' ? 'bx-check-square text-success' : 'bx-square text-muted'); ?>"></i>
                        <span>ผู้ดูแลระบบ</span>
                    </li>
                    <li>
                        <i
                            class="bx <?php echo e($employee->IsGeneralEmployees === 'Y' ? 'bx-check-square text-success' : 'bx-square text-muted'); ?>"></i>
                        <span>พนักงานทั่วไป</span>
                    </li>
                </ul>
                <?php if($isOwnProfile): ?>
                <div class="alert alert-info mt-2" style="font-size: 0.9em;">
                    <i class='bx bx-info-circle'></i> หากต้องการเปลี่ยนแปลงสิทธิ์การเข้าถึง กรุณาติดต่อผู้ดูแลระบบ
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Password Change Section -->
        <div class="password-section">
            <h3>เปลี่ยนรหัสผ่าน</h3>
            <div class="password-form-row">
                <div class="password-form-group">
                    <label for="current_password">รหัสผ่านปัจจุบัน:</label>
                    <div class="password-toggle">
                        <input type="password" class="form-control" id="current_password" name="current_password">
                        <i class="bx bx-hide" onclick="togglePasswordVisibility('current_password', this)"></i>
                    </div>
                </div>
            </div>

            <div class="password-form-row">
                <div class="password-form-group">
                    <label for="new_password">รหัสผ่านใหม่:</label>
                    <div class="password-toggle">
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        <i class="bx bx-hide" onclick="togglePasswordVisibility('new_password', this)"></i>
                    </div>
                    <div class="password-requirements">
                        รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร และประกอบด้วยตัวอักษรตัวพิมพ์ใหญ่ ตัวพิมพ์เล็ก และตัวเลข
                    </div>
                </div>

                <div class="password-form-group">
                    <label for="confirm_password">ยืนยันรหัสผ่านใหม่:</label>
                    <div class="password-toggle">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        <i class="bx bx-hide" onclick="togglePasswordVisibility('confirm_password', this)"></i>
                    </div>
                </div>
            </div>

            <button type="button" class="update-password-btn" onclick="updatePassword()">
                <i class='bx bx-lock-alt'></i> อัปเดตรหัสผ่าน
            </button>

            <div id="password-feedback" class="password-feedback"></div>
        </div>
    </div>

    <script>
    function updatePermission(field, value) {
        $.ajax({
            url: '<?php echo e(route("account.updateUserPermissions", $employee->Id_Employee)); ?>',
            type: 'PUT',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                field: field,
                value: value
            },
            success: function(response) {
                console.log('Permission updated successfully');
            },
            error: function(xhr) {
                console.log('Error updating permission');
            }
        });
    }

    function togglePasswordVisibility(inputId, icon) {
        const input = document.getElementById(inputId);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
        } else {
            input.type = "password";
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
        }
    }

    function updatePassword() {
        const currentPassword = $('#current_password').val();
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#confirm_password').val();
        const feedback = $('#password-feedback');

        // Reset form states
        $('.form-control').removeClass('error');
        feedback.removeClass('success error').hide();

        // Validate inputs
        if (!currentPassword) {
            $('#current_password').addClass('error');
            feedback.addClass('error').text('กรุณากรอกรหัสผ่านปัจจุบัน').show();
            return;
        }

        if (!newPassword) {
            $('#new_password').addClass('error');
            feedback.addClass('error').text('กรุณากรอกรหัสผ่านใหม่').show();
            return;
        }

        // Validate password strength
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
        if (!passwordRegex.test(newPassword)) {
            $('#new_password').addClass('error');
            feedback.addClass('error').text(
                'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร และประกอบด้วยตัวอักษรตัวพิมพ์ใหญ่ ตัวพิมพ์เล็ก และตัวเลข')
            .show();
            return;
        }

        if (newPassword !== confirmPassword) {
            $('#confirm_password').addClass('error');
            feedback.addClass('error').text('รหัสผ่านใหม่และยืนยันรหัสผ่านไม่ตรงกัน').show();
            return;
        }

        // Submit password change request
        $.ajax({
            url: '<?php echo e(route("account.updatePassword", $employee->Id_Employee)); ?>',
            type: 'PUT',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                current_password: currentPassword,
                new_password: newPassword,
                confirm_password: confirmPassword
            },
            success: function(response) {
                feedback.addClass('success').text('อัปเดตรหัสผ่านเรียบร้อยแล้ว').show();

                // Clear password fields
                $('#current_password').val('');
                $('#new_password').val('');
                $('#confirm_password').val('');
            },
            error: function(xhr) {
                let errorMessage = 'เกิดข้อผิดพลาดในการอัปเดตรหัสผ่าน';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                feedback.addClass('error').text(errorMessage).show();
            }
        });
    }
    </script>
    <?php $__env->stopSection(); ?>
</body>

</html>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/account/editUser.blade.php ENDPATH**/ ?>