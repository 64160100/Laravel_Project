<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHasIntegrationCategoryModel extends Model
{
    
    protected $table = 'Project_has_Integration_Category';
    protected $primaryKey = 'Id_Project_has_Integration_Category';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Project_Id',
        'Integration_Category_Id',
        'Integration_Details'
    ];


    public function project()
    {
        return $this->belongsTo(ListProjectModel::class, 'Project_Id', 'Id_Project');
    }

    public function integrationCategory()
    {
        return $this->belongsTo(IntegrationModel::class, 'Integration_Category_Id', 'Id_Integration_Category');
    }
}
