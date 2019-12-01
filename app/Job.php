<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title','postgraduate_id','ascent_id','teacher_id','coordinator','principal1','principal2',
        'alternate1','alternate2','alternate3','url','file','location','datep','hourp','date'
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
