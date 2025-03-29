<?php $__env->startSection('content'); ?>
<div class="document-container">
    <div class="header">
        <h1>จัดการเอกสารโครงการ</h1>
    </div>

    <div class="content-box">
        <div class="all-budget">
            <div class="budget-stats">
                <div class="budget-stat">
                    <div class="stat-label">โครงการทั้งหมด</div>
                    <div class="stat-value"><?php echo e($allProject->total()); ?></div>
                </div>
            </div>
        </div>

        <div class="search-filter-section">
            <div class="search-box">
                <i class='bx bx-search search-icon'></i>
                <input type="text" id="projectSearch" placeholder="ค้นหาโครงการ...">
            </div>
            <div class="filter-box">
                <label for="sortOption">เรียงตาม:</label>
                <select id="sortOption">
                    <option value="name">ชื่อโครงการ</option>
                    <option value="newest">ล่าสุด</option>
                    <option value="docs">จำนวนเอกสาร</option>
                </select>
            </div>
        </div>

        <div class="content-box-list">
            <h4>รายการโครงการทั้งหมด</h4>
            <?php $__currentLoopData = $allProject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="project-card">
                <div class="project-header">
                    <h3 class="project-title"><?php echo e($project->Name_Project); ?></h3>
                    <div class="doc-count">
                        <i class='bx bx-file'></i>
                        <span><?php echo e($project->document_count); ?> เอกสาร</span>
                    </div>
                </div>

                <div class="project-details">
                    <div class="detail-item">
                        <i class='bx bx-user'></i>
                        <span>ผู้รับผิดชอบ:
                            <?php echo e($project->employee ? 
                               $project->employee->Firstname . ' ' . $project->employee->Lastname : 
                               'ยังไม่มีผู้รับผิดชอบ'); ?>

                        </span>
                    </div>
                </div>

                <div class="project-actions">
                    <a href="<?php echo e(route('StorageFiles.index', $project->Id_Project)); ?>" class="btn-edit">
                        <i class='bx bx-file'></i>
                        <span>ดูเอกสาร</span>
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(count($allProject) == 0): ?>
            <div class="no-data">
                <i class='bx bx-search-alt' style="font-size: 48px; color: #ccc;"></i>
                <p>ไม่พบข้อมูลโครงการที่ค้นหา</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Page info and pagination -->
        <div class="page-info">
            <div id="showing-entries">
                แสดง <span id="showing-start"><?php echo e($allProject->firstItem() ?? 0); ?></span>
                ถึง <span id="showing-end"><?php echo e($allProject->lastItem() ?? 0); ?></span>
                จากทั้งหมด <span id="total-entries"><?php echo e($allProject->total()); ?></span> รายการ
            </div>

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

    .document-container {
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

    .content-box-list {
        padding: 20px;
    }

    .content-box-list h4 {
        margin-bottom: 15px;
        color: #333;
    }

    /* Search and filter section */
    .search-filter-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 300px;
    }

    .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    #projectSearch {
        padding: 8px 8px 8px 35px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 100%;
        font-size: 14px;
    }

    #projectSearch:focus {
        outline: none;
        border-color: #8729DA;
    }

    .filter-box {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-box select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: white;
    }

    /* Project card styling */
    .project-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }

    .project-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .project-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .project-title {
        font-size: 16px;
        color: #333;
        margin: 0;
    }

    .doc-count {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
        color: #666;
    }

    .project-details {
        margin-bottom: 15px;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #666;
        font-size: 14px;
    }

    .project-actions {
        display: flex;
        justify-content: flex-end;
    }

    .btn-edit {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
    }

    .btn-edit:hover {
        opacity: 0.9;
        color: white;
        text-decoration: none;
    }

    .no-data {
        text-align: center;
        padding: 30px;
        color: #777;
    }

    /* Page info and pagination */
    .page-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px;
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
        margin: 20px 0;
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
        text-decoration: none;
        color: #333;
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

    /* Responsive styles */
    @media (max-width: 768px) {
        .search-filter-section {
            flex-direction: column;
            gap: 10px;
        }
        
        .search-box {
            max-width: 100%;
        }
        
        .budget-stats {
            flex-wrap: wrap;
        }
        
        .project-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
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
    // Search functionality
    $("#projectSearch").on("keyup", function() {
        const searchValue = $(this).val().toLowerCase();
        $(".project-card").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1)
        });
        
        // Show/hide no results message
        if ($(".project-card:visible").length === 0) {
            if ($(".no-data").length === 0) {
                $(".content-box-list").append('<div class="no-data"><i class="bx bx-search-alt" style="font-size: 48px; color: #ccc;"></i><p>ไม่พบข้อมูลโครงการที่ค้นหา</p></div>');
            }
        } else {
            $(".no-data").remove();
        }
    });

    // Sorting functionality
    $("#sortOption").on("change", function() {
        const sortOption = $(this).val();
        const projectCardList = $(".project-card").get();
        
        projectCardList.sort(function(a, b) {
            if (sortOption === 'name') {
                const titleA = $(a).find(".project-title").text().toLowerCase();
                const titleB = $(b).find(".project-title").text().toLowerCase();
                return titleA.localeCompare(titleB);
            } else if (sortOption === 'docs') {
                const docsA = parseInt($(a).find(".doc-count span").text());
                const docsB = parseInt($(b).find(".doc-count span").text());
                return docsB - docsA;
            }
            // Default or 'newest' just uses the original order
            return 0;
        });
        
        // Append sorted items
        $.each(projectCardList, function(index, item) {
            $(".content-box-list").append(item);
        });
    });

    // Page size change handler
    $("#page-size").on("change", function() {
        const pageSize = $(this).val();
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('per_page', pageSize);
        window.location.href = currentUrl.toString();
    });

    // Set selected option based on current per_page parameter
    const urlParams = new URLSearchParams(window.location.search);
    const currentPerPage = urlParams.get('per_page') || '5';
    $("#page-size").val(currentPerPage);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/PlanDLC/allProject.blade.php ENDPATH**/ ?>