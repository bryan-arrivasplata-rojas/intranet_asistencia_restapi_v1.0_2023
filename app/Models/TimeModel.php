<?php

namespace App\Models;

use App\Models\DepartmentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeModel extends Model
{
    use HasFactory;
    protected $table = 'time'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idTime'; //Nombre del identificador
    protected $fillable = [
        'idTime',
        'start_time',
        'end_time',
        'created_at'
    ];
    // Relación con el modelo DepartmentModel
    public function department()
    {
        return $this->hasOne(DepartmentModel::class, 'idDepartment');
    }
}
