<?php

namespace App\Http\Controllers;

use App\Models\TypeModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $types = TypeModel::orderBy('name_type','asc')->get();
            return response()->json($types);
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
                'name_type' => 'required|unique:type,name_type'
            ]);
            
            // Crear nuevo type
            $type = new TypeModel();
            $type->name_type = $request->input('name_type');
            $type->save();
            
            return response()->json(['message' => 'Tipo creado correctamente','response'=>$type], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idType)
    {
        try {
            $type = TypeModel::where('idType', $idType)->first();
            // Verificar si se encontro
            if ($type) {
                return response()->json($type);
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
    public function update(Request $request, TypeModel $typeModel, $idType)
    {
        try {
            // Verificar si existe
            $type = $typeModel->findOrFail($idType);

            // Validar los campos del formulario
            $request->validate([
                'name_type' => [
                    'required',
                    Rule::unique('type')->ignore($idType, 'idType'),
                ],
            ]);

            // Actualizar los campos
            $type->name_type = $request->input('name_type');
            $type->save();

            return response()->json($type);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El type no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeModel $typeModel, $idType)
    {
        try {
            // Verificar si existe
            $type = $typeModel->findOrFail($idType);

            // Eliminar
            $type->delete();
            return response()->json(['message' => 'Type eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El type no existe'], 400);
        }
    }
}
