<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetSourceModel extends Model
{
    
    protected $table = 'Budget_Source';
    protected $primaryKey = 'Id_Budget_Source';
    protected $fillable = [
        'Name_Budget_Source',
    ];

    public $timestamps = false;

}
