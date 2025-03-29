<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyPlansModel extends Model
{
    
    protected $table = 'Monthly_Plans';
    protected $primaryKey = 'Id_Monthly_Plans';
    protected $fillable = [
        'Project_id',
        'Months_Id',
        'PDCA_Stages_Id',
        'Fiscal_year',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_id', 'Id_Project');
    }

    public function month()
    {
        return $this->belongsTo(MonthsModel::class, 'Months_Id', 'Id_Months');
    }

    public function pdca()
    {
        return $this->belongsTo(PdcaModel::class, 'PDCA_Stages_Id', 'Id_PDCA_Stages');
    }
}
