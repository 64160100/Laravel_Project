<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordHistory extends Model
{
    
    protected $table = 'Record_History';
    protected $primaryKey = 'Id_Record_History';
    protected $fillable = [
        'Comment',
        'Approve_Id',
        'Approve_Project_Id',
        'Time_Record',
        'Status_Record',
        'Name_Record',
        'Permission_Record', 
    ];

    public $timestamps = false;
    
    public function approval()
    {
        return $this->belongsTo(ApproveModel::class, 'Approve_Id', "Approve_Project_Id");
    }

    public function approvals()
    {
        return $this->belongsTo(ApproveModel::class, 'Approve_Id', 'Id_Approve');
    }

}
