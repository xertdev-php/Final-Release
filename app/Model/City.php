<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    public function state()
    {
        return $this->belongsTo(State::class,"state","id");
    }
}
