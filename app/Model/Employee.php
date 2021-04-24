<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    public function department()
    {
        return $this->belongsTo(Department::class,"department_id","id");
    }
    public function country()
    {
        return $this->belongsTo(Country::class,"country_id","id");
    }
    public function state()
    {
        return $this->belongsTo(State::class,"state_id","id");
    }
    public function city()
    {
        return $this->belongsTo(City::class,"city_id","id");
    }
}
