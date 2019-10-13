<?php
// Programa
namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['name','headquarter_id','area_id'];

    public function headquarter()
    {
    	return $this->belongsTo(Headquarter::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function subjects()
    {
    	return $this->belongsToMany(Subject::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
