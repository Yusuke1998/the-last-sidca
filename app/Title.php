<?php
// Titulo
namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = ['title','level'];

    public function universities()
    {
    	return $this->belongsToMany(University::class);
    }

    public function teachers()
    {
    	return $this->belongsToMany(Teacher::class);
    }
}
