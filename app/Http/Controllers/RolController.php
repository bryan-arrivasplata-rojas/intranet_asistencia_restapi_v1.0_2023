<?php

namespace App\Http\Controllers;

use App\Models\RolModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rols = RolModel::orderBy('name_rol','asc')->get();
            return response()->json($rols);
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
            $request->validate([
                'name_rol' => 'required|unique:rol,name_rol',
            ]);
            
            // Crear nuevo rol
            $rol = new RolModel();
            $rol->name_rol = $request->input('name_rol');
            $rol->name_rol_view = $request->input('name_rol_view');
            $rol->description_rol = $request->input('description_rol');
            $rol->save();
            
            return response()->json(['message' => 'Rol creado correctamente','response'=>$rol], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idRol)
    {
        try {
            $rol = RolModel::where('idRol', $idRol)->first();
            // Verificar si se encontro
            if ($rol) {
                return response()->json($rol);
            } else {
                return response()->json(['message' => 'El tipo no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RolModel $rolModel, $idRol)
    {
        try {
            // Verificar si existe
            $rol = $rolModel->findOrFail($idRol);

            // Validar los campos del formulario
            $request->validate([
                'name_rol' => [
                    'required',
                    Rule::unique('rol')->ignore($idRol, 'idRol'),
                ],
            ]);

            // Actualizar los campos
            $rol->name_rol = $request->input('name_rol');
            $rol->name_rol_view = $request->input('name_rol_view');
            $rol->description_rol = $request->input('description_rol');
            $rol->save();

            return response()->json($rol);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El rol no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RolModel $rolModel, $idRol)
    {
        try {
            // Verificar si existe
            $rol = $rolModel->findOrFail($idRol);

            // Eliminar
            $rol->delete();
            return response()->json(['message' => 'Rol eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El rol no existe'], 400);
        }
    }
}
