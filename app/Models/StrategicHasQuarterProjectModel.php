<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StrategicModel;
use App\Models\FiscalYearQuarterModel;

class StrategicHasQuarterProjectModel extends Model
{
    
    protected $table = 'Strategic_has_Quarter_Project';
    protected $fillable = [
        'Strategic_Id',
        'Quarter_Project_Id',
    ];
    public $timestamps = false;

    public function strategic()
    {
        return $this->belongsTo(StrategicModel::class, 'Strategic_Id', 'Id_Strategic');
    }

    public function strategy()
    {
        return $this->belongsTo(StrategyModel::class, 'Strategic_Id', 'Id_Strategic');
    }

    public function quarterProject()
    {
        return $this->belongsTo(FiscalYearQuarterModel::class, 'Quarter_Project_Id', 'Id_Quarter_Project');
    }
}