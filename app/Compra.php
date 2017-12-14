<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    public function card() {
	    return $this->belongsTo('App\Tarjeta', 'tarjeta_id');
	}
}
