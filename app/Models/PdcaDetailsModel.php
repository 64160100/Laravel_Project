<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdcaDetailsModel extends Model
{
    
    protected $table = 'PDCA_Stages_Details';
    protected $primaryKey = 'Id_PDCA_Stages_Details';
    protected $keyType = 'int';
    protected $fillable = [
        'Details_PDCA',
        'PDCA_Stages_Id',
        'Project_Id'
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }

    public function pdca()
    {
        return $this->belongsTo(PdcaModel::class, 'PDCA_Stages_Id', 'Id_PDCA_Stages');
    }
}