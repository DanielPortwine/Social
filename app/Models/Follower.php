<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follower_id',
        'accepted',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function follower()
    {
        return $this->belongsTo('App\Models\User');
    }
}
