<?php

namespace App\Http\Controllers;

use App\Models\ServiceModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $services = ServiceModel::orderBy('position','asc')->get();
            return response()->json($services);
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
                'name_service' => 'required|unique:service,name_service'
            ]);
            
            // Crear nuevo service
            $service = new ServiceModel();
            $service->name_service = $request->input('name_service');
            $service->description_service = $request->input('description_service');
            $service->time_seconds = $request->input('time_seconds');
            $service->position = $request->input('position');
            $service->save();
            
            return response()->json(['message' => 'Servicio creado correctamente','response'=>$service], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idService)
    {
        try {
            $service = ServiceModel::where('idService', $idService)->first();
            // Verificar si se encontro
            if ($service) {
                return response()->json($service);
            } else {
                return response()->json(['message' => 'El servicio no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceModel $serviceModel, $idService)
    {
        try {
            // Verificar si existe
            $service = $serviceModel->findOrFail($idService);

            // Validar los campos del formulario
            $request->validate([
                'name_service' => [
                    'required',
                    Rule::unique('service')->ignore($idService, 'idService'),
                ],
            ]);

            // Actualizar los campos
            $service->name_service = $request->input('name_service');
            $service->description_service = $request->input('description_service');
            $service->time_seconds = $request->input('time_seconds');
            $service->position = $request->input('position');
            $service->save();

            return response()->json($service);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El service no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceModel $serviceModel, $idService)
    {
        try {
            // Verificar si existe
            $service = $serviceModel->findOrFail($idService);

            // Eliminar
            $service->delete();
            return response()->json(['message' => 'Service eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El service no existe'], 400);
        }
    }
}
