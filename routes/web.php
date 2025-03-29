<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ListProjectController;
use App\Http\Controllers\StorageFileController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PlanDLCController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\FiscalYearQuarterController;
use App\Http\Controllers\ProposeProjectController;
use App\Http\Controllers\RequestApprovalController;
use App\Http\Controllers\ReportFormController;
use App\Http\Controllers\SustainableDevelopmentGoalsController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

require __DIR__.'/account.php';
require __DIR__.'/auth.php';
require __DIR__.'/strategic.php';

Route::get('/setting', [SettingController::class, 'settings'])->name('setting');

Route::get('/listProject', [ListProjectController::class, 'project'])->name('project');

// ฟอร์มเริ่มต้น [count-step-0,1]

Route::get('/createFirstForm/{Strategic_Id}', [ListProjectController::class, 'showCreateFirstForm'])->name('showCreateFirstForm');
Route::get('/createProject/{Strategic_Id}', [ListProjectController::class, 'showCreateForm'])->name('showCreateProject');
Route::post('/createProject/{Strategic_Id}', [ListProjectController::class, 'createProject'])->name('createProject');
Route::put('/approvals/disapproveAll/{id}', [ListProjectController::class, 'disapproveAll'])->name('disapproveAll');
Route::put('/approvals/updateAllStatus', [RequestApprovalController::class, 'updateAllStatus'])->name('updateAllStatus');

Route::get('/search-projects', [ListProjectController::class, 'searchProjects'])->name('search.projects');

Route::get('/proposeProject', [ProposeProjectController::class, 'proposeProject'])->name('proposeProject');
Route::post('/projects/submit-for-approval/{id}', [ProposeProjectController::class, 'submitForApproval'])->name('projects.submitForApproval');

Route::post('/projects/update-status/{id}', [ProposeProjectController::class, 'updateStatus'])->name('projects.updateStatus');

Route::post('/submit-for-all-approval', [ProposeProjectController::class, 'submitForAllApproval'])->name('projects.submitForAllApproval');

// Routes แก้ไขฟอร์มใหญ๋
Route::get('/project/{id}/edit', [ListProjectController::class, 'editAllProject'])->name('projects.edit');

Route::post('/projects/reset-status/{id}', [ListProjectController::class, 'resetStatus'])->name('projects.resetStatus');

Route::post('/projects/{id}/update-responsible', 'App\Http\Controllers\ProposeProjectController@updateResponsible')->name('projects.updateResponsible');

Route::post('/projects/{id}/updateEmployee', [ProposeProjectController::class, 'updateEmployee'])->name('projects.updateEmployee');

// แก้ไขโครงการ
Route::post('/createProject/{Strategic_Id}', [ListProjectController::class, 'createProject'])->name('createProject');
Route::match(['get', 'post'],'/editProject/{Id_Project}', [ListProjectController::class, 'editProject'])->name('editProject');
Route::put('/editProject/{Id_Project}', [ListProjectController::class, 'updateProject'])->name('updateProject');

// แก้ไขโครงการ
Route::put('/project/{id}', [ListProjectController::class, 'update'])->name('projects.update');

//แสดงหน้า Strategic
Route::get('/viewProjectInStrategic/{Id_Strategic}', [ListProjectController::class, 'viewProjectInStrategic'])->name('viewProjectInStrategic');
Route::get('/viewProject/{Id_Project}', [ListProjectController::class, 'viewProject'])->name('viewProject');

//การอนุมัติโครงการ
Route::get('/requestApproval', [RequestApprovalController::class, 'showAllApprovals'])->name('requestApproval');
Route::put('/approvals/{id}/status/{status}', [RequestApprovalController::class, 'updateApprovalStatus'])->name('approvals.updateStatus');
Route::get('/editForm', [RequestApprovalController::class, 'approveProject'])->name('approveProject');
Route::put('/disapprove-project/{id}', [RequestApprovalController::class, 'disapproveProject'])->name('disapproveProject');


// คลังไฟล์ PDF
Route::get('/storage-files/{project_id?}', [StorageFileController::class, 'index'])->name('StorageFiles.index');
Route::post('/storage-files', [StorageFileController::class, 'store'])->name('StorageFiles.store');
Route::post('/storage-files/update-name', [StorageFileController::class, 'updateName'])->name('StorageFiles.updateName');


Route::delete('/storage-files/{id}', [StorageFileController::class, 'destroy'])->name('StorageFiles.destroy');
Route::get('/{id}/download', [StorageFileController::class, 'download'])->name('StorageFiles.download');
Route::get('/storage-files/{id}/view', [StorageFileController::class, 'view'])->name('StorageFiles.view');

// การแสดงสถานะโครงการ
Route::get('/statusTracking', [StatusController::class, 'statusTracking'])->name('status.tracking');
Route::get('/project/{Id_Project}', [StatusController::class, 'showDetails'])->name('project.details');

// การแสดง PDF
Route::get('generate-pdf/{id}', [PDFController::class, 'generatePDF'])->name('PDF.generate');
Route::get('actionplan-pdf', [PDFController::class, 'ActionPlanPDF']);
Route::get('strategic-pdf/{Id_Strategic}', [PDFController::class, 'PDFStrategic'])->name('PDF.strategic');
Route::get('report-pdf/{id}', [PDFController::class, 'generatePDFReportForm'])->name('PDF.generateReportForm');


Route::get('pdfStrategic/{Id_Project}', [PDFController::class, 'ctrlpPDFStrategic'])->name('pdf.strategicCtrlP');

Route::get('project-pdf/{Id_Project}', [PDFController::class, 'PDFProject'])->name('PDF.Project');
Route::get('pdfproject/{Id_Project}', [PDFController::class, 'ctrlpPDFProject'])->name('PDF.projectCtrlP');

//PlanDLC
Route::get('/report', [PlanDLCController::class, 'report'])->name('PlanDLC.report');
Route::get('/checkBudget', [PlanDLCController::class, 'checkBudget'])->name('PlanDLC.checkBudget');
Route::get('/allProject', [PlanDLCController::class, 'allProject'])->name('PlanDLC.allProject');
Route::get('/editBudget', [PlanDLCController::class, 'editBudget'])->name('PlanDLC.editBudget');
Route::get('/showProjectDepartment/{Id_Department}', [PlanDLCController::class, 'showProjectDepartment'])->name('showProjectDepartment');

// FiscalYearQuarter
Route::resource('fiscalYearQuarter', FiscalYearQuarterController::class);

Route::get('/report-form/{id}', [ReportFormController::class, 'showReportForm'])->name('reportForm');
Route::post('/projects/complete/{id}', [ReportFormController::class, 'completeProject'])->name('projects.complete');

//Sdg
Route::get('showSdg', [SustainableDevelopmentGoalsController::class, 'showSdg'])->name('showSdg');
Route::post('/showSdg', [SustainableDevelopmentGoalsController::class, 'createSDG'])->name('createSDG');
Route::put('/editSDG/{id_SDGs}', [SustainableDevelopmentGoalsController::class, 'editSDG'])->name('editSDG');
Route::delete('/deleteSDG/{id_SDGs}', [SustainableDevelopmentGoalsController::class, 'deleteSDG'])->name('deleteSDG');


// Project inline editing NameProject, Employee
Route::post('/projects/{id}/update-field', [ListProjectController::class, 'updateField'])->name('projects.updateField');
// Project inline editing SDGs
Route::post('/projects/{id}/update-sdgs', [ListProjectController::class, 'updateSdgs'])->name('projects.updateSdgs');
// Project inline editing Integration
Route::post('/projects/{id}/update-integration', [ListProjectController::class, 'updateIntegration'])->name('projects.updateIntegration');
Route::post('/projects/{id}/update-integration-details', [ListProjectController::class, 'updateIntegrationDetails'])->name('projects.updateIntegrationDetails');

// Routes for Target Group
Route::post('/create-empty-target/{projectId}', [ListProjectController::class, 'createEmptyTargetGroup'])->name('target.create-empty');
Route::post('/create-target-with-value/{projectId}', [ListProjectController::class, 'createTargetGroupWithValue'])->name('target.create-with-value');
Route::post('/update-target-by-id/{id}', [ListProjectController::class, 'updateTargetGroupById'])->name('target.update-by-id');
Route::delete('/delete-target-by-id/{id}', [ListProjectController::class, 'deleteTargetGroupById'])->name('target.delete-by-id');
Route::get('/get-targets/{projectId}', [ListProjectController::class, 'getTargetGroups'])->name('target.get');

// Project inline editing Logcation
Route::post('/create-empty-location/{projectId}', [ListProjectController::class, 'createEmptyLocation'])->name('location.create-empty');
Route::post('/create-location-with-value/{projectId}', [ListProjectController::class, 'createLocationWithValue'])->name('location.create-with-value');
Route::post('/update-location-by-id/{id}', [ListProjectController::class, 'updateLocationById'])->name('location.update-by-id');
Route::delete('/delete-location-by-id/{id}', [ListProjectController::class, 'deleteLocationById'])->name('location.delete-by-id');
Route::get('/get-locations/{projectId}', [ListProjectController::class, 'getLocations'])->name('location.get');

// Project inline editing Output, Outcome และ Expected Results
Route::get('/get-outputs/{id}', [ListProjectController::class, 'getOutputs'])->name('output.get');
Route::post('/create-output-with-value/{projectId}', [ListProjectController::class, 'createOutputWithValue'])->name('output.create-with-value');
Route::post('/create-empty-output/{id}', [ListProjectController::class, 'createEmptyOutput'])->name('output.create-empty');
Route::post('/update-output-by-id/{id}', [ListProjectController::class, 'updateOutputById'])->name('output.update-by-id');
Route::post('/soft-delete-output/{outputId}', [ListProjectController::class, 'softDeleteOutput'])->name('output.soft-delete');
Route::delete('/delete-output-by-id/{id}', [ListProjectController::class, 'deleteOutputById'])->name('output.delete-by-id');

Route::post('/create-empty-outcome/{projectId}', [ListProjectController::class, 'createEmptyOutcome'])->name('outcome.create-empty');
Route::post('/create-outcome-with-value/{projectId}', [ListProjectController::class, 'createOutcomeWithValue'])->name('outcome.create-with-value');
Route::post('/update-outcome-by-id/{id}', [ListProjectController::class, 'updateOutcomeById'])->name('outcome.update-by-id');
Route::delete('/delete-outcome-by-id/{id}', [ListProjectController::class, 'deleteOutcomeById'])->name('outcome.delete-by-id');
Route::get('/get-outcomes/{projectId}', [ListProjectController::class, 'getOutcomes'])->name('outcome.get');

Route::post('/create-empty-expected-result/{projectId}', [ListProjectController::class, 'createEmptyExpectedResult'])->name('expected-result.create-empty');
Route::post('/create-expected-result-with-value/{projectId}', [ListProjectController::class, 'createExpectedResultWithValue'])->name('result.create-with-value');
Route::post('/update-expected-result-by-id/{id}', [ListProjectController::class, 'updateExpectedResultById'])->name('expected-result.update-by-id');
Route::delete('/delete-expected-result-by-id/{id}', [ListProjectController::class, 'deleteExpectedResultById'])->name('expected-result.delete-by-id');
Route::get('/get-expected-results/{projectId}', [ListProjectController::class, 'getExpectedResults'])->name('expected-result.get');

Route::post('/update-target-details/{projectId}', [ListProjectController::class, 'updateTargetDetails'])->name('target.update-details');
Route::get('/get-target-details/{projectId}', [ListProjectController::class, 'getTargetDetails'])->name('target.get-details');

// Routes for Indicators
Route::get('/get-indicators/{projectId}', [ListProjectController::class, 'getIndicators'])->name('indicators.get');
Route::post('/create-indicator-with-value/{projectId}/{type}', [ListProjectController::class, 'createIndicatorWithValue'])->name('indicators.createWithValue');
Route::post('/create-empty-indicator/{projectId}/{type}', [ListProjectController::class, 'createEmptyIndicator'])->name('indicators.create.empty');
Route::post('/update-indicator/{indicatorId}', [ListProjectController::class, 'updateIndicator'])->name('indicators.update');
Route::delete('/delete-indicator/{indicatorId}', [ListProjectController::class, 'deleteIndicator'])->name('indicators.delete');
Route::delete('/delete-indicators-by-type/{projectId}/{type}', [ListProjectController::class, 'deleteIndicatorsByType'])->name('indicators.deleteByType');

// Routes สำหรับจัดการวัตถุประสงค์โครงการ
Route::post('/projects/objectives/add', [ListProjectController::class, 'addObjective'])->name('objectives.add');
Route::post('/projects/objectives/update/{id}', [ListProjectController::class, 'updateObjective'])->name('objectives.update');
Route::delete('/projects/objectives/delete/{id}', [ListProjectController::class, 'deleteObjective'])->name('objectives.delete');

Route::put('/api/projects/{id}/speaker', [ListProjectController::class, 'updateSpeaker'])->name('api.projects.updateSpeaker');

// Routes for Platform, Program, and KPI inline editing
Route::post('/api/projects/{projectId}/save-platforms', [ListProjectController::class, 'savePlatforms'])->name('api.projects.savePlatforms');