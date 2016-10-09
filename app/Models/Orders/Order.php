<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function lokasi()
    {
    	return $this->hasOne(Lokasi::class);
    }

    public function newLokasi()
    {
    	$lokasi = new Lokasi;
    	$lokasi->order()->associate($this);

    	return $lokasi;
    }
}
