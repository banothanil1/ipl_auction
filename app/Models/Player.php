<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected $table="players";
    protected $key="id";
    protected $fillable=[
        'name','jersy_number','place','age','baseprice'
    ];

    public function buyer(){
        return $this->belongsTo(Buyer::class,'id','id');
    }
}