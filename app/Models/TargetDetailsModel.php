<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetDetailsModel extends Model
{
    
    protected $table = 'Target_Details';
    protected $primaryKey = 'Id_Target_Details';
    protected $keyType = 'int';
    protected $fillable = [
        'Details_Target',
        'Target_Project_Id'
    ];

    public $timestamps = false;

    public function targetProject()
    {
        return $this->belongsTo(TargetModel::class, 'Target_Project_Id', 'Id_Target_Project');
    }
}