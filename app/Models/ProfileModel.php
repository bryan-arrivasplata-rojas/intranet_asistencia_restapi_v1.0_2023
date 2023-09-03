<?php

namespace App\Models;

use App\Models\UserModel;
use App\Models\RolModel;
use App\Models\StateModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileModel extends Model
{
    use HasFactory;
    protected $table = 'profile'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idProfile'; //Nombre del identificador
    protected $fillable = [
        'idProfile',
        'name_profile',
        'apellido_profile',
        'email',
        'image',
        'created_at',
        'idState',
        'idUser',
        'idRol'
    ];
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'idUser');
    }
    public function rol()
    {
        return $this->belongsTo(RolModel::class, 'idRol');
    }

    public function state()
    {
        return $this->belongsTo(StateModel::class, 'idState');
    }
}
