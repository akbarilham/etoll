<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SEC_USER_DETAILS extends Model
{
    //
    protected $primaryKey = 'client_id';
    protected $table = 'sec_user_details';
	public $timestamps = false;

	public function CUSTOMER()
    {
        return $this->belongsTo('App\Models\CUSTOMER' ,'client_id', 'customer_id');
    }

}
