<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,
        HasFactory,
        HasProfilePhoto,
        Notifiable,
        TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function bans()
    {
        return $this->hasMany('App\Models\Ban');
    }

    public function issued_bans()
    {
        return $this->hasMany('App\Models\Ban', 'banner_id', 'id');
    }

    public function blocks()
    {
        return $this->belongsToMany('App\Models\User', 'blocks', 'blocker_id', 'user_id');
    }

    public function blocked_by()
    {
        return $this->belongsToMany('App\Models\User', 'blocks', 'user_id', 'blocker_id');
    }

    public function followers()
    {
        return $this->belongsToMany('App\Models\User', 'followers', 'user_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany('App\Models\User', 'followers', 'follower_id', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Model\Post');
    }

    public function reactions()
    {
        return $this->hasMany('App\Models\Reaction');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }
}
