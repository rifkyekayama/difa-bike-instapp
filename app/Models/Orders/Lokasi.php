<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    //
    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function withTitle($title)
    {
    	$this->title = $title;
    	return $this;
    }

    public function withAddress($address)
    {
    	$this->address = $address;
    	return $this;
    }

    public function withLatitude($latitude)
    {
    	$this->latitude = $latitude;
    	return $this;
    }

    public function withLongitude($longitude)
    {
    	$this->longitude = $longitude;
    	return $this;
    }

    public function saveLokasi()
    {
    	$this->save();
    	return $this;
    }
}
