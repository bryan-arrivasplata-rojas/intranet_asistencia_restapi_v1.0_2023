<?php

namespace App\Models;

use App\Models\DepartmentUserModel;
use App\Models\TypeModel;
use App\Models\ServiceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceModel extends Model
{
    use HasFactory;
    protected $table = 'assistance'; // Nombre de la tabla
    public $timestamps = false; // Desactivar los campos timestamps
    protected $primaryKey = 'idAssistance'; //Nombre del identificador
    protected $fillable = [
        'idAssistance',
        'observation',
        'idDepartmentUser',
        'idType',
        'idService',
        'created_at'
    ];
    public function department_user()
    {
        return $this->belongsTo(DepartmentUserModel::class, 'idDepartmentUser');
    }
    public function type()
    {
        return $this->belongsTo(TypeModel::class, 'idType');
    }

    public function service()
    {
        return $this->belongsTo(ServiceModel::class, 'idService');
    }
}
