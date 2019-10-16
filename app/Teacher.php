<?php
// Profesor
namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
	protected $fillable = [
        'person_id','contract','headquarter_id','area_id','program_id',
        'core_id','extension_id','territorial_classroom_id',
        'condition_id','category_id','dedication_id','current_category',
        'next_category','status'
    ];

    public function postgraduates()
    {
        return $this->hasMany(Postgraduate::class);
    }

    public function undergraduates()
    {
        return $this->hasMany(Undergraduate::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function titles()
    {
    	return $this->belongsToMany(Title::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function dedication()
    {
        return $this->belongsTo(Dedication::class);
    }

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function core()
    {
        return $this->belongsTo(Core::class);
    }

    public function extension()
    {
        return $this->belongsTo(Extension::class);
    }

    public function TerritorialClassroom()
    {
        return $this->belongsTo(TerritorialClassroom::class);
    }
}
