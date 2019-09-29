<?php
// Programa
namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['name','career_id'];

    public function career()
    {
    	return $this->belongsTo(Career::class);
    }
}
