<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagementPositionModel extends Model
{   
    
    protected $table = 'ManagementPosition';
    protected $primaryKey = 'Id_ManagementPosition';
    protected $fillable = [
        'ManagementPositionName',
        'Employee_Id'
    ];
    public $timestamps = false; // ถ้าไม่มี created_at และ updated_at

    public function employee()
    {
        return $this->belongsTo(EmployeeModel::class, 'Employee_Id', 'Id_Employee');
    }
}