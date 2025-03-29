<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ระบบติดตามแผนงาน | Lib Buu</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Fonts and icons -->
    <script>
    WebFont.load({
        google: {
            families: ["Sarabun:100,200,300,400,500,600,700,800,900"]
        },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{asset('kaiadmin/assets/css/fonts.min.css')}}"],
        },
        active: function() {
            sessionStorage.fonts = true;
        },
    });
    </script>

    <style>
    .nav-item .nav-link {
        position: relative;
    }

    .nav-item .nav-link .red-dot {
        position: absolute;
        top: 7px;
        left: 43px;
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%;
    }

    .noitAppove {
        padding: 4px;
        padding-left: 16px;
        margin: 4px;
        width: 293px;
        font-size: 13px
    }

    .noitAppove-detail {
        white-space: normal;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    </style>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('kaiadmin/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('kaiadmin/assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('kaiadmin/assets/css/kaiadmin.min.css')}}" />
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <div class="wrapper sidebar_minimize">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="white">
                    <a href="#" class="logo">
                        <img src="{{asset('images/logo_BUU_LIB.png')}}" alt="navbar brand" class="navbar-brand"
                            height="50" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>

                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>

                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <!-- content in sidebar -->
                    <ul class="nav nav-secondary">
                        @php
                        $employee = session('employee');
                        $projectManagement = false;
                        $approval = false;
                        $systemManagement = false;
                        $renderedItems = [
                        'dashboard' => false,
                        'list_project' => false,
                        'track_status' => false,
                        'documents_project' => false,
                        'report_results' => false,
                        'check_budget' => false,
                        'approval_project' => false,
                        'manage_users' => false,
                        'data_employee' => false,
                        'setup_system' => false,
                        'propose_project' => false,
                        ];
                        @endphp

                        <!-- Check for project management permissions -->
                        @if($employee->IsManager === 'Y' || $employee->IsDirector === 'Y' || $employee->IsFinance ===
                        'Y' || $employee->IsResponsible === 'Y' || $employee->IsAdmin === 'Y' ||
                        $employee->IsGeneralEmployees === 'Y')
                        @php $projectManagement = true; @endphp
                        @endif

                        @if($projectManagement)
                        <li class="nav-section">
                            <h4 class="text-section">การจัดการโครงการ</h4>
                        </li>
                        @endif

                        @if($projectManagement)
                        @if(!$renderedItems['dashboard'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class='bx bxs-grid-alt'></i>
                                <p>แดชบอร์ด</p>
                            </a>
                        </li>
                        @php $renderedItems['dashboard'] = true; @endphp
                        @endif
                        @if(!$renderedItems['list_project'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project') }}">
                                <i class='bx bx-folder bx-flip-horizontal'></i>
                                <p>รายการโครงการ</p>
                            </a>
                        </li>
                        @php $renderedItems['list_project'] = true; @endphp
                        @endif
                        @if(!$renderedItems['track_status'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('status.tracking') }}">
                                <i class='bx bx-time-five bx-flip-horizontal'></i>
                                <p>ติดตามสถานะ</p>
                            </a>
                        </li>
                        @php $renderedItems['track_status'] = true; @endphp
                        @endif
                        @endif

                        <!-- Check for approval permissions -->
                        @if($employee->IsManager === 'Y' || $employee->IsDirector === 'Y' || $employee->IsFinance ===
                        'Y' || $employee->IsResponsible === 'Y' || $employee->IsAdmin === 'Y')
                        @php $approval = true; @endphp
                        @endif

                        @if($approval)
                        <li class="nav-section">
                            <h4 class="text-section">การอนุมัติ</h4>
                        </li>
                        @endif

                        @if($employee->IsManager === 'Y' || $employee->IsDirector === 'Y' || $employee->IsFinance ===
                        'Y' || $employee->IsResponsible === 'Y' || $employee->IsAdmin === 'Y')
                        @if(!$renderedItems['documents_project'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('PlanDLC.allProject') }}">
                                <i class='bx bx-file bx-flip-horizontal'></i>
                                <p>รวบรวมเอกสารโครงการ</p>
                            </a>
                        </li>
                        @php $renderedItems['documents_project'] = true; @endphp
                        @endif

                        @if(!$renderedItems['report_results'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('PlanDLC.report') }}">
                                <i class='bx bx-task'></i>
                                <p>รายงานผล</p>
                            </a>
                        </li>
                        @php $renderedItems['report_results'] = true; @endphp
                        @endif
                        @endif

                        @if($employee->IsFinance === 'Y' || $employee->IsAdmin === 'Y')
                        @if(!$renderedItems['check_budget'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('PlanDLC.checkBudget') }}">
                                <i class='bx bxs-calculator bx-flip-horizontal'></i>
                                <p>ตรวจสอบงบประมาณ</p>
                            </a>
                        </li>
                        @php $renderedItems['check_budget'] = true; @endphp
                        @endif
                        @endif

                        @if($employee->IsManager === 'Y' || $employee->IsDirector === 'Y' || $employee->IsFinance ===
                        'Y')
                        @if(!$renderedItems['approval_project'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('requestApproval') }}">
                                <i class='bx bx-select-multiple'></i>
                                @if(session('pendingApprovalsCount') > 0)
                                <div class="red-dot"></div>
                                @endif
                                <p>อนุมัติโครงการ</p>
                            </a>
                        </li>
                        @php $renderedItems['approval_project'] = true; @endphp
                        @endif
                        @endif

                        @if($employee->IsAdmin === 'Y' || $employee->IsManager === 'Y' || $employee->IsResponsible ===
                        'Y')
                        @if(!$renderedItems['propose_project'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('proposeProject') }}">
                                <i class='bx bx-food-menu'></i>
                                @if(session('statusNCount') > 0)
                                <div class="red-dot"></div>
                                @endif
                                <p>เสนอโครงการเพื่อพิจารณา</p>
                            </a>
                        </li>
                        @php $renderedItems['propose_project'] = true; @endphp
                        @endif
                        @endif

                        <!-- Check for system management permissions -->
                        @if($employee->IsAdmin === 'Y')
                        @php $systemManagement = true; @endphp
                        @endif

                        @if($systemManagement)
                        <li class="nav-section">
                            <h4 class="text-section">การจัดการระบบ</h4>
                        </li>
                        @endif

                        @if($employee->IsAdmin === 'Y')
                        @if(!$renderedItems['data_employee'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('account.employee') }}">
                                <i class='bx bx-group'></i>
                                <p>ข้อมูลพนักงาน</p>
                            </a>
                        </li>
                        @php $renderedItems['data_employee'] = true; @endphp
                        @endif
                        @if(!$renderedItems['setup_system'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('setting') }}">
                                <i class='bx bx-cog'></i>
                                <p>ตั้งค่าระบบ</p>
                            </a>
                        </li>
                        @php $renderedItems['setup_system'] = true; @endphp
                        @endif
                        @endif
                    </ul>
                </div>
            </div>

        </div>
        <!-- End Sidebar -->

        <!-- Navbar -->
        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="white">
                        <a href="#" class="logo">
                            <img src="{{asset('images/logo_BUU_LIB.png')}}" alt="navbar brand" class="navbar-brand"
                                height="50" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>

                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                    aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>

                            <!-- แจ้งเตือน -->
                            @if(session('employee'))
                            @if(session('employee')->IsAdmin === 'Y')
                            <!-- แจ้งสถานะ(จดหมาย)แอดมิน -->
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bx-envelope'></i>
                                </a>
                                <ul class="dropdown-menu animated fadeIn"
                                    style="max-height: 500px; width: 300px; overflow-y: auto; overflow-x: hidden;">
                                    @php
                                    \Carbon\Carbon::setLocale('th');
                                    $groupedHistories = collect(session('recordHistories', []))
                                    ->groupBy(function($history) {
                                    return \Carbon\Carbon::parse($history->Time_Record)->format('Y-m-d');
                                    }) ->sortKeysDesc();
                                    @endphp
                                    @if(count($groupedHistories) > 0)
                                    @foreach($groupedHistories as $date => $histories)
                                    <li class="noitAppove" style="font-weight: bold; background-color:#e6faff;">
                                        {{ \Carbon\Carbon::parse($date)->addYears(543)->translatedFormat('d F พ.ศ. Y') }}
                                    </li>
                                    @foreach($histories as $history)
                                    <!-- <li class="noitAppove noitAppove-detail"> -->
                                    <li class="noitAppove noitAppove-detail"
                                        style="{{ $history->Status_Record === 'N' && $history->approvals->Status === 'N' ? 'background-color:ffc4c4;' : '' }}">
                                        <b
                                            style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $history->approvals->project->Name_Project }}
                                        </b>
                                        {{ $history->comment }} <br>(โดย:{{ $history->Permission_Record }})
                                    </li>
                                    @endforeach
                                    @endforeach
                                    @else
                                    <li style="text-align: center;">
                                        ไม่มีข้อมูล
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            <!-- แจ้งสถานะทั่วไป -->
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                @if(session('pendingApprovalsCountForEmployee', 0) > 0)
                                <a class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bx-envelope'></i>
                                </a>
                                <ul class="dropdown-menu animated fadeIn"
                                    style="max-height: 500px; width: 300px; overflow-y: auto; overflow-x: hidden;">
                                    @php
                                    \Carbon\Carbon::setLocale('th');
                                    $groupedHistories = collect(session('recordHistories', []))
                                    ->groupBy(function($history) {
                                    return \Carbon\Carbon::parse($history->Time_Record)->format('Y-m-d');
                                    }) ->sortKeysDesc();
                                    @endphp
                                    @if(count($groupedHistories) > 0)
                                    @foreach($groupedHistories as $date => $histories)
                                    <li class="noitAppove" style="font-weight: bold; background-color:#e6faff;">
                                        {{ \Carbon\Carbon::parse($date)->addYears(543)->translatedFormat('d F พ.ศ. Y') }}
                                    </li>
                                    @foreach($histories as $history)
                                    <li class="noitAppove noitAppove-detail">
                                        <b
                                            style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $history->approvals->project->Name_Project }}
                                        </b>
                                        {{ $history->comment }} <br>(โดย:{{ $history->Permission_Record }})
                                    </li>
                                    @endforeach
                                    @endforeach
                                    @else
                                    <li style="text-align: center;">
                                        ไม่มีข้อมูล
                                    </li>
                                    @endif
                                </ul>
                                @else
                                @if(session('pendingApprovalsCount', 0) > 0 )
                                <a class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell-ring me-1' style='color:#ff0000'></i>
                                    <span style='color:#ff0000'>{{ session('pendingApprovalsCount') }}</span>
                                </a>
                                <ul class="dropdown-menu animated fadeIn">
                                    <li class="dropdown-item" style="white-space: normal; width: 300px;">
                                        <a href="{{ route('requestApproval') }}" style="color:#000;">
                                            รายการโครงการรอการอนุมัติ ({{ session('pendingApprovalsCount') }})
                                        </a>
                                    </li>
                                </ul>
                                @else
                                <a class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-bell-ring me-1'></i>
                                    <span>{{ session('pendingApprovalsCount', 0) }}</span>
                                </a>
                                @endif
                                @endif
                            </li>
                            @endif

                            <!-- โปรไฟล์ -->
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="profile-container"
                                        style="background: linear-gradient(180deg, #8729DA 0%, #AC2BDD 100%); border: 1px solid #ccc; padding: 10px 20px; border-radius: 5px; display: flex; align-items: center; color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); width: auto; max-width: 300px; margin-left: auto; margin-right: -20px;">
                                        <div class="avatar-sm" style="margin-right: 10px;">
                                            <img src="{{ asset('images/profile.png') }}" alt="..."
                                                class="avatar-img rounded-circle" />
                                        </div>
                                        <span class="profile-username"
                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <span class="fw-bold">
                                                @if(session('employee'))
                                                {{ session('employee')->Prefix_Name }}
                                                {{ session('employee')->Firstname }}
                                                {{ session('employee')->Lastname }}<br>
                                                <small>{{ session('employee')->Position_Name }}</small>
                                                @else
                                                Guest
                                                @endif
                                            </span>
                                        </span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item"
                                                href="{{ route('account.showemployee', ['Id_Employee' => session('employee')->Id_Employee]) }}">
                                                โปรไฟล์</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item"
                                                href="{{ route('account.editUser', ['Id_Employee' => session('employee')->Id_Employee]) }}">
                                                ตั้งค่าโปรไฟล์
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                            <a class="dropdown-item" href="#"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ออกจากระบบ</a>
                                        </li>
                                    </div>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <!-- Main Content -->
            <div class="main p-3">
                <main class="py-4 pt-5 mt-5">
                    @yield('content')
                </main>
            </div>

        </div>
        <!-- End Navbar -->

    </div>

    <!--   Core JS Files   -->
    <script src="{{asset('kaiadmin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('kaiadmin/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('kaiadmin/assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('kaiadmin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{asset('kaiadmin/assets/js/kaiadmin.min.js')}}"></script>
</body>

</html>