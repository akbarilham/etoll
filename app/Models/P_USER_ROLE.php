<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P_USER_ROLE extends Model
{
    //
    protected $table = 'p_user_role';
    public $timestamps = false;

    protected $primaryKey = 'p_user_role_id';

    protected $fillable = ['p_user_id', 'p_role_id', 'creation_date', 'created_by'];
}
