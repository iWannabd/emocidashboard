<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpo extends Model
{
    //
    protected $fillable = [
        'nama','kasus','usia','sex','call','img','validate'
    ];
}
