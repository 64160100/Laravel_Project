<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutcomeModel extends Model
{
    
    protected $table = 'Outcome';
    protected $primaryKey = 'Id_Outcome';
    protected $fillable = [
        'Name_Outcome',
        'Project_Id',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }
}