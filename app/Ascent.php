<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ascent extends Model
{
    protected $fillable = ['current_category_id','next_category_id','teacher_id','time','modality'];

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
}
