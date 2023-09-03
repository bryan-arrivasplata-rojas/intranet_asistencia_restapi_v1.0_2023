<?php

namespace App\Models;

use App\Models\ProfileModel;
use App\Models\DepartmentUserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'user'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idUser'; //Nombre del identificador
    protected $fillable = [
        'idUser',
        'usuario',
        'password',
    ];
    public function profile()
    {
        return $this->hasOne(ProfileModel::class, 'idUser');
    }
    public function department_user()
    {
        return $this->hasOne(DepartmentUserModel::class, 'idUser');
    }
}
