<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceModel extends Model
{
    use HasFactory;
    protected $table = 'service'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idService'; //Nombre del identificador
    protected $fillable = [
        'idService',
        'name_service',
        'description_service',
        'time_seconds',
        'position'
    ];
}
