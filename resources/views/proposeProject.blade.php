@php
use Carbon\Carbon;
Carbon::setLocale('th');
@endphp

@extends('navbar.app')

<head>
    <link rel="stylesheet" href="{{ asset('css/proposeProject.css') }}">
    <style>
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url('{{ storage_path('fonts/THSarabunNew.ttf') }}') format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url('{{ storage_path('fonts/THSarabunNew Bold.ttf') }}') format('truetype');
    }

    .project-status-badge {
        margin-left: 10px;
    }

    .project-status-badge .badge {
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 4px;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-info {
        background-color: #17a2b8;
        color: #fff;
    }

    .badge-primary {
        background-color: #007bff;
        color: #fff;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
    }

    .badge-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .badge-orange {
        background-color: #fd7e14;
        color: #fff;
    }
    </style>
</head>

@section('content')
<div class="container">
    <h1>เสนอโครงการเพื่อพิจารณา</h1>

    @foreach($projects as $project)
    @if($project->Count_Steps !== 0)
    <div class="outer-container">
        <div class="container">
            <div class="header">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="project-title">{{ $project->Name_Project }}</div>
                        <div class="project-subtitle">
                            {{ $project->departmentName ?? 'ยังไม่มีผู้รับผิดชอบโครงการ' }}
                        </div>
                    </div>
                    <div class="project-status-badge">
                        @php
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
                        } elseif ($project->Count_Steps === 11) {
                        $statusText = 'ล่าช้า';
                        $statusClass = 'badge-danger';
                        }

                        if ($project->approvals->isNotEmpty() && $project->approvals->first()->Status === 'N') {
                        $statusText = 'ไม่อนุมัติ';
                        $statusClass = 'badge-danger';
                        }
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                </div>
                <div class="project-info">
                    <div class="info-item">
                        <div class="info-top">
                            <i class='bx bxs-calendar-event' style="width: 20px; height: 0px;"></i>
                            <span class="info-label">วันที่เริ่ม</span>
                        </div>
                        <span class="info-value">{{ $project->formattedFirstTime }}</span>
                    </div>

                    <div class="info-item">
                        <div class="info-top d-flex align-items-center">
                            <i class='bx bx-group' style="width: 20px; height: 0px; margin-right: 10px;"></i>
                            <span class="info-label">ผู้รับผิดชอบ</span>
                        </div>
                        <span class="info-value">
                            @if(session()->get('employee')->IsAdmin !== 'Y')
                            @if($project->employee && ($project->employee->Firstname || $project->employee->Lastname))
                            {{ $project->employee->Firstname ?? '' }} {{ $project->employee->Lastname ?? '' }}
                            @else
                            -
                            @endif
                            @endif

                            @if(session()->get('employee')->IsAdmin === 'Y')
                            <form action="{{ route('projects.updateEmployee', ['id' => $project->Id_Project]) }}"
                                method="POST" id="updateEmployeeForm-{{ $project->Id_Project }}">
                                @csrf
                                <div class="form-group d-flex align-items-center">
                                    <label for="employee_id-{{ $project->Id_Project }}" class="mb-0"></label>
                                    <select name="employee_id" id="employee_id-{{ $project->Id_Project }}"
                                        class="form-control ml-2"
                                        onchange="document.getElementById('updateEmployeeForm-{{ $project->Id_Project }}').submit()">
                                        @if($project->employee && ($project->employee->Firstname ||
                                        $project->employee->Lastname))
                                        <option value="{{ $project->employee_id }}" selected>
                                            {{ $project->employee->Firstname }} {{ $project->employee->Lastname }}
                                        </option>
                                        @else
                                        <option value="" disabled selected>เลือกผู้รับผิดชอบ</option>
                                        @endif
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->Id_Employee }}"
                                            {{ $project->employee_id == $employee->Id_Employee ? 'selected' : '' }}>
                                            {{ $employee->Firstname }} {{ $employee->Lastname }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                            @endif
                        </span>
                    </div>

                    <div class="info-item">
                        <div class="info-top">
                            <i class='bx bx-wallet-alt' style="width: 20px; height: 0px;"></i>
                            <span class="info-label">งบประมาณ</span>
                        </div>
                        <span class="info-value">
                            @if($project->Status_Budget === 'Y')
                            @php
                            $totalBudget = 0;
                            // หากมี projectBudgetSources
                            if ($project->projectBudgetSources) {
                            // วนลูปแต่ละ budget source
                            foreach ($project->projectBudgetSources as $budgetSource) {
                            // ดึงค่าจาก relationship budgetSourceTotal และเพิ่มเข้าไปใน totalBudget
                            if ($budgetSource->budgetSourceTotal) {
                            $totalBudget += $budgetSource->budgetSourceTotal->Amount_Total;
                            }
                            }
                            }
                            @endphp
                            {{ number_format($totalBudget, 2) }} บาท
                            @else
                            ไม่ใช้งบประมาณ
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="project-actions">
                <a href="{{ route('StorageFiles.index', ['project_id' => $project->Id_Project]) }}" class="action-link">
                    <i class='bx bx-info-circle'></i>
                    ดูรายละเอียดโครงการ
                </a>

                <a href="#" class="action-link" data-bs-toggle="modal"
                    data-bs-target="#commentsModal-{{ $project->Id_Project }}">
                    <i class='bx bx-message'></i>
                    ข้อเสนอแนะ({{ $project->approvals->first()->recordHistory->where('Status_Record', 'N')->count() }})
                </a>

                <div class="modal fade" id="commentsModal-{{ $project->Id_Project }}" tabindex="-1"
                    aria-labelledby="commentsModalLabel-{{ $project->Id_Project }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="commentsModalLabel-{{ $project->Id_Project }}">ข้อเสนอแนะ
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @php
                                $filteredRecords = $project->approvals->first()->recordHistory->where('Status_Record',
                                'N');
                                @endphp
                                @if($filteredRecords->count() > 0)
                                <ul>
                                    @foreach($filteredRecords as $record)
                                    <li class="p-2 border-bottom">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span
                                                class="font-weight-bold">{{ $record->Name_Record ?? 'Unknown' }}</span>
                                            <span
                                                class="text-muted small">{{ $record->formattedDateTime ?? 'N/A' }}</span>
                                        </div>
                                        <p class="mb-0">{{ $record->comment ?? 'No Comment' }}</p>
                                    </li>
                                    @endforeach
                                </ul>
                                @else
                                <p class="text-center text-muted">ไม่มีข้อเสนอแนะ</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="action-link" data-bs-toggle="modal"
                    data-bs-target="#viewersModal-{{ $project->Id_Project }}">
                    <i class='bx bxs-book-content'></i>
                    คำสั่ง
                </a>

                @php
                $project->viewers = collect([
                (object) ['Firstname' => 'สมชาย', 'Lastname' => 'ใจดี', 'Position' => 'ผู้อำนวยการ'],
                (object) ['Firstname' => 'สมหญิง', 'Lastname' => 'ใจงาม', 'Position' => 'หัวหน้าฝ่าย'],
                (object) ['Firstname' => 'สมปอง', 'Lastname' => 'ใจเย็น', 'Position' => 'บุคลากรในฝ่าย'],
                (object) ['Firstname' => 'สมศรี', 'Lastname' => 'ใจสบาย', 'Position' => 'บุคลากรในฝ่าย'],
                (object) ['Firstname' => 'สมจิตร', 'Lastname' => 'ใจสงบ', 'Position' => 'บุคลากรในฝ่าย'],
                (object) ['Firstname' => 'สมหมาย', 'Lastname' => 'ใจมั่น', 'Position' => 'บุคลากรในฝ่าย'],
                (object) ['Firstname' => 'สมบัติ', 'Lastname' => 'ใจเพชร', 'Position' => 'บุคลากรในฝ่าย'],
                ]);
                @endphp

                <!-- Modal -->
                <div class="modal fade" id="viewersModal-{{ $project->Id_Project }}" tabindex="-1"
                    aria-labelledby="viewersModalLabel-{{ $project->Id_Project }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewersModalLabel-{{ $project->Id_Project }}">
                                    รายชื่อผู้ที่สามารถมองเห็นโครงการ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ชื่อ</th>
                                            <th>นามสกุล</th>
                                            <th>ตำแหน่ง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($project->viewers as $viewer)
                                        <tr>
                                            <td>{{ $viewer->Firstname }}</td>
                                            <td>{{ $viewer->Lastname }}</td>
                                            <td>{{ $viewer->Position }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="status-section">
                <div class="status-header">
                    สถานะการพิจารณา
                    <i class='bx bxs-chevron-right toggle-icon' id="toggle-icon-{{ $project->Id_Project }}"></i>
                </div>
                <div class="project-status" id="project-status-{{ $project->Id_Project }}">
                    @if($project->approvals->isNotEmpty() && $project->approvals->first()->recordHistory->isNotEmpty())
                    @foreach($project->approvals->first()->recordHistory as $history)
                    <div class="status-card">
                        <div class="status-left">
                            <i class='bx bx-envelope' style="width: 40px;"></i>
                            <div>
                                <div class="status-text">
                                    @if($history->Status_Record === 'N')
                                    ไม่อนุมัติโครงการ
                                    @else
                                    {{ $history->comment ?? 'No Comment' }}
                                    @endif
                                </div>
                                <div class="status-text">
                                    อนุมัติโดย: {{ $history->Name_Record ?? 'Unknown' }}
                                </div>
                                <div class="status-text">
                                    ตำแหน่ง: {{ $history->Permission_Record ?? 'Unknown' }}
                                </div>
                            </div>
                        </div>
                        <div class="status-right">
                            <span class="status-date">
                                {{ $history->formattedDateTime ?? 'N/A' }}
                            </span>
                            @if($history->Status_Record === 'Y')
                            <button class="status-button approval-status approved">
                                เสร็จสิ้น
                            </button>
                            @elseif($history->Status_Record === 'N')
                            <a href="{{ route('approveProject', ['id' => $history->Approve_Id]) }}"
                                class="status-button approval-status not-approved">
                                ไม่อนุมัติ
                            </a>
                            @else
                            <button class="status-button approval-status pending">
                                รอการอนุมัติ
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif

                    @if($project->approvals->first()->Status !== 'N')
                    <div class="status-card">
                        <div class="status-left">
                            <i class='bx bx-envelope' style="width: 40px;"></i>
                            <div>
                                <div class="status-text">
                                    @if($project->Count_Steps === 0)
                                    <div class="status-text">
                                        เริ่มต้นการเสนอโครงการ
                                    </div>
                                    <div class="status-text">
                                        ถึง: ผู้อำนวยการพิจารณาเบื้องต้น
                                    </div>
                                    @elseif($project->Count_Steps === 1)
                                    <div class="status-text">
                                        อยู่ระหว่างการพิจารณาเบื้องต้น
                                    </div>
                                    <div class="status-text">
                                        สถานะ: รอการพิจารณาจากผู้อำนวยการ
                                    </div>
                                    @elseif($project->Count_Steps === 2)
                                    @if($project->approvals->first()->Status === 'Y')
                                    <div class="status-text">
                                        กรอกข้อมูลของโครงการทั้งหมด
                                    </div>
                                    @else
                                    @if($project->Status_Budget === 'N')
                                    <div class="status-text">
                                        การพิจารณาโดยหัวหน้าฝ่าย
                                    </div>
                                    <div class="status-text">
                                        สถานะ: อยู่ระหว่างการพิจารณาโดยหัวหน้าฝ่าย
                                    </div>
                                    @else
                                    <div class="status-text">
                                        การพิจารณาด้านงบประมาณ
                                    </div>
                                    <div class="status-text">
                                        ถึง: ฝ่ายการเงินตรวจสอบงบประมาณ
                                    </div>
                                    @endif
                                    @endif
                                    @elseif($project->Count_Steps === 3)
                                    <div class="status-text">
                                        ตรวจสอบความเหมาะสมด้านงบประมาณ
                                    </div>
                                    <div class="status-text">
                                        สถานะ: อยู่ระหว่างการตรวจสอบโดยฝ่ายการเงิน
                                    </div>
                                    @elseif($project->Count_Steps === 4)
                                    <div class="status-text">
                                        การพิจารณาโดยหัวหน้าฝ่าย
                                    </div>
                                    <div class="status-text">
                                        สถานะ: อยู่ระหว่างการตรวจสอบโดยหัวหน้าฝ่าย
                                    </div>
                                    @elseif($project->Count_Steps === 5)
                                    <div class="status-text">
                                        การพิจารณาโดยผู้อำนวยการ
                                    </div>
                                    <div class="status-text">
                                        สถานะ: อยู่ระหว่างการพิจารณาโดยผู้อำนวยการ
                                    </div>
                                    @elseif($project->Count_Steps === 6)
                                    <div class="status-text">
                                        การดำเนินโครงการ
                                    </div>
                                    @if(\Carbon\Carbon::now()->lte(\Carbon\Carbon::parse($project->End_Time)))
                                    <div class="status-text text-success">
                                        สถานะ: เสร็จทันเวลา
                                    </div>
                                    @else
                                    <div class="status-text text-danger">
                                        สถานะ: เสร็จไม่ทันเวลา
                                    </div>
                                    @endif
                                    @elseif($project->Count_Steps === 7)
                                    <div class="status-text">
                                        การตรวจสอบผลการดำเนินงาน
                                    </div>
                                    <div class="status-text">
                                        สถานะ: รอการตรวจสอบจากหัวหน้าฝ่าย
                                    </div>
                                    @elseif($project->Count_Steps === 8)
                                    <div class="status-text">
                                        การรับรองผลการดำเนินงาน
                                    </div>
                                    <div class="status-text">
                                        สถานะ: รอการรับรองจากผู้อำนวยการ
                                    </div>
                                    @elseif($project->Count_Steps === 9)
                                    <div class="status-text">
                                        ปิดโครงการ
                                    </div>
                                    <div class="status-text">
                                        สถานะ: ดำเนินการเสร็จสิ้นสมบูรณ์
                                    </div>
                                    @elseif($project->Count_Steps === 11)
                                    <div class="status-text">
                                        สถานะพิเศษ: การดำเนินการล่าช้า
                                    </div>
                                    <div class="status-text">
                                        สถานะ: รอการพิจารณาจากผู้อำนวยการ
                                    </div>
                                    @else
                                    <div class="status-text">
                                        {{ $project->approvals->first()->Status ?? 'รอการพิจารณา' }}
                                    </div>
                                    @endif
                                </div>
                                @if($project->Count_Steps === 6 || $project->Count_Steps === 11)
                                <div class="status-text">
                                    วันที่สิ้นสุด: {{ $project->formattedEndTime }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="status-right">
                            <span class="status-date">
                                @if($project->approvals->first()->recordHistory->isNotEmpty())
                                {{ $project->approvals->first()->recordHistory->first()->formattedTimeRecord }}
                                @else
                                N/A
                                @endif
                            </span>
                            <button class="status-button approval-status pending">
                                @if($project->Count_Steps === 0)
                                ส่ง Email
                                @elseif($project->Count_Steps === 1)
                                กำลังพิจารณา
                                @elseif($project->Count_Steps === 2)
                                กำลังพิจารณา
                                @elseif($project->Count_Steps === 3)
                                กำลังพิจารณา
                                @elseif($project->Count_Steps === 4)
                                กำลังพิจารณา
                                @elseif($project->Count_Steps === 5)
                                กำลังพิจารณา
                                @elseif($project->Count_Steps === 6)
                                กำลังพิจารณา
                                @elseif($project->Count_Steps === 7)
                                กำลังพิจารณา
                                @elseif($project->Count_Steps === 8)
                                เสร็จสิ้น
                                @elseif($project->Count_Steps === 9)
                                สิ้นสุดโครงการ
                                @elseif($project->Count_Steps === 11)
                                โครงการเสร็จไม่ทันเวลา
                                @else
                                {{ $project->approvals->first()->Status ?? 'รอการอนุมัติ' }}
                                @endif
                            </button>
                        </div>
                    </div>
                    @endif

                    <div class="button-container">
                        @if(in_array($project->Count_Steps, [0, 2, 3, 4, 5, 6]))
                        @if($project->Count_Steps === 6)
                        @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($project->End_Time)))
                        <form action="{{ route('projects.submitForApproval', ['id' => $project->Id_Project]) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-log-in-circle'></i> ส่งให้ผู้อำนวยการตรวจสอบ
                            </button>
                        </form>
                        @else
                        <a href="{{ route('reportForm', ['id' => $project->Id_Project]) }}" class="btn btn-success">
                            <i class='bx bx-file'></i> ปุ่มรายงานโครงการ
                        </a>
                        @endif
                        @else
                        @if($project->Count_Steps === 2 && $project->approvals->first()->Status === 'Y')
                        <a href="{{ route('projects.edit', ['id' => $project->Id_Project ]) }}" class="btn btn-warning">
                            <i class='bx bx-edit'></i> แก้ไขฟอร์ม
                        </a>
                        @elseif($project->Count_Steps === 3 && $project->approvals->first()->Status === 'N')
                        <a href="{{ route('projects.edit', ['id' => $project->Id_Project ]) }}" class="btn btn-warning">
                            <i class='bx bx-edit'></i> แก้ไขฟอร์ม
                        </a>
                        @elseif($project->Count_Steps === 4 && $project->approvals->first()->Status === 'N')
                        <a href="{{ route('projects.edit', ['id' => $project->Id_Project ]) }}" class="btn btn-warning">
                            <i class='bx bx-edit'></i> แก้ไขฟอร์ม
                        </a>
                        @elseif($project->Count_Steps === 5 && $project->approvals->first()->Status === 'N')
                        <a href="{{ route('projects.edit', ['id' => $project->Id_Project ]) }}" class="btn btn-warning">
                            <i class='bx bx-edit'></i> แก้ไขฟอร์ม
                        </a>
                        @else
                        @if(in_array($project->Count_Steps, [3, 4, 5]) && $project->approvals->first()->Status === 'I')
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class='bx bx-log-in-circle'></i> เสนอเพื่อพิจารณา
                        </button>
                        @else
                        <form action="{{ route('projects.submitForApproval', ['id' => $project->Id_Project]) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-log-in-circle'></i> เสนอเพื่อพิจารณา
                            </button>
                        </form>
                        @endif
                        @endif
                        @endif
                        @elseif($project->Count_Steps === 9)
                        <form action="{{ route('projects.submitForApproval', ['id' => $project->Id_Project]) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary">สิ้นสุดโครงการ</button>
                        </form>
                        @else
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class='bx bx-log-in-circle'></i> เสนอเพื่อพิจารณา
                        </button>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
    @endif
    @endforeach

    @if(session()->get('employee')->IsAdmin === 'Y')
    @foreach ($quartersByFiscalYear as $fiscalYear => $yearQuarters)
    @foreach ($yearQuarters->sortBy('Quarter') as $quarter)
    @php
    $quarterProjects = $filteredStrategics->filter(function($strategic) use ($quarter) {
    return $strategic->quarterProjects->contains('Quarter_Project_Id', $quarter->Id_Quarter_Project);
    });
    $quarterStyle = $quarterStyles[$quarter->Quarter] ?? 'border-gray-200';

    $hasIncompleteStrategies = isset($incompleteStrategiesByYear[$fiscalYear]) &&
    $incompleteStrategiesByYear[$fiscalYear]->isNotEmpty();
    $missingStrategies = [];
    $logDataIncompleteStrategies = [];

    foreach ($logData as $logEntry) {
    if (strpos($logEntry, "Fiscal Year: $fiscalYear, Quarter: $quarter->Quarter") !== false) {
    if (strpos($logEntry, 'Status: No strategies created') !== false || strpos($logEntry, 'Status: No projects created')
    !== false) {
    $logDataIncompleteStrategies[] = preg_replace('/Fiscal Year: \d{4}, Quarter: \d, Status: (No strategies created|No
    projects created)/', '', $logEntry);
    }
    if (strpos($logEntry, 'Missing Strategy:') !== false) {
    preg_match('/Missing Strategy: (.*?),/', $logEntry, $matches);
    if (isset($matches[1])) {
    $missingStrategies[] = $matches[1];
    }
    }
    }
    }

    // Format logDataIncompleteStrategies to display only the required parts
    $logDataIncompleteStrategies = array_map(function($logEntry) {
    preg_match('/Strategy: (.*?), Strategic: (.*?),/', $logEntry, $matches);
    if (isset($matches[1], $matches[2])) {
    return "{$matches[2]}, {$matches[1]}";
    } elseif (preg_match('/Strategic: (.*?),/', $logEntry, $matches)) {
    return "{$matches[1]}, ไม่มีกลยุทธ์";
    } else {
    return $logEntry;
    }
    }, $logDataIncompleteStrategies);

    foreach ($quarterProjects as $Strategic) {
    foreach ($Strategic->projects as $project) {
    $strategyName = $project->Name_Strategy;
    $strategyProjects = $Strategic->projects->filter(function($p) use ($strategyName) {
    return $p->Name_Strategy === $strategyName;
    });

    $allProjectsStatusN = $strategyProjects->every(function($p) {
    return in_array('N', $p->approvalStatuses) || !isset($p->approvalStatuses);
    });

    $hasProjectStatusI = $strategyProjects->contains(function($p) {
    return in_array('I', $p->approvalStatuses);
    });

    if ($allProjectsStatusN && !$hasProjectStatusI) {
    $missingStrategies[] = $strategyName;
    }
    }
    }

    $missingStrategies = array_unique($missingStrategies);
    $allStrategiesComplete = empty($missingStrategies) && empty($logDataIncompleteStrategies);
    @endphp

    @if($quarterProjects->isNotEmpty())
    <div class="card mb-4 border-2 {{ $quarterStyle }}">
        <div class="card-body">
            <h5 class="card-title">เสนอหาผู้อำนวยการ ปีงบประมาณ {{ $fiscalYear }} ไตรมาส {{ $quarter->Quarter }}</h5>

            @if ($hasIncompleteStrategies || !empty($missingStrategies) || !empty($logDataIncompleteStrategies))
            <div class="alert alert-warning">
                <strong>กลยุทธ์ยังไม่ครบสำหรับปีงบประมาณ {{ $fiscalYear }} ไตรมาส {{ $quarter->Quarter }}</strong>
                <ul>
                    @if ($hasIncompleteStrategies)
                    @foreach ($incompleteStrategiesByYear[$fiscalYear] as $strategy)
                    <li>{{ $strategy }}</li>
                    @endforeach
                    @endif
                    @foreach ($missingStrategies as $strategy)
                    <li>{{ $strategy }}: ไม่มีกลยุทธ์</li>
                    @endforeach
                    @foreach ($logDataIncompleteStrategies as $logEntry)
                    <li>{{ $logEntry }}</li>
                    @endforeach
                </ul>
            </div>
            @else
            <div class="alert alert-success">
                <strong>กลยุทธ์ครบแล้วสำหรับปีงบประมาณ {{ $fiscalYear }} ไตรมาส {{ $quarter->Quarter }}</strong>
            </div>
            @endif

            <div class="mb-3">
                @foreach ($quarterProjects as $Strategic)
                @php
                $filteredProjects = $Strategic->projects->filter(function($project) {
                return $project->Count_Steps == 0;
                });
                $filteredProjectCount = $filteredProjects->count();
                $firstStrategicPlanName = $Strategic->Name_Strategic_Plan;

                // Check for missing strategies
                $hasStrategies = !$Strategic->strategies->isEmpty();
                $hasProjects = $filteredProjectCount > 0;

                $totalStrategicBudget = $filteredProjects->sum(function($project) {
                $projectTotal = 0;
                if($project->projectBudgetSources) {
                foreach($project->projectBudgetSources as $budgetSource) {
                $projectTotal += $budgetSource->budgetSourceTotal ?
                $budgetSource->budgetSourceTotal->Amount_Total : 0;
                }
                }
                return $projectTotal;
                });
                $projectsByStrategy = $filteredProjects->groupBy('Name_Strategy');
                @endphp

                <details class="accordion" id="{{ $Strategic->Id_Strategic }}">
                    <summary class="accordion-btn">
                        <b>
                            <a>{{ $firstStrategicPlanName }}</a>
                            @if(!$hasStrategies)
                            <br><span class="badge bg-danger">ยังไม่มีกลยุทธ์</span>
                            @elseif(!$hasProjects)
                            <br><span class="badge bg-warning">มีกลยุทธ์แต่ยังไม่มีโครงการ</span>
                            <br>กลยุทธ์ที่มี:
                            <ul class="strategy-list">
                                @foreach($Strategic->strategies as $strategy)
                                <li>{{ $strategy->Name_Strategy }}</li>
                                @endforeach
                            </ul>
                            @endif
                            <br>จำนวนโครงการ : {{ $filteredProjectCount }} โครงการ
                            <br>งบประมาณรวม: {{ number_format($totalStrategicBudget, 2) }} บาท
                        </b>
                    </summary>
                    @if ($filteredProjectCount > 0)
                    <div class="accordion-content">
                        <table class="summary-table">
                            <thead>
                                <tr>
                                    <th style="width:10%; text-align: center;">ยุทธศาสตร์ สำนักหอสมุด</th>
                                    <th style="width:10%; text-align: center;">กลยุทธ์ สำนักหอสมุด</th>
                                    <th style="width:14%; text-align: center;">โครงการ</th>
                                    <th style="width:14%; text-align: center;">ตัวชี้วัดความสำเร็จ<br>ของโครงการ</th>
                                    <th style="width:12%; text-align: center;">ค่าเป้าหมาย</th>
                                    <th style="width:10%; text-align: center;">งบประมาณ (บาท)</th>
                                    <th style="width:12%; text-align: center;">ผู้รับผิดชอบ</th>
                                    <th style="width:18%; text-align: center;">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projectsByStrategy as $strategyName => $projects)
                                @php
                                $strategyCount = $projects->count();
                                @endphp
                                @foreach ($projects as $index => $Project)
                                @php
                                $isStatusN = in_array('N', $Project->approvalStatuses);
                                $isStatusI = in_array('I', $Project->approvalStatuses);
                                $allProjectsDeleted = $projects->every(function($project) {
                                return in_array('N', $project->approvalStatuses);
                                });
                                @endphp
                                <tr>
                                    @if ($index === 0 && $loop->parent->first)
                                    <td rowspan="{{ $filteredProjectCount }}">{{ $firstStrategicPlanName }}</td>
                                    @endif
                                    @if ($index === 0)
                                    <td class="{{ $allProjectsDeleted ? 'text-gray' : '' }}"
                                        rowspan="{{ $strategyCount }}">
                                        {{ $strategyName ?? '-' }}
                                    </td>
                                    @endif
                                    <td class="{{ $isStatusN && !$isStatusI ? 'text-gray' : '' }}">
                                        <b>{{ $Project->Name_Project }}</b><br>
                                        @foreach($Project->subProjects as $subProject)
                                        - {{ $subProject->Name_Sub_Project }}<br>
                                        @endforeach
                                    </td>
                                    <td class="{{ $isStatusN && !$isStatusI ? 'text-gray' : '' }}">
                                        @if($Project->successIndicators->isNotEmpty())
                                        @foreach($Project->successIndicators as $index => $indicator)
                                        - {!! nl2br(e($indicator->Description_Indicators)) !!}<br>
                                        @endforeach
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="{{ $isStatusN && !$isStatusI ? 'text-gray' : '' }}">
                                        @if($Project->valueTargets->isNotEmpty())
                                        @foreach($Project->valueTargets as $index => $target)
                                        - {!! nl2br(e($target->Value_Target)) !!}<br>
                                        @endforeach
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="{{ $isStatusN && !$isStatusI ? 'text-gray' : '' }}"
                                        style="text-align: center;">
                                        @if($Project->Status_Budget === 'N')
                                        ไม่ใช้งบประมาณ
                                        @else
                                        @php
                                        $totalBudget = 0;
                                        if($Project->projectBudgetSources) {
                                        foreach($Project->projectBudgetSources as $budgetSource) {
                                        $totalBudget += $budgetSource->budgetSourceTotal ?
                                        $budgetSource->budgetSourceTotal->Amount_Total : 0;
                                        }
                                        }
                                        @endphp
                                        {{ number_format($totalBudget, 2) }}
                                        @endif
                                    </td>
                                    <td class="{{ $isStatusN && !$isStatusI ? 'text-gray' : '' }}">
                                        {{ $Project->employee->Firstname ?? '-' }}
                                        {{ $Project->employee->Lastname ?? '' }}
                                    </td>
                                    <td class="{{ $isStatusN && !$isStatusI ? 'text-gray' : '' }}"
                                        style="text-align: center;">
                                        <a href="{{ route('editProject', ['Id_Project' => $Project->Id_Project, 'sourcePage' => 'proposeProject']) }}"
                                            class="btn btn-warning btn-sm">แก้ไข</a>
                                        @if (!$isStatusN || $isStatusI)
                                        <form
                                            action="{{ route('projects.updateStatus', ['id' => $Project->Id_Project]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to update the status of this project?');">ลบ</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                                <tr class="summary-row">
                                    <td colspan="2" style="text-align: left; font-weight: bold;">รวมงบประมาณทั้งหมด:
                                    </td>
                                    <td colspan="6" style="text-align: center; font-weight: bold;">
                                        {{ number_format($totalStrategicBudget, 2) }} บาท
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="accordion-content">
                        <p>ไม่มีโครงการที่เกี่ยวข้อง</p>
                    </div>
                    @endif
                </details>
                @endforeach
            </div>

            <div class="button-container mt-3">
                <form action="{{ route('projects.submitForAllApproval') }}" method="POST">
                    @csrf
                    <input type="hidden" name="quarter" value="{{ $quarter->Quarter }}">
                    <input type="hidden" name="fiscal_year" value="{{ $fiscalYear }}">
                    @foreach ($quarterProjects as $Strategic)
                    @foreach ($Strategic->projects as $project)
                    <input type="hidden" name="project_ids[]" value="{{ $project->Id_Project }}">
                    @endforeach
                    @endforeach
                    <button type="submit" class="btn btn-primary w-full"
                        {{ $allStrategiesComplete && !$hasStatusN ? '' : 'disabled' }}>
                        เสนอโครงการทั้งหมด ไตรมาส {{ $quarter->Quarter }}
                    </button>
                </form>
            </div>

        </div>
    </div>
    @endif
    @endforeach
    @endforeach
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusHeaders = document.querySelectorAll('.status-header');

    statusHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const projectStatus = this.nextElementSibling;
            const toggleIcon = this.querySelector('.toggle-icon');

            if (projectStatus.classList.contains('show')) {
                projectStatus.style.maxHeight = 0;
                projectStatus.classList.remove('show');
                toggleIcon.classList.remove('rotate');
            } else {
                projectStatus.style.maxHeight = projectStatus.scrollHeight + 'px';
                projectStatus.classList.add('show');
                toggleIcon.classList.add('rotate');
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="employee_id-"]').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            const formId = this.id.replace('employee_id-', 'updateEmployeeForm-');
            document.getElementById(formId).submit();
            alert('ชื่อผู้รับผิดชอบมีการแก้ไขแล้ว');
        });

        const formId = selectElement.id.replace('employee_id-', 'updateEmployeeForm-');
        document.getElementById(formId).addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                this.submit();
                alert('ชื่อผู้รับผิดชอบมีการแก้ไขแล้ว');
            }
        });
    });
});
</script>
@endsection