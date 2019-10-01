<?php
// Universidad
namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = ['name','acronym'];

    public function titles()
    {
    	return $this->belongsToMany(Title::class);
    }
}
