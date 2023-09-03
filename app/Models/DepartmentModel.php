<?php

namespace App\Models;

use App\Models\StateModel;
use App\Models\AreaModel;
use App\Models\TimeModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    use HasFactory;
    protected $table = 'department'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idDepartment'; //Nombre del identificador
    protected $fillable = [
        'idDepartment',
        'name_department',
        'description_department',
        'created_at',
        'idState',
        'idArea',
        'idTime'
    ];
    public function state()
    {
        return $this->belongsTo(StateModel::class, 'idState');
    }
    public function area()
    {
        return $this->belongsTo(AreaModel::class, 'idArea');
    }
    public function time()
    {
        return $this->belongsTo(TimeModel::class, 'idTime');
    }
    public function users()
    {
        return $this->belongsToMany(UserModel::class, 'department_user', 'idDepartment', 'idUser');
    }
}
