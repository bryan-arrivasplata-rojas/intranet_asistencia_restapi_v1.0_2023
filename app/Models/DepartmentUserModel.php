<?php

namespace App\Models;

use App\Models\DepartmentModel;
use App\Models\UserModel;
use App\Models\StateModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUserModel extends Model
{
    use HasFactory;
    protected $table = 'department_user'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idDepartmentUser'; //Nombre del identificador
    protected $fillable = [
        'idDepartmentUser',
        'idDepartment',
        'idUser',
        'idState'
    ];
    public function state()
    {
        return $this->belongsTo(StateModel::class, 'idState');
    }
    public function department()
    {
        return $this->belongsTo(DepartmentModel::class, 'idDepartment');
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'idUser');
    }
}
