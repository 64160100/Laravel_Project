<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrategicOpportunityDetailsModel extends Model
{
    
    protected $table = 'Strategic_Opportunity_Details';
    protected $primaryKey = 'Id_Strategic_Opportunity_Details';
    protected $keyType = 'int';
    protected $fillable = [
        'Strategic_Opportunity_Id',
        'Details_Strategic_Opportunity',
    ];
    public $timestamps = false;

    public function strategicOpportunity()
    {
        return $this->belongsTo(StrategicOpportunityModel::class, 'Strategic_Opportunity_Id', 'Id_Strategic_Opportunity');
    }

    
}