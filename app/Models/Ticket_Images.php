<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket_Images extends Model
{
    //
    //tabla db
    protected $table = 'ticket_images';
    protected $primaryKey = 'image_id';
    //datos a agregar de forma masiva
    protected $fillable =
        [
        'image_id',
        'image_type',
        'image',
        'src_image',
        'image_size',
        'drawing_date',
        'purchased_product_id',
        'num_tickets',
        'current_ticket',
        'modified'
      ];

    //datos a ocultar
    protected $hidden = [''];
    public $timestamps = false;
}
