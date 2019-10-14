<?php
// Titulo
namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = ['title','level','grade'];

    public function universities()
    {
    	return $this->belongsToMany(University::class);
    }

    public function teachers()
    {
    	return $this->belongsToMany(Teacher::class);
    }

    public function postgraduates()
    {
        return $this->hasMany(Postgraduate::class);
    }

    public function undergraduates()
    {
        return $this->hasMany(Undergraduate::class);
    }
}
