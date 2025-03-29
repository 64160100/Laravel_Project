<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramModel extends Model
{
    
    protected $table = 'Program';
    protected $primaryKey = 'Id_Program';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Name_Program',
        'Platform_Id'
    ];

    public function platform()
    {
        return $this->belongsTo(PlatformModel::class, 'Platform_Id', 'Id_Platform');
    }

    public function kpis()
    {
        return $this->hasMany(Kpi_ProgramModel::class, 'Program_Id', 'Id_Program');
    }
}
