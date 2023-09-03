<?php

namespace App\Http\Controllers;

use App\Models\DepartmentModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $departments = DepartmentModel::with('area','state','time')->orderBy('idArea','asc')->get();
            return response()->json($departments);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos'], 500);
        }
    }
    /*public function usersByDepartment($idDepartment)
    {
        try {
            $department = DepartmentModel::with('area', 'state', 'time', 'users')
                ->where('idDepartment', $idDepartment)
                ->first();
    
            if ($department) {
                return response()->json($department);
            } else {
                return response()->json(['message' => 'Departamento no encontrado'], 404);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexión a la base de datos'], 500);
        }
    }*/

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar campos
            $request->validate([
                'name_department' => 'required|unique:department,name_department'
            ]);
            
            // Crear nuevo department
            $department = new DepartmentModel();
            $department->name_department = $request->input('name_department');
            $department->description_department = $request->input('description_department');
            $department->idState = $request->input('idState');
            $department->idArea = $request->input('idArea');
            $department->idTime = $request->input('idTime');
            $department->created_at = Carbon::now('America/Lima')->toDateTimeString();
            $department->save();
            
            return response()->json(['message' => 'Departamento creado correctamente','response'=>$department], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idDepartment)
    {
        try {
            $department = DepartmentModel::with('area','state','time')->where('idDepartment', $idDepartment)->first();
            // Verificar si se encontro
            if ($department) {
                return response()->json($department);
            } else {
                return response()->json(['message' => 'El departamento no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DepartmentModel $departmentModel, $idDepartment)
    {
        try {
            // Verificar si existe
            $department = $departmentModel->findOrFail($idDepartment);

            // Validar los campos del formulario
            $request->validate([
                'name_department' => [
                    'required',
                    Rule::unique('department')->ignore($idDepartment, 'idDepartment'),
                ],
            ]);

            // Actualizar los campos
            $department->name_department = $request->input('name_department');
            $department->description_department = $request->input('description_department');
            $department->idState = $request->input('idState');
            $department->idArea = $request->input('idArea');
            $department->idTime = $request->input('idTime');
            $department->save();

            return response()->json($department);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El department no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentModel $departmentModel, $idDepartment)
    {
        try {
            // Verificar si existe
            $department = $departmentModel->findOrFail($idDepartment);

            // Eliminar
            $department->delete();
            return response()->json(['message' => 'Department eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El department no existe'], 400);
        }
    }
}
