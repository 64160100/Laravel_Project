<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpectedResultsModel extends Model
{
    
    protected $table = 'Expected_Results';
    protected $primaryKey = 'Id_Expected_Results';
    protected $fillable = [
        'Name_Expected_Results',
        'Project_Id',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }
}