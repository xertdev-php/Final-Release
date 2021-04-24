<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    public function country()
    {
        return $this->belongsTo(Country::class,"country","id");
    }
}
