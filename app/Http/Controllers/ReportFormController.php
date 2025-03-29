<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListProjectModel;
use App\Models\RecordHistory;
use App\Models\MonthsModel;
use App\Models\PdcaModel;
use App\Models\StrategicHasQuarterProjectModel;
use App\Models\StrategicModel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PDF;
use Storage;
use App\Models\ProjectHasBudgetSourceModel;
use App\Models\OutcomeModel;
use App\Models\OutputModel;
use App\Models\ExpectedResultsModel;
use App\Models\StorageFileModel;

class ReportFormController extends Controller
{
    public function showReportForm($id)
    {
        $project = ListProjectModel::with([ 'employee', 'targets.targetDetails', 'locations', 
                            'projectHasIndicators.indicators','shortProjects','objectives',
                            'monthlyPlans','monthlyPlans.month', 'monthlyPlans.pdca',])->findOrFail($id);

        $months = MonthsModel::orderBy('Id_Months', 'asc')->pluck('Name_Month', 'Id_Months');
        $pdcaStages = PdcaModel::all();

        $quarterProjectId = request()->input('quarter_project_id', StrategicHasQuarterProjectModel::pluck('Quarter_Project_Id')->first() ?? 1);
        $quarterProjects = StrategicHasQuarterProjectModel::with(['strategic', 'quarterProject'])
                    ->where('Quarter_Project_Id', $quarterProjectId)
                    ->get();
                    
        $project->formatted_first_time = formatDateThai($project->First_Time);
        $project->formatted_end_time = formatDateThai($project->End_Time);

        $data = [
            'title' => $project->Name_Project,
            'date' => toThaiNumber(date('d/m/Y')),
            'project' => $project,
            'months' => $months,
            'pdcaStages' => $pdcaStages,
            'quarterProjects' => $quarterProjects,    
        ];

        return view('ReportForm', $data);
    }

    public function completeProject(Request $request, $id)
    {
        $request->validate([
            'Summary' => 'nullable|string',
            'External_Participation' => 'nullable|string',
            'Suggestions' => 'nullable|string',
        ]);

        $project = ListProjectModel::with('approvals')->findOrFail($id);

        $project->update([
            'Summary' => $request->input('Summary'),
            'External_Participation' => $request->input('External_Participation'),
            'Suggestions' => $request->input('Suggestions'),
        ]);

        if ($request->input('action') === 'complete') {
            $approval = $project->approvals->first();
            if ($approval) {
                $approval->Status = 'Y';
                $approval->save();
            }

        $this->generateAndSavePDF($id);

        return redirect()->back()->with('success', 'โครงการเสร็จสิ้นและสร้าง PDF สำเร็จ!');
        } elseif ($request->input('action') === 'submit') {
            // ส่งโครงการเพื่อพิจารณา
            return redirect()->route('projects.submitForApproval', ['id' => $id])
                ->with('success', 'โครงการถูกเสนอเพื่อพิจารณาเรียบร้อย!');
        }

        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ!');
    }

    public function generateAndSavePDF($id)
    {
        $project = ListProjectModel::with(['employee', 'targets.targetDetails', 'locations', 
                            'projectHasIndicators.indicators','shortProjects',
                            'monthlyPlans','monthlyPlans.month', 'monthlyPlans.pdca',])->findOrFail($id);

        $projectBudgetSources = ProjectHasBudgetSourceModel::with('budgetSource')
                    ->where('Project_Id', $id)->get();

        $months = MonthsModel::orderBy('Id_Months', 'asc')->pluck('Name_Month', 'Id_Months');
        $pdcaStages = PdcaModel::all();

        $quarterProjectId = request()->input('quarter_project_id', StrategicHasQuarterProjectModel::pluck('Quarter_Project_Id')->first() ?? 1);
        $quarterProjects = StrategicHasQuarterProjectModel::with(['strategic', 'quarterProject'])
                    ->where('Quarter_Project_Id', $quarterProjectId)
                    ->get();

        // app/Helpers.php
        $project->formatted_first_time = formatDateThai($project->First_Time);
        $project->formatted_end_time = formatDateThai($project->End_Time);
    
        $data = [
            'title' => $project->Name_Project,
            'date' => toThaiNumber(date('d/m/Y')),
            'project' => $project,
            'months' => $months,
            'pdcaStages' => $pdcaStages,
            'quarterProjects' => $quarterProjects,
        ];
    
        $pdf = PDF::loadView('PDF.PDFReportForm', $data);

        $pdf->getDomPDF()->set_option("fontDir", public_path('fonts/'));
        $pdf->getDomPDF()->set_option("font_cache", public_path('fonts/'));
        $pdf->getDomPDF()->set_option("defaultFont", "THSarabunNew");
        $pdf->getDomPDF()->set_option("isRemoteEnabled", true);

        $filename = 'project_' . $project->Id_Project . '_report_' . date('Y-m-d') . '.pdf';
        $folderPath = 'uploads/project_' . $project->Id_Project;
        $filePath = $folderPath . '/' . $filename;

        $pdfContent = $pdf->output();
        $pdfSize = strlen($pdfContent);
        $pdfSizeInMB = round($pdfSize / (1024 * 1024), 2);
        $maxFileSizeInMB = config('filesystems.max_upload_size', 20);

        if ($pdfSizeInMB > $maxFileSizeInMB) {
            throw new \Exception("PDF size ({$pdfSizeInMB} MB) exceeds the limit of {$maxFileSizeInMB} MB");
        }

        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath);
        }

        if (Storage::disk('public')->put($filePath, $pdfContent)) {
            $storageFile = StorageFileModel::create([
                'Name_Storage_File' => $filename,
                'Path_Storage_File' => $filePath,
                'Type_Storage_File' => 'application/pdf',
                'Size' => $pdfSize,
                'Project_Id' => $project->Id_Project
            ]);

            if (!$storageFile) {
                throw new \Exception('Failed to create storage file record');
            }
        } else {
            throw new \Exception('Failed to save PDF file');
        }
    }
}