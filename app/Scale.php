<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scale extends Model
{
    protected $fillable=[
    	'date','description','file','postgraduate_id','ascent_id','teacher_id'
    ];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function ascent()
    {
    	return $this->belongsTo(Ascent::class);
    }

    public function postgraduate()
    {
    	return $this->belongsTo(Postgraduate::class);
    }
}
