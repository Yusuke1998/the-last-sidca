<?php
// Periodo
namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = ['period','title','start','end'];

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
