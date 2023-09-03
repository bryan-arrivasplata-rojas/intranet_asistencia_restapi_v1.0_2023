<?php

namespace App\Models;
use App\Models\UserModel;
use App\Models\DepartmentModel;
use App\Models\StateModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    use HasFactory;
    protected $table = 'area'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idArea'; //Nombre del identificador
    protected $fillable = [
        'idArea',
        'name_area',
        'description_area',
        'created_at',
        'idState'
    ];
    // Relación con el modelo DepartmentModel
    public function state()
    {
        return $this->belongsTo(StateModel::class, 'idState');
    }
    public function department()
    {
        return $this->hasMany(DepartmentModel::class,'idArea');
    }
    public function users()
    {
        return $this->hasMany(UserModel::class, DepartmentModel::class, 'idArea', 'idDepartment');
    }
}
