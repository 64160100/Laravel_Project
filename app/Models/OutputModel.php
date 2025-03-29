<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutputModel extends Model
{
    
    protected $table = 'Output';
    protected $primaryKey = 'Id_Output';
    protected $fillable = [
        'Name_Output',
        'Project_Id',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }
}