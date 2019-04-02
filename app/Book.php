<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable=[
        'name', 'ISBN', 'pub_year','pub','image_path','author',
    ];

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    // public function ratings(){
    //     return $this->hasMany(Rating::class);
    // }

}

