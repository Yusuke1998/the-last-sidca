<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ascent extends Model
{
    protected $fillable = ['current_category_id','date','next_category_id','date_next','teacher_id','modality','status'];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function current_category()
    {
        return $this->belongsTo(Category::class,'current_category_id');
    }

    public function next_category()
    {
        return $this->belongsTo(Category::class,'next_category_id');
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    public function job()
    {
        return $this->hasOne(Job::class);
    }

    public function scale()
    {
        return $this->hasOne(Scale::class);
    }

    public function memo()
    {
        return $this->hasOne(Memo::class);
    }
}
