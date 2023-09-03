<?php

namespace App\Http\Controllers;

use App\Models\StateModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $states = StateModel::orderBy('name_state','asc')->get();
            return response()->json($states);
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
                'name_state' => 'required|unique:state,name_state'
            ]);
            
            // Crear nuevo state
            $state = new StateModel();
            $state->name_state = $request->input('name_state');
            $state->save();
            
            return response()->json(['message' => 'Estado creado correctamente','response'=>$state], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idState)
    {
        try {
            $state = StateModel::where('idState', $idState)->first();
            // Verificar si se encontro
            if ($state) {
                return response()->json($state);
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
    public function update(Request $request, StateModel $stateModel, $idState)
    {
        try {
            // Verificar si existe
            $state = $stateModel->findOrFail($idState);

            // Validar los campos del formulario
            $request->validate([
                'name_state' => [
                    'required',
                    Rule::unique('state')->ignore($idState, 'idState'),
                ],
            ]);

            // Actualizar los campos
            $state->name_state = $request->input('name_state');
            $state->save();

            return response()->json($state);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El state no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StateModel $stateModel, $idState)
    {
        try {
            // Verificar si existe
            $state = $stateModel->findOrFail($idState);

            // Eliminar
            $state->delete();
            return response()->json(['message' => 'State eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El state no existe'], 400);
        }
    }
}
