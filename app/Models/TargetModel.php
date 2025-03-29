<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetModel extends Model
{
    
    protected $keyType = 'int';
    protected $table = 'Target_Project';
    protected $primaryKey = 'Id_Target_Project';
    protected $fillable = [
        'Name_Target',
        'Quantity_Target',
        'Unit_Target',
        'Project_Id',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }

    public function targetDetails()
    {
        return $this->hasMany(TargetDetailsModel::class, 'Target_Project_Id', 'Id_Target_Project');
    }
}