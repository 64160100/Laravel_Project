<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrategicOpportunityModel extends Model
{
    
    protected $table = 'Strategic_Opportunity';
    protected $primaryKey = 'Id_Strategic_Opportunity';
    protected $keyType = 'int';
    protected $fillable = [
        'Name_Strategic_Opportunity',
        'Strategic_Id',
    ];
    public $timestamps = false;

    public function strategies()
    {
        return $this->hasMany(StrategyModel::class, 'Strategic_Id', 'Id_Strategic');
    }

    public function projects()
    {
        return $this->hasMany(ListProjectModel::class, 'Strategic_Id', 'Id_Strategic');
    }

    public function quarterProjects()
    {
        return $this->belongsToMany(FiscalYearQuarterModel::class, 'StrategicHasQuarterProject', 'Strategic_Id', 'Quarter_Project_Id');
    }

    public function details()
    {
        return $this->hasMany(StrategicOpportunityDetailsModel::class, 'Strategic_Opportunity_Id', 'Id_Strategic_Opportunity');
    }

    public function challenges()
    {
        return $this->hasMany(StrategicChallengesModel::class, 'Strategic_Opportunity_Id', 'Id_Strategic_Opportunity');
    }

    public function advantages()
    {
        return $this->hasMany(StrategicAdvantagesModel::class, 'Strategic_Opportunity_Id', 'Id_Strategic_Opportunity');
    }
}