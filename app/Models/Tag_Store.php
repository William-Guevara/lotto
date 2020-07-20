<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag_Store extends Model
{
    //tabla db
    protected $table = 'tag_store';
    protected $primaryKey = 'id';
    //datos a agregar de forma masiva
    protected $fillable = ['tag', 'store'];

    //datos a ocultar
    protected $hidden = [''];
    public $timestamps = false;
}