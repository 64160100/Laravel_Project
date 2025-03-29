<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrategyModel extends Model
{
    
    protected $table = 'Strategy';
    protected $primaryKey = 'Id_Strategy';
    protected $keyType = 'int';
    protected $fillable = [
        'Id_Strategy',
        'Strategic_Id',
        'Name_Strategy',
        'Strategy_Objectives',
    ];
    public $timestamps = false;

    public function projects()
    {
        return $this->hasMany(ListProjectModel::class, 'Strategy_Id', 'Id_Strategy');
    }

    public function kpis()
    {
        return $this->hasMany(KpiModel::class, 'Strategy_Id', 'Id_Strategy');
    }

    public function strategicObjectives()
    {
        return $this->hasMany(StrategicObjectivesModel::class, 'Strategy_Id', 'Id_Strategy');
    }

    public function strategic()
    {
        return $this->belongsTo(StrategicModel::class, 'Strategic_Id', 'Id_Strategic');
    }

    public function strategicHasQuarterProjects()
    {
        return $this->hasMany(StrategicHasQuarterProjectModel::class, 'Strategic_Id', 'Id_Strategic');
    }
}