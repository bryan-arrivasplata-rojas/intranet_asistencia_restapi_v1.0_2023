<?php

namespace App\Http\Controllers;

use App\Models\DepartmentUserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class DepartmentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $department_users = DepartmentUserModel::with('department','user','user.profile','user.profile.rol','state')->orderBy('idDepartment','asc')->get();
            return response()->json($department_users);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar campos
            $existingDepartmentUser = DepartmentUserModel::where([
                ['idDepartment', $request->input('idDepartment')],
                ['idUser', $request->input('idUser')],
            ])->exists();

            if ($existingDepartmentUser) {
                return response()->json(['message' => 'La combinación de departamento y usuario ya existe'], 400);
            }
            
            // Crear nuevo department_user
            $department_user = new DepartmentUserModel();
            $department_user->idDepartment = $request->input('idDepartment');
            $department_user->idUser = $request->input('idUser');
            $department_user->idState = $request->input('idState');
            $department_user->save();
            
            return response()->json(['message' => 'Departamento usuario creado correctamente','response'=>$department_user], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idDepartmentUser)
    {
        try {
            $department_user = DepartmentUserModel::with('department','user','state')->where('idDepartmentUser', $idDepartmentUser)->first();
            // Verificar si se encontro
            if ($department_user) {
                return response()->json($department_user);
            } else {
                return response()->json(['message' => 'El departamento usuario no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DepartmentUserModel $department_userModel, $idDepartmentUser)
    {
        try {
            // Verificar si existe
            $department_user = $department_userModel->findOrFail($idDepartmentUser);

            // Validar los campos del formulario
            $existingDepartmentUser = $department_userModel->where([
                ['idDepartment', $request->input('idDepartment')],
                ['idUser', $request->input('idUser')],
            ])->where('idDepartmentUser', '<>', $department_user->idDepartmentUser)  // Excluir el registro actual
            ->exists();

            if ($existingDepartmentUser) {
                return response()->json(['message' => 'La combinación de departamento y usuario ya existe'], 400);
            }

            // Actualizar los campos
            $department_user->idDepartment = $request->input('idDepartment');
            $department_user->idUser = $request->input('idUser');
            $department_user->idState = $request->input('idState');
            $department_user->save();

            return response()->json($department_user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El department_user no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentUserModel $department_userModel, $idDepartmentUser)
    {
        try {
            // Verificar si existe
            $department_user = $department_userModel->findOrFail($idDepartmentUser);

            // Eliminar
            $department_user->delete();
            return response()->json(['message' => 'DepartmentUser eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El department_user no existe'], 400);
        }
    }
}
