<?php

use App\Http\Controllers\StrategicController;
use App\Http\Controllers\StrategyController;
use App\Http\Controllers\StrategicAnalysisController;

// แผนยุทศาสตร์
Route::get('/strategic',[StrategicController::class, 'index'])->name('strategic.index');
Route::post('/AddStrategic', [StrategicController::class, 'addStrategic'])->name('strategic.add');
Route::put('strategic/{Id_Strategic}', [strategicController::class, 'updateStrategic'])->name('strategic.update');
Route::delete('/strategic/{Id_Strategic}', [StrategicController::class, 'deleteStrategic'])->name('strategic.destroy');

// กลยุทธ์
Route::get('/strategy/{Id_Strategic}',[StrategyController::class, 'index'])->name('strategy.index');
Route::post('/AddStrategy', [StrategyController::class, 'addStrategy'])->name('strategy.add');

// ตัวชี้วัด
Route::get('/strategy/{Id_Strategy}/Kpi', [StrategyController::class, 'Kpi'])->name('kpi.index');
Route::post('/strategy/{Id_Strategy}/add-kpi', [StrategyController::class, 'addKpi'])->name('kpi.addKpi'); 

// ตัวชี้วัด
Route::get('/strategy/{Id_Strategy}/Kpi', [StrategyController::class, 'Kpi'])->name('kpi.index');
Route::post('/strategy/{Id_Strategy}/add-kpi', [StrategyController::class, 'addKpi'])->name('kpi.addKpi');

// วัตถุประสงค์เชิงกลยุทธ์
Route::get('/strategy/{Id_Strategy}/Strategic_Objectives', [StrategyController::class, 'StrategicObjectives'])->name('StrategicObjectives.index');
Route::post('/strategy/{Id_Strategy}/addStrategic_Objectives', [StrategyController::class, 'addStrategicObjectives'])->name('StrategicObjectives.add');

Route::get('/strategy/{Id_Strategy}/edit', [StrategyController::class, 'editStrategy'])->name('strategy.edit');
Route::put('/strategy/{Id_Strategy}', [StrategyController::class, 'updateStrategy'])->name('strategy.update');
Route::delete('/strategy/{Id_Strategy}', [StrategyController::class, 'deleteStrategy'])->name('strategy.destroy');

Route::post('/strategic-analysis/add', [StrategicAnalysisController::class, 'addDetail'])->name('StrategicAnalysis.addDetail');
Route::put('/strategic-analysis/update-detail/{type}/{id}', [StrategicAnalysisController::class, 'updateDetail'])->name('StrategicAnalysis.updateDetail');
Route::delete('/StrategicAnalysis/delete-detail/{type}/{id}', [StrategicAnalysisController::class, 'destroyDetail'])->name('StrategicAnalysis.destroyDetail');

Route::get('generate-pdf', [PDFController::class, 'generatePDF']);
Route::get('actionplan-pdf', [PDFController::class, 'ActionPlanPDF']);
Route::get('strategic-pdf/{Id_Strategic}', [PDFController::class, 'PDFStrategic'])->name('PDF.strategic');
Route::get('project-pdf/{Id_Project}', [PDFController::class, 'PDFProject'])->name('PDF.Project');

Route::get('pdfStrategic/{Id_Project}', [PDFController::class, 'ctrlpPDFStrategic'])->name('pdf.strategicCtrlP');
Route::get('pdfproject/{Id_Project}', [PDFController::class, 'ctrlpPDFProject'])->name('PDF.projectCtrlP');

Route::post('/strategic-opportunity/add', [StrategicAnalysisController::class, 'addOpportunity'])->name('StrategicOpportunity.addOpportunity');

Route::delete('/strategic-opportunity/{id}', [StrategicAnalysisController::class, 'destroyOpportunity'])->name('StrategicOpportunity.destroyOpportunity');