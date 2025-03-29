<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseTypesModel extends Model
{
    
    protected $table = 'Expense_Types';
    protected $primaryKey = 'Id_Expense_Types';
    
    protected $fillable = [
        'Expense_Status',
        'Project_Id'
    ];
    
    public $timestamps = false;
    
    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }
    
    public function expenses()
    {
        return $this->hasMany(ExpenseModel::class, 'Expense_Types_Id', 'Id_Expense_Types');
    }
}