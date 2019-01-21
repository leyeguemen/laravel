<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    // atributos del la tabla
    protected $fillable = [
        'nombre_usuario',
        'apellido_usuario',
        'fecha_reserva',
        'numero_personas',
        'fila_butaca',
        'columna_butaca'
    ];

}
