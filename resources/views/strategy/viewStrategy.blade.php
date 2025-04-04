
@extends('navbar.app')
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="{{ asset('css/button.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/viewStrategy.css') }}">
    <title>ข้อมูลแผนยุทธศาสตร์</title>


@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('strategic.index') }}" class="back-btn">
                <i class='bx bxs-left-arrow-square'></i>
            </a>
            <div class="header-bar">
                <h3>{{ $strategic->Name_Strategic_Plan }}</h3>
                <a class='bx bxs-down-arrow ms-3' style='color:#ffffff' data-bs-toggle="collapse" href="#collapseExample"
                role="button" aria-expanded="false" aria-controls="collapseExample"></a>
                <a class='bx bx-table ms-3' style='color:#ffffff; cursor: pointer;' data-bs-toggle="modal"
                data-bs-target="#strategicAnalysisModal" title="แสดงการวิเคราะห์บริบทเชิงกลยุทธ์"></a>
            </div>
            <div>
                <button class='btn-add' data-bs-toggle="modal" data-bs-target="#ModalAddStrategy">เพิ่มข้อมูล</button>
            </div>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="text-box mt-2">
                {{ $strategic->Goals_Strategic  }}
            </div>
        </div>

        <div>
            <table>
                <thead class="table-header">
                    <tr style="text-align: center;">
                        <th>กลยุทธ์</th>
                        <th>วัตถุประสงค์เชิงกลยุทธ์<br>(Strategic Objectives : SO)</th>
                        <th>ตัวชี้วัดกลยุทธ์</th>
                        <th>ค่าเป้าหมาย</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                @foreach ($strategy as $strategy)
                    @php 
                        $rowspan = max(count($strategy->kpis ?? []), 1);  
                    @endphp

                    @if ($strategy->kpis->isNotEmpty())
                        @foreach ($strategy->kpis as $index => $kpi)
                        <tr class="{{ $index == 0 ? 'strategy-start' : 'strategy-row' }}">
                                @if ($index == 0)
                                    <td rowspan="{{ $rowspan }}">{{ $strategy->Name_Strategy }}</td>
                                    <td rowspan="{{ $rowspan }}">
                                        @foreach ($strategy->strategicObjectives as $objective)
                                            {{ $objective->Details_Strategic_Objectives }} <br><br>
                                        @endforeach
                                    </td>
                                @endif
                                <td>{{ $kpi->Name_Kpi }}</td>
                                <td>{{ $kpi->Target_Value }}</td>

                                @if ($index == 0)
                                    <td rowspan="{{ $rowspan }}">
                                        <div class="btn-manage">
                                            <form action="{{ route('strategy.edit', $strategy->Id_Strategy) }}" method="GET">
                                                <button type="submit" class="btn-edit">
                                                    <i class='bx bx-edit'></i>&nbsp;แก้ไข
                                                </button>
                                            </form>

                                            <form action="{{ route('strategy.destroy', $strategy->Id_Strategy) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete " onclick="return confirm('คุณยืนยันที่จะลบข้อมูลนี้หรือไม่');">
                                                    <i class='bx bx-trash'></i>&nbsp;ลบ
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                    <tr class="{{ $strategy->Name_Strategy ? 'strategy-start' : 'strategy-row' }}">
                            <td rowspan="1">{{ $strategy->Name_Strategy }}</td>
                            <td rowspan="1">
                                @foreach ($strategy->strategicObjectives as $objective)
                                    {{ $objective->Details_Strategic_Objectives }} <br><br>
                                @endforeach
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="btn-manage">
                                    <form action="{{ route('strategy.edit', $strategy->Id_Strategy) }}" method="GET">
                                        <button type="submit" class="btn-edit">
                                            <i class='bx bx-edit'></i>&nbsp;แก้ไข
                                        </button>
                                    </form>
                                    <form action="{{ route('strategy.destroy', $strategy->Id_Strategy) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('คุณยืนยันที่จะลบข้อมูลนี้หรือไม่');">
                                            <i class='bx bx-trash'></i> ลบ
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endif
                @endforeach
            </table>

        </div>
    </div>
    @include('strategy.modelStrategy')
    @include('strategy.addStrategy')

@endsection