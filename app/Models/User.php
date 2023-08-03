<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Followers;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 'birth_date', 'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
    }

    public function getBirthDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['birth_date'])->format('m/d/Y');

    }
    public function posts()
    {

        return $this->hasMany(Post::class,'user_id','id');
    }
    public function comments()
    {

        return $this->hasMany(Comment::class,'user_id','id');
    }

    public function following(){
        return $this->hasMany(Followers::class,'from_user_id');
    }
    public function follower(){
        return $this->hasMany(Followers::class,'to_user_id');
    }
}
