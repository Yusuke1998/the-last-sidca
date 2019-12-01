<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $fillable = [
    	'area_code','area_date',
    	'vrac_code','vrac_date',
    	'cu_code','cu_date',
    	'ascent_id'
    ];

    public function ascent()
    {
    	return $this->belongsTo(Ascent::class);
    }
}
