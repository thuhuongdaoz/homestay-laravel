<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homestay extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'name',
            'location_id',
            'address',
            'avatar',
            'images',
            'desc',
//            'restaurant',
//            'free_wifi',
//            'pool',
//            'spa',
//            'bar',
//            'breakfast',
    'utilities',
    ];
}
