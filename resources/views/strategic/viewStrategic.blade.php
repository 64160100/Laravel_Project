@extends('navbar.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/viewStrategic.css') }}">

@section('content')
<div class="container">
<div class="d-flex justify-content-start align-items-center">
        <a href="{{ route('setting') }}" class="back-btn">
            <i class='bx bxs-left-arrow-square'></i>
        </a>
        <h1 class="ms-3">แผนยุทธศาสตร์</h1>
    </div>

    <div class="grid gap-4 mt-4">
        @foreach($quarters as $quarter)
        <div
            class="border rounded-lg hover:bg-gray-50 transition-colors cursor-pointer border-l-4 border-l-transparent hover:border-l-blue-500 bg-white">
            <div class="accordion-btn">
                <div class="flex items-center space-x-4">
                    <div class="text-lg">
                        ปีงบประมาณ {{ $quarter->Fiscal_Year }} ไตรมาส {{ $quarter->Quarter }}
                    </div>
                    <a href="#collapse{{ $quarter->Id_Quarter_Project }}"
                        class="inline-flex items-center px-3 py-1 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-md transition-colors"
                        data-bs-toggle="collapse">
                        <i class="bx bx-search mr-2"></i>
                        เลือก
                    </a>
                </div>
                <div class="flex items-center space-x-4 ml-auto">
                    <a href="#" class='btn-add' data-bs-toggle="modal" data-bs-target="#ModalAddStrategic"
                        data-quarter-id="{{ $quarter->Id_Quarter_Project }}">เพิ่มข้อมูล</a>
                </div>
            </div>

            <div id="collapse{{ $quarter->Id_Quarter_Project }}" class="collapse">
                @php
                $hasStrategic = false;
                @endphp
                @foreach ($strategic as $Strategic)
                @if ($Strategic->quarterProjects->contains('Quarter_Project_Id', $quarter->Id_Quarter_Project))
                @php
                $hasStrategic = true;
                @endphp
                <div class='card p-3 m-3 mt-4'>
                    <h3>
                        <a
                            href="{{ route('strategy.index', $Strategic->Id_Strategic) }}">{{ $Strategic->Name_Strategic_Plan }}</a>
                    </h3>
                    {{ $Strategic->Goals_Strategic }}

                    <hr>
                    <div class="action-buttons">
                        <a href="#" class='bx bx-edit-alt' data-bs-toggle="modal"
                            data-bs-target="#ModalEditStrategic{{ $Strategic->Id_Strategic }}"></a>
                        <form action="{{ route('strategic.destroy', $Strategic->Id_Strategic) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class='bx bx-trash'
                                onclick="return confirm('คุณยืนยันที่จะลบข้อมูลนี้หรือไม่');"></button>
                        </form>
                    </div>
                </div>
                @endif
                @endforeach
                @if (!$hasStrategic)
                <div class='card p-3 m-3'>ไม่พบข้อมูลแผนยุทธศาสตร์</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modalAddStrategic = document.getElementById('ModalAddStrategic');
    modalAddStrategic.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var quarterId = button.getAttribute('data-quarter-id');
        var select = modalAddStrategic.querySelector('#Fiscal_Year_Quarter_Add');
        select.value = quarterId;
    });
});
</script>

@include('strategic.addStrategic')
@include('strategic.editStrategic')
@endsection