<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproveModel extends Model
{
    protected $table = 'Approve';
    protected $primaryKey = 'Id_Approve';
    protected $fillable = [
        'Status',
        'Project_Id',
    ];

    public $timestamps = false; 

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }

    public function recordHistory()
    {
        return $this->hasMany(RecordHistory::class, 'Approve_Id', 'Id_Approve');
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeModel::class, 'Employee_Id', 'Id_Employee');
    }

}