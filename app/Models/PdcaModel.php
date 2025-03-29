<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdcaModel extends Model
{
    
    protected $table = 'PDCA_Stages';
    protected $primaryKey = 'Id_PDCA_Stages';
    protected $fillable = [
        'Name_PDCA',
    ];

    public $timestamps = false; 

    
    public function pdcaDetail()
    {
        return $this->hasOne(PdcaDetailsModel::class, 'PDCA_Stages_Id', 'Id_PDCA_Stages');
    }

    public function monthlyPlans()
    {
        return $this->hasMany(MonthlyPlansModel::class, 'Id_PDCA_Stages', 'PDCA_Stages_Id');
    }
}
