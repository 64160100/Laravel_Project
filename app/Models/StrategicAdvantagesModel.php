<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrategicAdvantagesModel extends Model
{
    
    protected $table = 'Strategic_Advantages';
    protected $primaryKey = 'Id_Strategic_Advantages';
    protected $keyType = 'int';
    protected $fillable = [
        'Details_Strategic_Advantages',
        'Strategic_Opportunity_Id',
    ];
    public $timestamps = false;

    public function strategicOpportunity()
    {
        return $this->belongsTo(StrategicOpportunityModel::class, 'Strategic_Opportunity_Id', 'Id_Strategic_Opportunity');
    }
}