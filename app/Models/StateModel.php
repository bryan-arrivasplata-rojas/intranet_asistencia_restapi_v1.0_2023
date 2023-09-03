<?php

namespace App\Models;

use App\Models\DepartmentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateModel extends Model
{
    use HasFactory;
    protected $table = 'state'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idState'; //Nombre del identificador
    protected $fillable = [
        'idState',
        'name_state'
    ];
    // Relación con el modelo DepartmentModel
    public function department()
    {
        return $this->hasOne(DepartmentModel::class, 'idDepartment');
    }
}
