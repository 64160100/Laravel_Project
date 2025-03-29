<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StrategyModel;
use App\Models\ListProjectModel;
use Illuminate\Support\Facades\DB;


class StrategicModel extends Model
{
    
    protected $table = 'Strategic';
    protected $primaryKey = 'Id_Strategic';
    protected $keyType = 'int';

    protected $fillable = [
        'Name_Strategic_Plan',
        'Goals_Strategic',
    ];
    public $timestamps = false;

    public function strategies()
    {
        return $this->hasMany(StrategyModel::class, 'Strategic_Id', 'Id_Strategic');
    }

    public function projects()
    {
        return $this->hasMany(ListProjectModel::class, 'Strategic_Id', 'Id_Strategic');
    }

    public function quarterProjects()
    {
        return $this->hasMany(StrategicHasQuarterProjectModel::class, 'Strategic_Id', 'Id_Strategic');
    }
}