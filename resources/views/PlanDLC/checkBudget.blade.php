@extends('navbar.app')

<head>
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

    .budget-container {
        padding: 20px;
    }

    .content-box {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .btn-primary.btn-editBudget {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        border: none;
        padding: 10px 16px;
        border-radius: 5px;
        color: white;
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 500;
    }

    .btn-primary.btn-editBudget:hover {
        opacity: 0.9;
        box-shadow: 0 4px 8px rgba(172, 43, 221, 0.3);
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

    .budget-info h3 {
        font-size: 18px;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .budget-amount {
        font-size: 24px;
        font-weight: 600;
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

    .project-table {
        width: 100%;
        border-collapse: collapse;
    }

    .project-table th,
    .project-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .project-table th {
        background-color: #f9f9f9;
        font-weight: 600;
        color: #333;
    }

    .budget-type {
        background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 12px;
        margin-right: 5px;
        display: inline-block;
        margin-bottom: 3px;
    }

    .budget-type-none {
        background-color: #f0f0f0;
        color: #777;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 12px;
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

    .no-results {
        text-align: center;
        padding: 30px;
        color: #777;
    }
    </style>
</head>

@section('content')
<div class="budget-container">
    <div class="header">
        <h1>จัดการงบประมาณ</h1>
    </div>
    <div class="content-box">
        <div class="all-budget">
            <div class="budget-stats">
                <div class="budget-stat">
                    <div class="stat-label">โครงการที่ใช้งบทั้งหมด</div>
                    <div class="stat-value">{{ count($projects) }}</div>
                </div>
            </div>
        </div>

        <div class="content-box-list">
            <h4>รายการโครงการที่ใช้งบประมาณ</h4>
            @if(count($projects) > 0)
            <div class="table-responsive">
                <table class="project-table">
                    <thead>
                        <tr>
                            <th>โครงการ</th>
                            <th>ประเภทงบ</th>
                            <th>งบประมาณที่ใช้</th>
                        </tr>
                    </thead>
                    <tbody id="project-table-body">
                        @foreach($projects as $project)
                        <tr class="project-row">
                            <td>{{ $project->Name_Project }}</td>
                            <td>
                                @if(isset($project->budgetTypes) && count($project->budgetTypes) > 0)
                                @foreach($project->budgetTypes as $type)
                                <span class="budget-type">{{ $type }}</span>
                                @endforeach
                                @else
                                <span class="budget-type-none">ไม่ระบุ</span>
                                @endif
                            </td>
                            <td class="budget-amount">
                                ฿{{ number_format($project->totalBudget ?? 0) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Page info and controls -->
            <div class="page-info">
                <div id="showing-entries">แสดง <span id="showing-start">1</span> ถึง <span
                        id="showing-end">{{ min(10, count($projects)) }}</span>
                    จากทั้งหมด <span id="total-entries">{{ count($projects) }}</span> รายการ</div>

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

            @else
            <div class="no-data">
                <p>ไม่มีโครงการที่ใช้งบประมาณในขณะนี้</p>
            </div>
            @endif
        </div>
    </div>
</div>

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
});
</script>
@endsection