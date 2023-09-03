<?php

namespace App\Http\Controllers;

use App\Models\AreaModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $areas = AreaModel::with('state','department')->orderBy('name_area','asc')->get();
            return response()->json($areas);
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
                'name_area' => 'required|unique:area,name_area'
            ]);
            
            // Crear nuevo area
            $area = new AreaModel();
            $area->name_area = $request->input('name_area');
            $area->description_area = $request->input('description_area');
            $area->idState = $request->input('idState');
            $area->created_at = Carbon::now('America/Lima')->toDateTimeString();
            $area->save();
            
            return response()->json(['message' => 'Area creado correctamente','response'=>$area], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idArea)
    {
        try {
            $area = AreaModel::with('state','department')->where('idArea', $idArea)->first();
            // Verificar si se encontro
            if ($area) {
                return response()->json($area);
            } else {
                return response()->json(['message' => 'El area no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AreaModel $areaModel, $idArea)
    {
        try {
            // Verificar si existe
            $area = $areaModel->findOrFail($idArea);

            // Validar los campos del formulario
            $request->validate([
                'name_area' => [
                    'required',
                    Rule::unique('area')->ignore($idArea, 'idArea'),
                ],
            ]);

            // Actualizar los campos
            $area->name_area = $request->input('name_area');
            $area->description_area = $request->input('description_area');
            $area->idState = $request->input('idState');
            $area->save();

            return response()->json($area);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El area no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaModel $areaModel, $idArea)
    {
        try {
            // Verificar si existe
            $area = $areaModel->findOrFail($idArea);

            // Eliminar
            $area->delete();
            return response()->json(['message' => 'Area eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El area no existe'], 400);
        }
    }
}
