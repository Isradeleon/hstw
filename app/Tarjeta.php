<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    protected $table = 'tarjetas';
    public $timestamps = false;

    public function moves() {
        return $this->hasMany('App\Compra', 'tarjeta_id');
    }

    public function user() {
	    return $this->belongsTo('App\User', 'usuario_id');
	}
}
