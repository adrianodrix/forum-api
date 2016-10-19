<?php

namespace Forum\Models;


use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'title', 'slug', 'description'
    ];
}