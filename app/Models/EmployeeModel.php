<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class EmployeeModel extends Model implements JWTSubject
{
    
    protected $table = 'Employee';
    protected $primaryKey = 'Id_Employee';
    protected $fillable = [
        'Username',
        'Password',
        'Prefix_Name',
        'Firstname',
        'Lastname',
        'Email',
        'Phone',
        'Department_Name',
        'Position_Name',
        'TypePersons',
        'Agency',
        'Status',
        'IsManager',
        'IsDirector',
        'IsFinance',
        'IsResponsible',
        'IsAdmin',
        'IsGeneralEmployees'
    ];

    public $timestamps = false; 

    public function managementPositions()
    {
        return $this->hasMany(ManagementPosition::class, 'Employee_Id', 'Id_Employee');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}