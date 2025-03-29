<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationModel extends Model
{   
    
    protected $table = 'Integration_Category';
    protected $primaryKey = 'Id_Integration_Category';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Name_Integration_Category'
    ];

    public function projectHasIntegrationCategories()
    {
        return $this->hasMany(ProjectHasIntegrationCategoryModel::class, 'Integration_Category_Id', 'Id_Integration_Category');
    }
}