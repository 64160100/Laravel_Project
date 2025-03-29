<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrategicChallengesModel extends Model
{
    
    protected $table = 'Strategic_Challenges';
    protected $primaryKey = 'Id_Strategic_Challenges';
    protected $keyType = 'int';
    protected $fillable = [
        'Details_Strategic_Challenges',
        'Strategic_Opportunity_Id',
    ];
    public $timestamps = false;

    public function strategicOpportunity()
    {
        return $this->belongsTo(StrategicOpportunityModel::class, 'Strategic_Opportunity_Id', 'Id_Strategic_Opportunity');
    }
}