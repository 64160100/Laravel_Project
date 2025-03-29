<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetSourceTotalModel extends Model
{
    
    protected $table = 'Budget_Source_Total';
    protected $primaryKey = 'Id_Budget_Source_Total';
    
    protected $fillable = [
        'Amount_Total',
        'Project_has_Budget_Source_Id'
    ];
    
    public $timestamps = false;
    
    public function projectHasBudgetSource()
    {
        return $this->belongsTo(ProjectHasBudgetSourceModel::class, 'Project_has_Budget_Source_Id', 'Id_Project_has_Budget_Source');
    }
}