<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiModel extends Model
{
    
    protected $table = 'Kpi';
    protected $primaryKey = 'Id_Kpi';
    protected $fillable = [
        'Id_Kpi',
        'Name_Kpi',
        'Target_Value',
        'Strategy_Id',
        'Strategy_Strategic_Id'
    ];
    public $timestamps = false;

    public function strategy()
    {
        return $this->belongsTo(StrategyModel::class, 'Strategy_Id', 'Id_Strategy');
    }

}