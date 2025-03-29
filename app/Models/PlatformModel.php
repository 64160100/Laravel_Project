<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformModel extends Model
{
    
    protected $table = 'Platform';
    protected $primaryKey = 'Id_Platform';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Name_Platform',
        'Project_Id'
    ];

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'Project_Id', 'Id_Project');
    }

    public function programs()
    {
        return $this->hasMany(ProgramModel::class, 'Platform_Id', 'Id_Platform');
    }
}