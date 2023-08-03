<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Followers extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function from_user(){
        return $this->belongsTo(User::class, 'from_user_id');
    }
    public function to_user(){
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
