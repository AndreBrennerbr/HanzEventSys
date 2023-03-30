<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;


class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'items' => 'array'
    ];

    protected $date =['date'];

    protected $guarded= [];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }



    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

   


}
