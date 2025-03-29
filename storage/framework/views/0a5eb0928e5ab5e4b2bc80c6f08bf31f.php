<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="header">
        <h1>เพิ่มพนักงานใหม่</h1>
    </div>

    <div class="content-box">
        <div class="content-box-list">
            <div class="username-check-section">
                <h4>ตรวจสอบผู้ใช้</h4>
                <p>กรุณากรอก Username เพื่อค้นหาข้อมูลพนักงาน</p>

                <div class="search-form">
                    <div class="input-group">
                        <input type="text" id="username" name="username" class="form-control"
                            placeholder="กรอก Username...">
                        <button type="button" id="checkUsername" class="btn-check">
                            <i class="fas fa-search"></i> ตรวจสอบ
                        </button>
                    </div>
                    <div class="keyboard-shortcuts">
                        <button type="button" class="btn-enter" id="enterKeyButton">
                            <i class="fas fa-keyboard"></i> Enter
                        </button>
                    </div>
                    <div id="username-error" class="error-message"></div>
                </div>

                <div id="loading-indicator" class="loading-indicator" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> กำลังค้นหาข้อมูล...
                </div>
            </div>

            <div id="user-result" class="user-result" style="display: none;">
                <h4>ข้อมูลพนักงาน</h4>
                <div class="user-data-card">
                    <div class="user-info-section">
                        <div class="user-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="user-details">
                            <h3 id="user-fullname">-</h3>
                            <p id="user-position">-</p>
                            <div class="user-status"><span id="user-status-badge" class="status-badge">-</span></div>
                        </div>
                    </div>

                    <form id="employeeForm" action="<?php echo e(route('account.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="prefix_name" id="prefix_name">
                        <input type="hidden" name="agency" id="agency">
                        <input type="hidden" name="status" id="status">

                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstname">ชื่อ</label>
                                    <input type="text" id="firstname" name="firstname" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="lastname">นามสกุล</label>
                                    <input type="text" id="lastname" name="lastname" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">โทรศัพท์</label>
                                    <input type="text" id="phone" name="phone" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email">อีเมล</label>
                                    <input type="email" id="email" name="email" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="position">ตำแหน่ง</label>
                                    <input type="text" id="position" name="position" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="department">ฝ่าย/แผนก</label>
                                    <input type="text" id="department" name="department" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4>บทบาทในระบบ</h4>

                            <div class="roles-grid">
                                <div class="role-checkbox">
                                    <input type="checkbox" id="is_manager" name="is_manager" value="Y">
                                    <label for="is_manager">หัวหน้าฝ่าย</label>
                                </div>
                                <div class="role-checkbox">
                                    <input type="checkbox" id="is_director" name="is_director" value="Y">
                                    <label for="is_director">ผู้บริหาร</label>
                                </div>
                                <div class="role-checkbox">
                                    <input type="checkbox" id="is_finance" name="is_finance" value="Y">
                                    <label for="is_finance">การเงิน</label>
                                </div>
                                <div class="role-checkbox">
                                    <input type="checkbox" id="is_responsible" name="is_responsible" value="Y">
                                    <label for="is_responsible">ผู้รับผิดชอบ</label>
                                </div>
                                <div class="role-checkbox">
                                    <input type="checkbox" id="is_admin" name="is_admin" value="Y">
                                    <label for="is_admin">ผู้ดูแลระบบ</label>
                                </div>
                                <div class="role-checkbox">
                                    <input type="checkbox" id="is_general" name="is_general" value="Y" checked>
                                    <label for="is_general">พนักงานทั่วไป</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="<?php echo e(route('account.index')); ?>" class="btn btn-back">
                                <i class="fas fa-arrow-left"></i> ยกเลิก
                            </a>
                            <button type="submit" class="btn-edit">
                                <i class="fas fa-save"></i> บันทึกข้อมูล
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="user-not-found" class="user-not-found" style="display: none;">
                <div class="not-found-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <h4>ไม่พบข้อมูลผู้ใช้</h4>
                    <p>ไม่พบข้อมูลผู้ใช้ในระบบ กรุณาตรวจสอบ Username ที่กรอกอีกครั้ง</p>
                    <button type="button" id="try-again" class="btn-back">
                        <i class="fas fa-redo"></i> ลองใหม่อีกครั้ง
                    </button>
                </div>
            </div>

            <!-- เพิ่มส่วนนี้หลังจากส่วน user-not-found -->
            <div id="user-exists" class="user-exists" style="display: none;">
                <div class="exists-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h4>พนักงานมีอยู่ในระบบแล้ว</h4>
                    <p>พนักงานที่คุณกำลังค้นหามีอยู่ในระบบแล้ว กรุณาตรวจสอบในรายการพนักงาน</p>
                    <button type="button" class="btn-back try-again-btn">
                        <i class="fas fa-redo"></i> ค้นหาใหม่อีกครั้ง
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.container {
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header h1 {
    color: #333;
    margin: 0;
}

.content-box {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 20px;
}

.content-box-list {
    padding: 20px;
}

.content-box-list h4 {
    margin-bottom: 15px;
    color: #333;
}

.username-check-section {
    margin-bottom: 20px;
}

.search-form {
    margin-top: 20px;
}

.input-group {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.keyboard-shortcuts {
    margin-top: 8px;
    display: flex;
    justify-content: flex-end;
}

.btn-enter {
    background: #f0f0f0;
    border: 1px solid #ddd;
    color: #555;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s;
}

.btn-enter:hover {
    background: #e0e0e0;
}

.btn-enter:active {
    background: #d0d0d0;
}

.form-control {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    flex: 1;
    font-size: 14px;
}

.btn-check {
    background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
    color: white;
    padding: 10px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.btn-check:hover {
    opacity: 0.9;
}

.error-message {
    color: #e74c3c;
    font-size: 13px;
    margin-top: 5px;
}

.loading-indicator {
    margin-top: 15px;
    text-align: center;
    color: #666;
    font-size: 14px;
}

.loading-indicator i {
    margin-right: 8px;
    color: #8729DA;
}

.user-data-card {
    background-color: #f9f9f9;
    border-radius: 8px;
    padding: 20px;
}

.user-info-section {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.user-avatar {
    font-size: 48px;
    color: #8729DA;
}

.user-details h3 {
    margin: 0 0 5px 0;
    font-size: 18px;
}

.user-details p {
    margin: 0 0 8px 0;
    color: #666;
}

.user-status {
    margin-top: 5px;
}

.status-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 12px;
    background-color: #e0e0e0;
    color: #333;
}

.status-badge.active {
    background-color: #4CAF50;
    color: white;
}

.status-badge.inactive {
    background-color: #F44336;
    color: white;
}

.form-section {
    margin-bottom: 25px;
}

.form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

.form-group {
    flex: 1;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #666;
}

.roles-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-top: 10px;
}

.role-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
}

.role-checkbox input[type="checkbox"] {
    width: 16px;
    height: 16px;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.btn-back {
    background-color: #f5f5f5;
    color: #333;
    padding: 10px 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.btn-back:hover {
    background-color: #e9e9e9;
}

.btn-edit {
    background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
    color: white;
    padding: 10px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.btn-edit:hover {
    opacity: 0.9;
}

.user-not-found {
    text-align: center;
    padding: 30px;
}

.not-found-message {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.not-found-message i {
    font-size: 48px;
    color: #e74c3c;
}

.not-found-message h4 {
    margin: 0;
    color: #e74c3c;
}

.not-found-message p {
    margin: 0 0 15px 0;
    color: #666;
}

.user-exists {
    text-align: center;
    padding: 30px;
}

.exists-message {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.exists-message i {
    font-size: 48px;
    color: #f39c12; /* สีส้ม/เหลือง สำหรับข้อความเตือน */
}

.exists-message h4 {
    margin: 0;
    color: #f39c12;
}

.exists-message p {
    margin: 0 0 15px 0;
    color: #666;
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 10px;
    }

    .roles-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .form-actions {
        flex-direction: column;
        gap: 10px;
    }

    .btn-back,
    .btn-edit {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .roles-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// ปรับปรุง JavaScript สำหรับการตรวจสอบ Username
$(document).ready(function() {
    // ตรวจสอบด้วยปุ่ม Enter
    $('#username').keypress(function(e) {
        if (e.which === 13) { // 13 คือ keycode ของปุ่ม Enter
            e.preventDefault(); // ป้องกันการ submit form
            $('#checkUsername').click(); // จำลองการคลิกปุ่มตรวจสอบ
        }
    });

    // ปุ่ม Enter
    $('#enterKeyButton').click(function() {
        $('#checkUsername').click();
    });

    // ตรวจสอบ Username
    $('#checkUsername').click(function() {
        const username = $('#username').val().trim();

        // ตรวจสอบว่ากรอก Username หรือไม่
        if (!username) {
            $('#username-error').text('กรุณากรอก Username');
            return;
        }

        $('#username-error').text('');
        $('#loading-indicator').show();
        $('#user-result').hide();
        $('#user-not-found').hide();
        $('#user-exists').hide(); // ซ่อนข้อความแจ้งเตือนกรณีมีข้อมูลอยู่แล้ว

        // ส่งคำขอ AJAX ไปยังเซิร์ฟเวอร์เพื่อตรวจสอบ Username
        $.ajax({
            url: "<?php echo e(route('account.checkUsername')); ?>",
            type: "POST",
            data: {
                username: username,
                _token: "<?php echo e(csrf_token()); ?>"
            },
            dataType: "json",
            success: function(response) {
                $('#loading-indicator').hide();

                if (response.success && response.data) {
                    // แสดงข้อมูลที่ได้รับจาก API
                    displayUserData(response.data);
                    $('#user-result').show();
                } else {
                    // ตรวจสอบว่าเป็นข้อผิดพลาดประเภทมีข้อมูลอยู่แล้วหรือไม่
                    if (response.exists) {
                        // แสดงข้อความแจ้งเตือนกรณีมีข้อมูลอยู่แล้ว
                        $('#user-exists').show();
                    } else {
                        // แสดงข้อความไม่พบข้อมูล
                        $('#user-not-found').show();
                    }
                }
            },
            error: function(xhr, status, error) {
                $('#loading-indicator').hide();
                $('#user-not-found').show();
                console.error("Error:", error);
            }
        });
    });

    // ลองใหม่อีกครั้ง
    $('.try-again-btn').click(function() {
        $('#username').val('');
        $('#username-error').text('');
        $('#user-not-found').hide();
        $('#user-exists').hide();
        $('#username').focus();
    });

    // แสดงข้อมูลผู้ใช้จาก API - เหมือนเดิม
    function displayUserData(userData) {
        console.log("API Data:", userData);

        // ตรวจสอบว่าข้อมูลอยู่ใน userData.data หรือไม่
        const userInfo = userData.data || userData;

        // ดึงข้อมูลตามโครงสร้าง API จริง
        let username = userInfo.Username || '';
        let prefixName = userInfo.Prefix_Name || '';
        let firstname = userInfo.Firstname || '';
        let lastname = userInfo.Lastname || '';
        let email = userInfo.Email || '';
        let phone = userInfo.Phone || '';
        let departmentName = userInfo.Department_Name || '';
        let positionName = userInfo.Position_Name || '';
        let agency = userInfo.Agency || '';
        let status = userInfo.Status || '';
        let typePersons = userInfo.TypePersons || 'People';

        // แสดงชื่อ-นามสกุลในส่วนหัว
        $('#user-fullname').text(`${prefixName}${firstname} ${lastname}`.trim() || '-');
        $('#user-position').text(`${positionName} (${departmentName})` || '-');

        // แสดงสถานะ
        $('#user-status-badge')
            .text(status)
            .removeClass('active inactive')
            .addClass(status.toLowerCase() === 'active' ? 'active' : 'inactive');

        // กรอกข้อมูลในฟอร์ม
        $('#user_id').val(username);
        $('#prefix_name').val(prefixName);
        $('#firstname').val(firstname);
        $('#lastname').val(lastname);
        $('#phone').val(phone);
        $('#email').val(email);
        $('#position').val(positionName);
        $('#department').val(departmentName);
        $('#agency').val(agency);
        $('#status').val(status);
        $('#type_persons').val(typePersons);

        // รีเซ็ตค่า checkbox
        $('input[type="checkbox"]').prop('checked', false);
        $('#is_general').prop('checked', true);

        // ตั้งค่าบทบาทตามแผนก
        if (departmentName.toLowerCase().includes('การเงิน') ||
            departmentName.toLowerCase().includes('บัญชี') ||
            departmentName.toLowerCase().includes('finance')) {
            $('#is_finance').prop('checked', true);
        }

        // ตรวจสอบตำแหน่งบริหาร
        if (userInfo.ManagementPositionName && userInfo.ManagementPositionName.length > 0) {
            $('#is_manager').prop('checked', true);
        }

        if (positionName.toLowerCase().includes('ผู้อำนวยการ') ||
            positionName.toLowerCase().includes('ผอ.') ||
            positionName.toLowerCase().includes('director') ||
            positionName.toLowerCase().includes('รองผู้อำนวยการ')) {
            $('#is_director').prop('checked', true);
        }
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/account/createEmployee.blade.php ENDPATH**/ ?>