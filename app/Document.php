<?php
// Documento
namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name'];

    public function people()
    {
        return $this->hasMany(People::class);
    }
}
