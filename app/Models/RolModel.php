<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolModel extends Model
{
    use HasFactory;
    protected $table = 'rol'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idRol'; //Nombre del identificador
    protected $fillable = [
        'idRol',
        'name_rol',
        'name_rol_view',
        'description_rol',
        'created_at'
    ];
}