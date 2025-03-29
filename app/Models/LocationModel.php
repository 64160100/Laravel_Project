<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationModel extends Model
{
    
    protected $table = 'Location';
    protected $primaryKey = 'Id_Location';
    protected $fillable = [
        'Name_Location',
        'Project_Id',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }
}
