<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P_ROLE_MENU extends Model
{
    //
    protected $table = 'p_role_menu';
    public $timestamps = false;
    protected $fillable = ['p_role_id', 'p_menu_id', 'creation_date', 'create_by'];

    protected $primaryKey = 'p_role_menu_id';
}
