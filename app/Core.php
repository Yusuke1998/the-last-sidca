<?php
// Nucleo
namespace App;

use Illuminate\Database\Eloquent\Model;

class Core extends Model
{
    protected $fillable = ['name','headquarter_id'];

    public function headquarter()
    {
    	return $this->belongsTo(Headquarter::class);
    }

    public function areas()
    {
    	return $this->belongsToMany(Area::class);
    }
}
