<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kpi_ProgramModel extends Model
{
    
    protected $table = 'Kpi_Program';
    protected $primaryKey = 'Id_KPI_Program';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Name_KPI',
        'Program_Id'
    ];

    public function program()
    {
        return $this->belongsTo(ProgramModel::class, 'Program_Id', 'Id_Program');
    }

}
