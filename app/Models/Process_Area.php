<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process_Area extends Model
{
  //
  //tabla db
  protected $table = 'process_area';
  protected $primaryKey = 'id';
  //datos a agregar de forma masiva
  protected $fillable = ['facility', 'name', 'description', 'manager_name', 'manager_phone', 'manager_email', 'is_active', 'last_update'];

  //datos a ocultar
  protected $hidden = [''];
  public $timestamps = false;
}
