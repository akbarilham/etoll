<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionStatusList extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'T_STATUS_LIST';

    public function getUpdatedAtColumn() {
        return null;
    }

}
