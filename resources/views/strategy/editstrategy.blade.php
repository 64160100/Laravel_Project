@extends('navbar.app')
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">

@section('content')
<div class="container">
    <div class="d-flex justify-content-start align-items-center">
        <a href="{{ route('strategy.index',  $strategy->Strategic_Id) }}" class="back-btn">
            <i class='bx bxs-left-arrow-square'></i>
        </a>
        <h1 class="ms-3">แก้ไขกลยุทธ์และตัวชี้วัด</h1>
    </div>
    <form action="{{ route('strategy.update', $strategy->Id_Strategy) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card p-3 mt-3">
            <div class="form-group">
                <label for="Name_Strategy">ชื่อกลยุทธ์</label>
                <div class="input-group">
                    <input type="text" name="Name_Strategy" id="Name_Strategy" value="{{ $strategy->Name_Strategy }}" class="form-control" required>
                </div>
            </div>
        </div>

        <div id="strategicObjectivesContainer">
            <div class="card p-3">
                <div class="form-group">
                    <label>รายละเอียดวัตถุประสงค์เชิงกลยุทธ์</label>
                    @foreach ($strategy->strategicObjectives as $so)
                            <label for="Details_Strategic_Objectives_{{ $so->Id_Strategic_Objectives }}"></label>
                            <div class="input-group">
                                <input type="text" name="strategicObjectives[{{ $so->Id_Strategic_Objectives }}][Details_Strategic_Objectives]" id="Details_Strategic_Objectives_{{ $so->Id_Strategic_Objectives }}" value="{{ $so->Details_Strategic_Objectives }}" class="form-control">
                                <button type="button" class="btn btn-outline-secondary clear-button">x</button>
                            </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add" id="addObjectiveButton">เพิ่มข้อมูล</button>
            </div>
        </div>


        <div id="kpisContainer">
            <div class="card p-3">
                <div class="form-group">
                    <label>ตัวชี้วัดกลยุทธ์และค่าเป้าหมาย(KPI)</label>
                    @foreach ($strategy->kpis as $kpi)
                    <div class="mb-4">
                        <label for="Name_Kpi_{{ $kpi->Id_Kpi }}"></label>
                        <div class="input-group">
                            <input type="text" name="kpis[{{ $kpi->Id_Kpi }}][Name_Kpi]" id="Name_Kpi_{{ $kpi->Id_Kpi }}" value="{{ $kpi->Name_Kpi }}" class="form-control">
                            <button type="button" class="btn btn-outline-secondary clear-button">x</button>
                        </div>
                        <label for="Target_Value_{{ $kpi->Id_Kpi }}"></label>
                        <div class="input-group">
                            <input type="text" name="kpis[{{ $kpi->Id_Kpi }}][Target_Value]" id="Target_Value_{{ $kpi->Id_Kpi }}" value="{{ $kpi->Target_Value }}" class="form-control">
                            <button type="button" class="btn btn-outline-secondary clear-button">x</button>
                        </div>                   
                    </div>
                    @endforeach   
                </div>
                <button type="button" class="btn-add" id="addKpiButton">เพิ่มข้อมูล</button>
            </div>
        </div>

        

        <a href="{{ route('strategy.index', $Id_Strategic) }}" class="btn btn-danger">ยกเลิก</a>
        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
    </form>
</div>

<script>
    document.querySelectorAll('.clear-button').forEach(button => {
        button.addEventListener('click', function() {
            this.previousElementSibling.value = '';
        });
    });

    document.getElementById('addObjectiveButton').addEventListener('click', function() {
        const container = document.querySelector('#strategicObjectivesContainer .card');
        const index = container.querySelectorAll('.form-group').length;
        const newObjective = document.createElement('div');
        newObjective.classList.add('form-group');
        newObjective.innerHTML = `
            <label for="newStrategicObjectives_${index}"></label>
            <div class="input-group mb-3">
                <input type="text" name="newStrategicObjectives[]" id="newStrategicObjectives_${index}" class="form-control" placeholder="กรอกวัตถุประสงค์เชิงกลยุทธ์" required>
                <button type="button" class="btn btn-danger remove-objective">ลบ</button>
            </div>
        `;
        container.insertBefore(newObjective, this);
    });

    document.getElementById('strategicObjectivesContainer').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-objective')) {
            event.target.closest('.form-group').remove();
        }
    });

    document.getElementById('addKpiButton').addEventListener('click', function() {
        const container = document.querySelector('#kpisContainer .card');
        const index = container.querySelectorAll('.form-group').length / 2;
        const newKpiName = document.createElement('div');
        newKpiName.classList.add('form-group');
        newKpiName.innerHTML = `
            <label for="newKpis_${index}_Name_Kpi">ตัวชี้วัดกลยุทธ์</label>
            <div class="input-group">
                <input type="text" name="newKpis[${index}][Name_Kpi]" id="newKpis_${index}_Name_Kpi" class="form-control" placeholder="กรอกตัวชี้วัดกลยุทธ์" required>
            </div>
            <label for="newKpis_${index}_Target_Value">ค่าเป้าหมาย</label>
            <div class="input-group">
                <input type="text" name="newKpis[${index}][Target_Value]" id="newKpis_${index}_Target_Value" class="form-control" placeholder="กรอกค่าเป้าหมาย" required>
            </div>
            <button type="button" class="btn btn-danger remove-kpi mt-3">ลบ</button>
        `;
        container.insertBefore(newKpiName, this); 

    });

    document.getElementById('kpisContainer').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-kpi')) {
            event.target.closest('.form-group').remove();
        }
    });
</script>
@endsection