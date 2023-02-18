<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $table = "officer";

    public function absent(){

        return $this->hasMany(Absent::class,'officer_id');

    }

    public function user(){

        return $this->belongsTo(User::class, 'users_id');
    }
}
