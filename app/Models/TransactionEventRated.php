<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionEventRated extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_event_rated';

    public function getUpdatedAtColumn() {
        return null;
    }

}
