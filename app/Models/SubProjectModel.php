<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProjectModel extends Model
{
    
    protected $table = 'Sub_Project';
    protected $primaryKey = 'Id_Sub_Project';
    protected $keyType = 'int';
    protected $fillable = [
        'Project_Id',
        'Name_Sub_Project'
    ];
    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }
}