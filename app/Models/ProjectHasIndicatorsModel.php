<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHasIndicatorsModel extends Model
{
    protected $connection = 'mydb';
    protected $table = 'Project_has_Indicators';
    protected $primaryKey = 'Project_Id';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Project_Id',
        'Indicators_Id',
        'Details_Indicators'
    ];

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }

    public function indicators()
    {
        return $this->belongsTo(IndicatorsModel::class, 'Indicators_Id', 'Id_Indicators');
    }
}
