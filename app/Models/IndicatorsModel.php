<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorsModel extends Model
{
    
    protected $table = 'Indicators';
    protected $primaryKey = 'Id_Indicators';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Type_Indicators',
    ];

    Public function projectHasIndicators()
    {
        return $this->hasMany(ProjectHasIndicatorsModel::class, 'Indicators_Id', 'Id_Indicators');
    }
}
