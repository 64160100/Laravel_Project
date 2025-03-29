<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SDGsModel extends Model
{
    
    protected $table = 'SDGs';
    protected $primaryKey = 'id_SDGs';
    protected $keyType = 'int';

    protected $fillable = [
        'Name_SDGs',
    ];
    public $timestamps = false;

    public function projects()
    {
        return $this->belongsToMany(ListProjectModel::class, 'Project_has_SDGs', 'SDGs_Id', 'Project_Id');
    }
}
