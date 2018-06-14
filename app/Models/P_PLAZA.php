<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P_PLAZA extends Model
{
    //
    protected $table = 'p_plaza';
    protected $primaryKey = 'p_plaza_id';
    public $timestamps = false;

	public function P_PLAZA_GATE()
    {
        return $this->hasOne('App\Models\P_PLAZA_GATE' ,'p_plaza_id', 'p_plaza_id');
    }    
}
