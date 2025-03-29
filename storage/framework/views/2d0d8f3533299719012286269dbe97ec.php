<!DOCTYPE html>
<html>

<head>
    <title>รายการพนักงานหอสมุด</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/employee.css')); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
    <?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>ข้อมูลพนักงานหอสมุด</h1>

        <div class="action-bar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="ค้นหาพนักงาน..." id="employee-search">
            </div>

            <a href="<?php echo e(route('account.create')); ?>" class="add-button">
                <i class="fas fa-user-plus"></i> เพิ่มพนักงาน
            </a>
        </div>

        <table class="table table-striped">
            <thead class="table-header">
                <tr>
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>ตำแหน่ง</th>
                    <th>ฝ่าย</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody class="table-body" id="employee-table-body">
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="employee-row">
                    <td class="employee-id"><?php echo e($employee->Id_Employee); ?></td>
                    <td class="employee-name"><?php echo e($employee->Firstname); ?></td>
                    <td class="employee-name"><?php echo e($employee->Lastname); ?></td>
                    <td>
                        <div class="position-info">
                            <span class="position-title"><?php echo e($employee->Position_Name); ?></span>
                            <div>
                                <?php if($employee->IsManager === 'Y'): ?>
                                <span class="badge manager">หัวหน้าฝ่าย</span>
                                <?php endif; ?>
                                <?php if($employee->IsDirector === 'Y'): ?>
                                <span class="badge director">ผู้บริหาร</span>
                                <?php endif; ?>
                                <?php if($employee->IsFinance === 'Y'): ?>
                                <span class="badge finance">การเงิน</span>
                                <?php endif; ?>
                                <?php if($employee->IsResponsible === 'Y'): ?>
                                <span class="badge responsible">ผู้รับผิดชอบ</span>
                                <?php endif; ?>
                                <?php if($employee->IsAdmin === 'Y'): ?>
                                <span class="badge admin">ผู้ดูแลระบบ</span>
                                <?php endif; ?>
                                <?php if($employee->IsGeneralEmployees === 'Y'): ?>
                                <span class="badge general-employees">พนักงานทั่วไป</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="department"><?php echo e($employee->Department_Name); ?></td>
                    <td>
                        <div class="actions">
                            <a href="<?php echo e(route('account.showemployee', $employee->Id_Employee)); ?>"
                                class="btn btn-primary">
                                <i class="fas fa-eye"></i> รายละเอียด
                            </a>
                            <form action="<?php echo e(route('account.editUser', $employee->Id_Employee)); ?>" method="GET"
                                style="display:inline;">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> แก้ไข
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <!-- Page info and controls -->
        <div class="page-info">
            <div id="showing-entries">แสดง <span id="showing-start">1</span> ถึง <span id="showing-end">10</span>
                จากทั้งหมด <span id="total-entries"><?php echo e(count($employees)); ?></span> รายการ</div>

            <div class="page-size-selector">
                <label for="page-size">แสดง:</label>
                <select id="page-size">
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>รายการต่อหน้า</span>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination" id="pagination-container">
            <!-- Pagination will be generated by JavaScript -->
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Variables for pagination
        let currentPage = 1;
        let rowsPerPage = 10;
        let filteredEmployees = [];
        let allEmployees = [];

        $('.employee-row').each(function() {
            allEmployees.push($(this));
            $(this).hide();
        });

        filteredEmployees = [...allEmployees];

        updatePagination();
        displayEmployees();

        $("#employee-search").on("keyup", function() {
            let searchValue = $(this).val().toLowerCase();

            filteredEmployees = allEmployees.filter(function(employeeRow) {
                return employeeRow.text().toLowerCase().indexOf(searchValue) > -1;
            });

            currentPage = 1;
            updatePagination();
            displayEmployees();
        });

        // Page size change handler
        $("#page-size").on("change", function() {
            rowsPerPage = parseInt($(this).val());
            currentPage = 1;
            updatePagination();
            displayEmployees();
        });

        // Function to display the right employees for the current page
        function displayEmployees() {
            // Hide all rows first
            allEmployees.forEach(row => row.hide());

            if (filteredEmployees.length === 0) {
                // No matching results
                if ($("#no-results-row").length === 0) {
                    $("#employee-table-body").append(
                        '<tr id="no-results-row"><td colspan="6" class="no-results">ไม่พบข้อมูลที่ตรงกับการค้นหา</td></tr>'
                    );
                }

                // Update showing info
                $("#showing-start").text("0");
                $("#showing-end").text("0");
                $("#total-entries").text("0");

                return;
            }

            // Remove no results message if exists
            $("#no-results-row").remove();

            // Calculate start and end indices for current page
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, filteredEmployees.length);

            // Show only the rows for current page
            for (let i = startIndex; i < endIndex; i++) {
                filteredEmployees[i].show();
            }

            // Update showing info
            $("#showing-start").text(filteredEmployees.length > 0 ? startIndex + 1 : 0);
            $("#showing-end").text(endIndex);
            $("#total-entries").text(filteredEmployees.length);
        }

        // Function to update pagination controls
        function updatePagination() {
            const totalPages = Math.ceil(filteredEmployees.length / rowsPerPage);

            // Clear existing pagination
            $("#pagination-container").empty();

            // Don't show pagination if no pages or only one page
            if (totalPages <= 1) {
                return;
            }

            // Previous button
            const prevBtn = $('<div class="pagination-item' + (currentPage === 1 ? ' disabled' : '') +
                '"><i class="fas fa-chevron-left"></i></div>');
            if (currentPage > 1) {
                prevBtn.on('click', function() {
                    if (currentPage > 1) {
                        currentPage--;
                        updatePagination();
                        displayEmployees();
                    }
                });
            }
            $("#pagination-container").append(prevBtn);

            // Page numbers
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);

            // Adjust if we're near the end
            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }

            // First page
            if (startPage > 1) {
                const firstPageBtn = $('<div class="pagination-item">1</div>');
                firstPageBtn.on('click', function() {
                    currentPage = 1;
                    updatePagination();
                    displayEmployees();
                });
                $("#pagination-container").append(firstPageBtn);

                if (startPage > 2) {
                    $("#pagination-container").append('<div class="pagination-item">...</div>');
                }
            }

            // Page numbers
            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = $('<div class="pagination-item' + (i === currentPage ? ' active' : '') + '">' +
                    i + '</div>');
                if (i !== currentPage) {
                    pageBtn.on('click', function() {
                        currentPage = i;
                        updatePagination();
                        displayEmployees();
                    });
                }
                $("#pagination-container").append(pageBtn);
            }

            // Last page
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    $("#pagination-container").append('<div class="pagination-item">...</div>');
                }

                const lastPageBtn = $('<div class="pagination-item">' + totalPages + '</div>');
                lastPageBtn.on('click', function() {
                    currentPage = totalPages;
                    updatePagination();
                    displayEmployees();
                });
                $("#pagination-container").append(lastPageBtn);
            }

            // Next button
            const nextBtn = $('<div class="pagination-item' + (currentPage === totalPages ? ' disabled' : '') +
                '"><i class="fas fa-chevron-right"></i></div>');
            if (currentPage < totalPages) {
                nextBtn.on('click', function() {
                    if (currentPage < totalPages) {
                        currentPage++;
                        updatePagination();
                        displayEmployees();
                    }
                });
            }
            $("#pagination-container").append(nextBtn);
        }
    });
    </script>
    <?php $__env->stopSection(); ?>
</body>

</html>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/account/employee.blade.php ENDPATH**/ ?>