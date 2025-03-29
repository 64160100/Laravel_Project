<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValueTargetModel extends Model
{   
    
    protected $keyType = 'int';
    protected $table = 'Value_Target';
    protected $primaryKey = 'Id_Value_Target';
    public $timestamps = false;
    
    protected $fillable = [
        'Project_Id',
        'Value_Target',
        'Type_Value_Target',
        'Success_Indicators_Id'
    ];
    
    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }
    
    public function successIndicator()
    {
        return $this->belongsTo(SuccessIndicatorsModel::class, 'Success_Indicators_Id', 'Id_Success_Indicators');
    }
}