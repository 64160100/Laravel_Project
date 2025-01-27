<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHasBudgetSourceModel extends Model
{
    protected $connection = 'mydb';
    protected $table = 'Project_has_Budget_Source';
    protected $primaryKey = 'Id_Project_has_Budget_Source';
    protected $fillable = [
        'Project_Id',
        'Budget_Source_Id',
        'Amount_Total',
        'Details_Expense',
    ];

    public $timestamps = false;


    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }

    public function budgetSource()
    {
        return $this->belongsTo(BudgetSourceModel::class, 'Budget_Source_Id', 'Id_Budget_Source');
    }
    
}