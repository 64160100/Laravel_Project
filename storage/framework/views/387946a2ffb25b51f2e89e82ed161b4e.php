<?php $__env->startSection('content'); ?>
<div class="report-container">
    <div class="header">
        <h1>รายงานผลโครงการ</h1>
    </div>
    
    <div class="content-box">
        <div class="all-budget">
            <div class="budget-stats">
                <div class="budget-stat">
                    <div class="stat-label">โครงการล่าสุด</div>
                    <div class="stat-value"><?php echo e($lastestProject->count()); ?></div>
                </div>
            </div>
            
            <div class="legend">
                <div class="legend-item">
                    <div class="status-dot status-on-track"></div>
                    <span>ดำเนินการตามกำหนด</span>
                </div>
                <div class="legend-item">
                    <div class="status-dot status-warning"></div>
                    <span>ใกล้ถึงกำหนด</span>
                </div>
                <div class="legend-item">
                    <div class="status-dot status-danger"></div>
                    <span>เลยกำหนด</span>
                </div>
            </div>
        </div>

        <div class="content-box-list">
            <h4>รายการโครงการทั้งหมด</h4>
            
            <?php if($lastestProject->count() > 0): ?>
                <div class="projects-list">
                    <?php $__currentLoopData = $lastestProject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="project-row">
                        <div class="project-group">
                            <div class="project-info">
                                <?php
                                    $today = new DateTime();
                                    $endDate = null;
                                    $daysRemaining = null;
                                    $statusClass = "status-not-set";
                                    
                                    if (!empty($project->End_Time)) {
                                        $endDate = new DateTime($project->End_Time);
                                        $interval = $today->diff($endDate);
                                        $daysRemaining = $interval->invert ? -$interval->days : $interval->days;
                                        
                                        if ($interval->invert) {
                                            $statusClass = "status-danger"; // Past due date
                                        } elseif ($daysRemaining <= 7) {
                                            $statusClass = "status-warning"; // Within 7 days of deadline
                                        } else {
                                            $statusClass = "status-on-track"; // More than 7 days until deadline
                                        }
                                    }
                                    
                                    // Calculate progress percentage based on steps
                                    $steps = $project->Count_Steps;
                                    $progressPercent = 0;
                                    if ($steps > 0) {
                                        $progressPercent = min(($steps / 10) * 100, 100);
                                    }
                                ?>
                                
                                <div class="status-icon">
                                    <i class='bx bxs-circle <?php echo e($statusClass); ?>'></i>
                                </div>
                                <div class="project-details">
                                    <div class="project-name"><?php echo e($project->Name_Project); ?></div>
                                    <div class="project-meta">
                                        <span class="position">ผู้รับผิดชอบ: <?php echo e(!empty($project->Firstname) && !empty($project->Lastname) ? $project->Firstname . ' ' . $project->Lastname : 'ยังไม่มีผู้รับผิดชอบ'); ?></span>
                                        <span class="department"><?php echo e($project->Department_Name ?? 'ยังไม่ได้ระบุแผนก'); ?></span>
                                    </div>
                                    <div class="deadline-info">
                                        <?php if(!empty($project->End_Time)): ?>
                                            <?php if($daysRemaining < 0): ?>
                                                <span class="deadline-overdue">เลยกำหนดแล้ว <?php echo e(abs($daysRemaining)); ?> วัน</span>
                                            <?php elseif($daysRemaining == 0): ?>
                                                <span class="deadline-today">ครบกำหนดวันนี้</span>
                                            <?php else: ?>
                                                <span class="deadline-upcoming">เหลือเวลา <?php echo e($daysRemaining); ?> วัน</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="deadline-not-set">ยังไม่ได้ระบุวัน</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="progress-container">
                                <div class="steps-info">
                                    <span>ขั้นตอนที่ <?php echo e($project->Count_Steps > 10 ? 10 : $project->Count_Steps); ?>/10</span>
                                    <span class="progress-percent"><?php echo e(round($progressPercent)); ?>%</span>
                                </div>
                                <div class="energy-bar-container">
                                    <div class="energy-bar" id="energy-bar-<?php echo e($project->Id_Project); ?>" style="width: <?php echo e($progressPercent); ?>%"></div>
                                </div>
                                <?php if($project->Count_Steps == 11): ?>
                                    <div class="overdue-warning">
                                        <i class='bx bxs-error-circle'></i>
                                        <span>โครงการไม่ทันกำหนด</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Page info and controls -->
                <div class="page-info">
                    <div id="showing-entries">แสดง <span id="showing-start">1</span> ถึง <span id="showing-end"><?php echo e(min(5, $lastestProject->count())); ?></span>
                        จากทั้งหมด <span id="total-entries"><?php echo e($lastestProject->count()); ?></span> รายการ</div>

                    <div class="page-size-selector">
                        <label for="page-size">แสดง:</label>
                        <select id="page-size">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <span>รายการต่อหน้า</span>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="pagination" id="pagination-container">
                    <!-- Pagination will be generated by JavaScript -->
                </div>
                
            <?php else: ?>
                <div class="no-data">
                    <p>ไม่มีโครงการในขณะนี้</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
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
    
    .report-container {
        padding: 20px;
    }
    
    .content-box {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .all-budget {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        padding: 20px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .budget-stats {
        display: flex;
        gap: 20px;
    }
    
    .budget-stat {
        text-align: center;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 10px 20px;
        border-radius: 8px;
    }
    
    .stat-label {
        font-size: 14px;
        margin-bottom: 5px;
    }
    
    .stat-value {
        font-size: 20px;
        font-weight: 600;
    }
    
    .legend {
        display: flex;
        gap: 15px;
        font-size: 12px;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    
    .status-dot.status-on-track { background-color: #2ecc71; }
    .status-dot.status-warning { background-color: #f39c12; }
    .status-dot.status-danger { background-color: #e74c3c; }
    
    .content-box-list {
        padding: 20px;
    }
    
    .content-box-list h4 {
        margin-bottom: 15px;
        color: #333;
    }
    
    .projects-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .project-row {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        transition: all 0.2s;
    }
    
    .project-row:hover {
        background-color: #f0f0f0;
        transform: translateY(-2px);
    }
    
    .project-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .project-info {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    
    .status-icon {
        color: #8729DA;
        font-size: 12px;
        padding-top: 4px;
    }
    
    .status-on-track { color: #2ecc71; }
    .status-warning { color: #f39c12; }
    .status-danger { color: #e74c3c; }
    .status-not-set { color: #95a5a6; }
    
    .project-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .project-name {
        font-weight: 600;
        font-size: 16px;
    }
    
    .project-meta {
        font-size: 12px;
        color: #666;
        display: flex;
        gap: 10px;
    }
    
    .deadline-info {
        margin-top: 4px;
        font-size: 12px;
    }
    
    .deadline-overdue {
        color: #e74c3c;
        font-weight: 500;
    }
    
    .deadline-today {
        color: #f39c12;
        font-weight: 500;
    }
    
    .deadline-upcoming {
        color: #2ecc71;
    }
    
    .deadline-not-set {
        color: #95a5a6;
        font-style: italic;
    }
    
    .progress-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 180px;
    }
    
    .steps-info {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #666;
    }
    
    .progress-percent {
        font-weight: 600;
    }
    
    .energy-bar-container {
        width: 180px;
        height: 8px;
        background-color: #e0e0e0;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .energy-bar {
        height: 100%;
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        border-radius: 4px;
    }
    
    .overdue-warning {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 4px;
        color: #e74c3c;
        font-size: 12px;
        font-weight: 500;
    }
    
    /* Page info and pagination */
    .page-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px 0;
        font-size: 14px;
        color: #666;
    }

    .page-size-selector {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .page-size-selector select {
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
    }

    .pagination {
        display: flex;
        gap: 5px;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 4px;
        background-color: white;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pagination-item:hover:not(.disabled):not(.active) {
        background-color: #f5f5f5;
    }

    .pagination-item.active {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        color: white;
        border-color: #8729DA;
    }

    .pagination-item.disabled {
        background-color: #f5f5f5;
        color: #bbb;
        cursor: default;
        pointer-events: none;
    }
    
    .no-data {
        text-align: center;
        padding: 30px;
        color: #777;
    }
    
    @media (max-width: 768px) {
        .all-budget {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .legend {
            margin-top: 10px;
        }
        
        .project-group {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .progress-container {
            width: 100%;
        }
        
        .energy-bar-container {
            width: 100%;
        }
        
        .page-info {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Variables for pagination
    let currentPage = 1;
    let rowsPerPage = 5;
    let allProjects = [];

    $('.project-row').each(function() {
        allProjects.push($(this));
        $(this).hide();
    });

    updatePagination();
    displayProjects();

    // Page size change handler
    $("#page-size").on("change", function() {
        rowsPerPage = parseInt($(this).val());
        currentPage = 1;
        updatePagination();
        displayProjects();
    });

    // Function to display the right projects for the current page
    function displayProjects() {
        // Hide all rows first
        allProjects.forEach(row => row.hide());

        // Calculate start and end indices for current page
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = Math.min(startIndex + rowsPerPage, allProjects.length);

        // Show only the rows for current page
        for (let i = startIndex; i < endIndex; i++) {
            allProjects[i].show();
        }

        // Update showing info
        $("#showing-start").text(allProjects.length > 0 ? startIndex + 1 : 0);
        $("#showing-end").text(endIndex);
        $("#total-entries").text(allProjects.length);
    }

    // Function to update pagination controls
    function updatePagination() {
        const totalPages = Math.ceil(allProjects.length / rowsPerPage);

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
                    displayProjects();
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
                displayProjects();
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
                    displayProjects();
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
                displayProjects();
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
                    displayProjects();
                }
            });
        }
        $("#pagination-container").append(nextBtn);
    }

    // Dynamically update color of progress bars based on completion percentage
    $('.energy-bar').each(function() {
        const width = parseFloat($(this).css('width')) / parseFloat($(this).parent().css('width')) * 100;
        
        if (width < 30) {
            $(this).css('background', 'linear-gradient(180deg, #e74c3c 0%, #c0392b 100%)');
        } else if (width < 70) {
            $(this).css('background', 'linear-gradient(180deg, #f39c12 0%, #d35400 100%)');
        } else {
            $(this).css('background', 'linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%)');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/PlanDLC/report.blade.php ENDPATH**/ ?>