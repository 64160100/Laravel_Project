<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrategicObjectivesModel extends Model
{
    
    protected $table = 'Strategic_Objectives';
    protected $primaryKey = 'Id_Strategic_Objectives';
    protected $fillable = [
        'Details_Strategic_Objectives',
        'Strategy_Id',
        'Strategy_Strategic_Id'
    ];
    public $timestamps = false;

}