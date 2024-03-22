<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;
    protected $table="buyers";
    protected $key="id";
    protected $fillable=[
        'teamname','coach_name','state','contact','networth','password'
    ];

    public function players(){
        return $this->hasMany(Player::class,'id','id');
    }
}
