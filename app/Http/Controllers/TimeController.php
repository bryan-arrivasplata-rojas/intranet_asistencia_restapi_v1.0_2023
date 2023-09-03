<?php

namespace App\Http\Controllers;

use App\Models\TimeModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $times = TimeModel::orderBy('start_time','asc')->get();
            return response()->json($times);
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
            $existingTime = TimeModel::where([
                ['start_time', $request->input('start_time')],
                ['end_time', $request->input('end_time')],
            ])->exists();

            if ($existingTime) {
                return response()->json(['message' => 'La combinación de start_time y end_time ya existe'], 400);
            }
            
            // Crear nuevo time
            $time = new TimeModel();
            $time->start_time = $request->input('start_time');
            $time->end_time = $request->input('end_time');
            $time->created_at = Carbon::now('America/Lima')->toDateTimeString();
            $time->save();
            
            return response()->json(['message' => 'Time creado correctamente','response'=>$time], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idTime)
    {
        try {
            $time = TimeModel::where('idTime', $idTime)->first();
            // Verificar si se encontro
            if ($time) {
                return response()->json($time);
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
    public function update(Request $request, TimeModel $timeModel, $idTime)
    {
        try {
            // Verificar si existe
            $time = $timeModel->findOrFail($idTime);

            $existingTime = $timeModel->where([
                ['start_time', $request->input('start_time')],
                ['end_time', $request->input('end_time')],
            ])->where('idTime', '<>', $time->idTime)  // Excluir el registro actual
            ->exists();

            if ($existingTime) {
                return response()->json(['message' => 'La combinación de start_time y end_time ya existe'], 400);
            }

            // Actualizar los campos
            $time->start_time = $request->input('start_time');
            $time->end_time = $request->input('end_time');
            $time->save();

            return response()->json($time);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El time no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeModel $timeModel, $idTime)
    {
        try {
            // Verificar si existe
            $time = $timeModel->findOrFail($idTime);

            // Eliminar
            $time->delete();
            return response()->json(['message' => 'Time eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El time no existe'], 400);
        }
    }
}
