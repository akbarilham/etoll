<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P_PLAZA_GATE extends Model
{
    //
    protected $table = 'p_plaza_gate';
    protected $primaryKey = 'p_plaza_gate_id';
    public $timestamps = false;

	public function P_PLAZA()
    {
        return $this->belongsTo('App\Models\P_PLAZA' ,'p_plaza_id', 'p_plaza_id');
    }    
}    
