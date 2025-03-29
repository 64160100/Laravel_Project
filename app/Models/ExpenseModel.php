<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseModel extends Model
{
    
    protected $table = 'Expense';
    protected $primaryKey = 'Id_Expense';
    
    protected $fillable = [
        'Expense_Types_Id',
        'Date_Expense',
        'Details_Expense'
    ];
    
    public $timestamps = false;
    
    public function expenseType()
    {
        return $this->belongsTo(ExpenseTypesModel::class, 'Expense_Types_Id', 'Id_Expense_Types');
    }
    public function expenHasSubtopicBudgets()
    {
        return $this->hasMany(ExpenHasSubtopicBudgetModel::class, 'Expense_Id', 'Id_Expense');
    }
}