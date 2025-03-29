<head>
    <style>
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
    </style>

    <head>

        <?php $__env->startSection('content'); ?>
        <div class="container">
            <div class="header">
                <a href="<?php echo e(route('status.tracking')); ?>" class="back-btn">
                    <i class='bx bxs-left-arrow-square'></i>
                </a>
                <h2>รายละเอียดโครงการ</h2>
            </div>

            <div class="content-box">
                <div class="all-budget">
                    <div class="budget-stats">
                        <div class="budget-stat">
                            <div class="stat-label">สถานะโครงการ</div>
                            <?php
                            $statusText = '';
                            $statusClass = '';

                            if ($project->Count_Steps === 0) {
                            $statusText = 'รอการเสนอ';
                            $statusClass = 'badge-warning';
                            } elseif ($project->Count_Steps === 1) {
                            $statusText = 'รอการพิจารณาจากผู้อำนวยการ';
                            $statusClass = 'badge-info';
                            } elseif ($project->Count_Steps === 2) {
                            if ($project->approvals->first()->Status === 'I') {
                            $statusText = 'รอการเสนอโครงการ';
                            } elseif ($project->approvals->first()->Status === 'Y') {
                            $statusText = 'รอกรอกข้อมูล';
                            }
                            $statusClass = 'badge-orange';
                            } elseif ($project->Count_Steps === 3) {
                            $statusText = 'รอพิจารณางบประมาณ';
                            $statusClass = 'badge-info';
                            } elseif ($project->Count_Steps === 4) {
                            $statusText = 'รอพิจารณาจากหัวหน้าฝ่าย';
                            $statusClass = 'badge-info';
                            } elseif ($project->Count_Steps === 5) {
                            $statusText = 'รอการพิจารณาจากผู้อำนวยการ';
                            $statusClass = 'badge-info';
                            } elseif ($project->Count_Steps === 6) {
                            $statusText = 'อยู่ระหว่างดำเนินการ';
                            $statusClass = 'badge-orange';
                            } elseif ($project->Count_Steps === 7) {
                            $statusText = 'รอพิจารณาจากหัวหน้าฝ่าย';
                            $statusClass = 'badge-info';
                            } elseif ($project->Count_Steps === 8) {
                            $statusText = 'รอการพิจารณาจากผู้อำนวยการ';
                            $statusClass = 'badge-info';
                            } elseif ($project->Count_Steps === 9) {
                            $statusText = 'เสร็จสิ้น';
                            $statusClass = 'badge-success';
                            } elseif ($project->Count_Steps === 10) {
                            $statusText = 'ล่าช้า';
                            $statusClass = 'badge-danger';
                            }

                            if ($project->approvals->isNotEmpty() && $project->approvals->first()->Status === 'N') {
                            $statusText = 'ไม่อนุมัติ';
                            $statusClass = 'badge-danger';
                            }
                            ?>
                            <div class="stat-value"><?php echo e($statusText); ?></div>
                        </div>
                    </div>

                    <?php if($project->Count_Steps >= 10): ?>
                    <div class="special-status">
                        <div class="lightbulb <?php echo e($project->Count_Steps >= 10 ? 'active' : ''); ?>">
                            <i class='bx bx-bulb'></i>
                        </div>
                        <div class="special-text">สถานะพิเศษ: การดำเนินการล่าช้า</div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="content-box-list">
                    <!-- Project Name Form -->
                    <div class="project-name-container">
                        <label for="projectName">ชื่อโครงการ:</label>
                        <input id="projectName" name="Name_Project" value="<?php echo e($project->Name_Project); ?>"
                            class="form-control" readonly>
                    </div>

                    <!-- Steps 1-5 -->
                    <div class="steps-row">
                        <?php for($index = 0; $index < 5; $index++): ?> <?php $statusClass='status-I' ; if ($project->Count_Steps
                            >
                            $index) {
                            $statusClass = 'status-Y';
                            } elseif ($project->Count_Steps == $index) {
                            $statusClass = 'status-B';
                            } else {
                            $statusClass = 'status-P';
                            }
                            ?>
                            <div class="step <?php echo e($statusClass); ?>">
                                <span class="step-number"><?php echo e($index + 1); ?></span>
                                <span class="step-text"><?php echo e($stepTexts[$index]); ?></span>
                                <?php if($index < 4): ?> <div class="step-line <?php echo e($statusClass); ?>">
                            </div>
                            <?php endif; ?>
                    </div>
                    <?php endfor; ?>
                </div>

                <!-- Steps 6-10 -->
                <div class="steps-row">
                    <?php for($index = 5; $index < 10; $index++): ?> <?php $statusClass='status-I' ; if ($project->Count_Steps >
                        $index) {
                        $statusClass = 'status-Y';
                        } elseif ($project->Count_Steps == $index) {
                        $statusClass = 'status-B';
                        } else {
                        $statusClass = 'status-P';
                        }
                        ?>
                        <div class="step <?php echo e($statusClass); ?>">
                            <span class="step-number"><?php echo e($index + 1); ?></span>
                            <span class="step-text"><?php echo e($stepTexts[$index]); ?></span>
                            <?php if($index < 9): ?> <div class="step-line <?php echo e($statusClass); ?>">
                        </div>
                        <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>

            <!-- Special Step 11 as Lightbulb -->
            <div class="special-step-container">
                <div class="special-step <?php echo e($project->Count_Steps >= 10 ? 'status-Y' : 'status-P'); ?>">
                    <div class="lightbulb-large <?php echo e($project->Count_Steps >= 10 ? 'active' : ''); ?>">
                        <i class='bx bx-bulb'></i>
                    </div>
                    <span class="step-text"><?php echo e($stepTexts[10] ?? 'การดำเนินการล่าช้า'); ?></span>
                </div>
            </div>

            <!-- Status Text Section -->
            <div class="status-detail status-<?php echo e($project->approvals->last()->Status_Record ?? 'I'); ?>">
                <?php
                $currentStep = $project->Count_Steps;
                $title = isset($statusMessages[$currentStep]) ? $statusMessages[$currentStep]['title'] : '';
                $detail = isset($statusMessages[$currentStep]) ? $statusMessages[$currentStep]['detail'] : '';
                ?>
                <div class="status-text"><?php echo e($title); ?></div>
                <div class="status-subtext"><?php echo e($detail); ?></div>
            </div>
        </div>

        <style>
        .container {
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .back-button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        h2 {
            margin: 0;
            color: #333;
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

        .special-status {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lightbulb {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s;
        }

        .lightbulb.active {
            background-color: #FFD700;
            color: #333;
            box-shadow: 0 0 15px #FFD700;
        }

        .special-text {
            font-size: 14px;
            font-weight: 500;
        }

        .content-box-list {
            padding: 20px;
        }

        .project-name-container {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 5px;
        }

        /* Step styles */
        .steps-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
            padding: 0 10px;
        }

        .step-number {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f0f0f0;
            color: #666;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
            border: 2px solid #e0e0e0;
        }

        .step-line {
            position: absolute;
            top: 18px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: #e0e0e0;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .step-text {
            font-size: 12px;
            color: #666;
            display: block;
            line-height: 1.3;
        }

        /* Status colors */
        .status-Y .step-number,
        .status-Y .step-line {
            background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
            color: white;
            border-color: #8729DA;
        }

        .status-N .step-number,
        .status-N .step-line {
            background: #f44336;
            color: white;
            border-color: #f44336;
        }

        .status-B .step-number,
        .status-B .step-line {
            background: #2196F3;
            color: white;
            border-color: #2196F3;
        }

        .status-I .step-number,
        .status-I .step-line {
            background: #ff9800;
            color: white;
            border-color: #ff9800;
        }

        .status-P .step-number,
        .status-P .step-line {
            background: #e0e0e0;
            color: #666;
            border-color: #e0e0e0;
        }

        /* Special Step 11 as Lightbulb */
        .special-step-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .special-step {
            text-align: center;
            max-width: 100px;
        }

        .lightbulb-large {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 10px;
            color: #666;
            transition: all 0.3s;
        }

        .lightbulb-large.active {
            background-color: #FFD700;
            color: #333;
            box-shadow: 0 0 20px #FFD700;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(255, 215, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 215, 0, 0);
            }
        }

        /* Status details */
        .status-detail {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #8729DA;
        }

        .status-text {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .status-subtext {
            font-size: 14px;
            color: #666;
        }

        /* History Section */
        .history-section {
            padding: 20px;
            border-top: 1px solid #eee;
        }

        .history-section h4 {
            margin-bottom: 15px;
            color: #333;
        }

        /* Task items */
        .task-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }

        .task-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .task-item.status-Y {
            border-left: 4px solid #4CAF50;
        }

        .task-item.status-N {
            border-left: 4px solid #f44336;
        }

        .task-item.status-I {
            border-left: 4px solid #ff9800;
        }

        .task-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }

        .task-icon.status-Y {
            background: #e8f5e9;
            color: #4CAF50;
        }

        .task-icon.status-N {
            background: #ffebee;
            color: #f44336;
        }

        .task-icon.status-I {
            background: #fff3e0;
            color: #ff9800;
        }

        .task-content {
            flex: 1;
        }

        .task-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .task-subtitle {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .task-comment {
            font-size: 14px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            margin-left: 10px;
        }

        .status-badge.status-Y {
            background: #e8f5e9;
            color: #4CAF50;
        }

        .status-badge.status-N {
            background: #ffebee;
            color: #f44336;
        }

        .status-badge.status-I {
            background: #fff3e0;
            color: #ff9800;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #777;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        /* Button container */
        .button-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            border-top: 1px solid #eee;
        }

        .btn-back {
            padding: 8px 16px;
            background-color: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background-color: #e0e0e0;
        }

        .btn-edit {
            background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-edit:hover {
            opacity: 0.9;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .steps-row {
                flex-direction: column;
                margin-bottom: 40px;
            }

            .step {
                width: 100%;
                margin-bottom: 20px;
            }

            .step-line {
                display: none;
            }

            .all-budget {
                flex-direction: column;
                gap: 15px;
            }

            .task-item {
                flex-direction: column;
                text-align: center;
            }

            .task-icon {
                margin: 0 0 10px 0;
            }

            .status-badge {
                margin-top: 10px;
                margin-left: 0;
            }

            .button-container {
                flex-direction: column;
                gap: 10px;
            }

            .btn-back,
            .btn-edit {
                width: 100%;
            }
        }

        /* Badge Colors */
        .badge-warning {
            background-color: #FFC107;
            color: #212529;
        }

        .badge-info {
            background-color: #17A2B8;
            color: white;
        }

        .badge-orange {
            background-color: #FD7E14;
            color: white;
        }

        .badge-success {
            background-color: #28A745;
            color: white;
        }

        .badge-danger {
            background-color: #DC3545;
            color: white;
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Activate lightbulb animation if at step 11
            if ({
                    {
                        $project - > Count_Steps
                    }
                } >= 10) {
                const lightbulbs = document.querySelectorAll('.lightbulb, .lightbulb-large');
                lightbulbs.forEach(bulb => {
                    bulb.classList.add('active');
                });
            }
        });
        </script>
        <?php $__env->stopSection(); ?>
<?php echo $__env->make('navbar.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/status/statusDetails.blade.php ENDPATH**/ ?>