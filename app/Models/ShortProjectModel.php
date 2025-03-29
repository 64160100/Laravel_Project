<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortProjectModel extends Model
{
    
    protected $table = 'Short_Project';
    protected $primaryKey = 'id_Short_Project';
    protected $keyType = 'int';

    protected $fillable = [
        'Details_Short_Project',
        'Project_Id',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'Project_Id', 'Id_Project');
    }
}
