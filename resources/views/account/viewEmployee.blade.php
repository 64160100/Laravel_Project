@extends('navbar.app')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Employee ID Card</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #4a148c;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* Horizontal ID Card Styling with Purple Theme */
    .id-card {
        width: 500px;
        height: 300px;
        background: linear-gradient(135deg, #ffffff 0%, #f3e5f5 100%);
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(74, 20, 140, 0.15);
        overflow: hidden;
        position: relative;
        margin: 20px;
        border: 1px solid #ce93d8;
        display: flex;
        flex-direction: row;
    }

    .card-left {
        width: 35%;
        background: linear-gradient(to bottom, #6a1b9a 0%, #9c27b0 50%, #7b1fa2 100%);
        color: white;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
    }

    .company-logo {
        text-align: center;
        margin-bottom: 10px;
    }

    .company-name {
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 5px;
    }

    .card-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-align: center;
        margin-bottom: 15px;
    }

    .photo-container {
        text-align: center;
        margin-bottom: 15px;
    }

    .employee-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #efefef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        overflow: hidden;
    }

    .employee-photo i {
        font-size: 50px;
        color: #adb5bd;
    }

    .barcode {
        text-align: center;
        width: 100%;
        margin-top: auto;
    }

    .employee-id {
        font-family: 'Courier New', monospace;
        font-size: 12px;
        letter-spacing: 1px;
        color: white;
        text-align: center;
        margin-top: 5px;
    }

    .card-right {
        width: 65%;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    .employee-name {
        font-size: 20px;
        font-weight: bold;
        color: #4a148c;
        margin: 0 0 5px;
    }

    .employee-position {
        font-size: 14px;
        color: #7b1fa2;
        margin-bottom: 5px;
    }

    .employee-department {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e1bee7;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-item {
        display: flex;
        padding: 6px 0;
    }

    .info-label {
        flex: 1;
        font-size: 12px;
        color: #7b1fa2;
        font-weight: bold;
    }

    .info-value {
        flex: 2;
        font-size: 13px;
        color: #343a40;
    }

    .citizen-id-section {
        background-color: #f3e5f5;
        border-radius: 6px;
        padding: 8px 12px;
        margin: 10px 0;
        border: 1px dashed #ce93d8;
        display: flex;
        align-items: center;
    }

    .citizen-id-label {
        font-size: 11px;
        color: #7b1fa2;
        font-weight: bold;
        margin-right: 10px;
    }

    .citizen-id-value {
        font-family: 'Courier New', monospace;
        font-size: 14px;
        letter-spacing: 1px;
        font-weight: bold;
        color: #4a148c;
        flex-grow: 1;
        text-align: right;
    }

    .role-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: auto;
        padding-top: 10px;
    }

    .role-tag {
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 12px;
        color: white;
        background-color: #9c27b0;
        display: inline-block;
    }

    .role-tag.manager {
        background-color: #9c27b0;
    }

    .role-tag.director {
        background-color: #6a1b9a;
    }

    .role-tag.finance {
        background-color: #8e24aa;
    }

    .role-tag.responsible {
        background-color: #ab47bc;
    }

    .role-tag.admin {
        background-color: #7b1fa2;
    }

    .card-footer {
        font-size: 10px;
        color: #7b1fa2;
        text-align: center;
        margin-top: 5px;
        font-style: italic;
    }

    .watermark {
        position: absolute;
        bottom: 30px;
        right: 30px;
        opacity: 0.05;
        transform: rotate(-45deg);
        font-size: 120px;
        color: #7b1fa2;
        pointer-events: none;
    }

    .book-icon {
        margin-right: 5px;
        font-size: 16px;
    }

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
    </style>
</head>

<body>
    @section('content')

    <div class="header-container">
        <a href="{{ route('account.employee') }}" class="back-btn">
            <i class='bx bxs-left-arrow-square'></i>
        </a>
        <h1>ข้อมูลพนักงาน</h1>
    </div>
    <div class="container">
        <div class="card-container">
            @if ($employee)
            <div class="id-card">
                <!-- Left Section -->
                <div class="card-left">
                    <div>
                        <div class="company-name">หอสมุดมหาวิทยาลัยบูรพา</div>
                        <div class="card-title">ข้อมูลพนักงาน</div>
                    </div>

                    <div class="photo-container">
                        <div class="employee-photo">
                            <img src="{{ asset('images/profile.png') }}" alt="Employee Photo"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>

                </div>

                <!-- Right Section -->
                <div class="card-right">
                    <div>
                        <h2 class="employee-name">{{ $employee->Firstname }} {{ $employee->Lastname }}</h2>
                        <div class="employee-position">{{ $employee->Position_Name }}</div>
                        <div class="employee-department">{{ $employee->Department_Name }}</div>
                    </div>

                    <ul class="info-list">
                        <li class="info-item">
                            <div class="info-label"><i class="fas fa-envelope book-icon"></i> อีเมล:</div>
                            <div class="info-value">{{ $employee->Email }}</div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fas fa-phone book-icon"></i> โทรศัพท์:</div>
                            <div class="info-value">{{ $employee->Phone }}</div>
                        </li>
                    </ul>

                    <div class="role-tags">
                        @if ($employee->IsManager === 'Y')
                        <span class="role-tag manager">ผู้จัดการ</span>
                        @endif
                        @if ($employee->IsDirector === 'Y')
                        <span class="role-tag director">ผู้อำนวยการ</span>
                        @endif
                        @if ($employee->IsFinance === 'Y')
                        <span class="role-tag finance">การเงิน</span>
                        @endif
                        @if ($employee->IsResponsible === 'Y')
                        <span class="role-tag responsible">ผู้รับผิดชอบ</span>
                        @endif
                        @if ($employee->IsAdmin === 'Y')
                        <span class="role-tag admin">ผู้ดูแลระบบ</span>
                        @endif
                    </div>

                </div>

                <div class="watermark">📚</div>
            </div>
            @else
            <p>ไม่พบข้อมูลพนักงาน</p>
            @endif
        </div>
    </div>
    @endsection
</body>

</html>