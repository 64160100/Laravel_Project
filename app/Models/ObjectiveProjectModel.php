<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectiveProjectModel extends Model
{
    
    protected $table = 'Objective_Project';
    protected $primaryKey = 'Id_Objective_Project';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Project_Id',
        'Description_Objective',
        'Type_Objective'
    ];

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }
}