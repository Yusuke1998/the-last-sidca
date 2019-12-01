<?php
#postgrado
namespace App;

use Illuminate\Database\Eloquent\Model;

class Postgraduate extends Model
{
    protected $fillable = ['title_id','teacher_id','university_id','date'];

    public function university()
    {
    	return $this->belongsTo(University::class);
    }

    public function title()
    {
    	return $this->belongsTo(Title::class);
    }

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function scale()
    {
        return $this->hasMany(Scale::class);
    }
}
