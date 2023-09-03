<?php

namespace App\Http\Controllers;

use App\Models\AssistanceModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
class AssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $assistances = AssistanceModel::with([
                'type',
                'service',
                'department_user.department',
                'department_user.department.area',
                'department_user.department.time',
                'department_user.user.profile',
                'department_user.state'
            ])->orderBy('created_at','desc')->get();
            return response()->json($assistances);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos'.$e], 500);
        }
    }
    public function indexToday()
    {
        $today = Carbon::today()->toDateString();
        try {
            $assistances = AssistanceModel::with([
                'type',
                'service',
                'department_user.department',
                'department_user.department.area',
                'department_user.department.time',
                'department_user.user.profile',
                'department_user.state'
            ])->whereDate('created_at', $today)->orderBy('created_at','desc')->get();
            return response()->json($assistances);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos'.$e], 500);
        }
    }
    /*public function assistancesAll()
    {
        try {
            $assistances = AssistanceModel::select('a.idAssistance', 'b.name_type', 'c.name_service', 'c.time_seconds', 'a.created_at', 'd.idUser', 'e.usuario', 'f.name_profile', 'f.lastname')
                ->from('assistance as a')
                ->join('type as b', 'a.idType', '=', 'b.idType')
                ->join('service as c', 'a.idService', '=', 'c.idService')
                ->join('department_user as d', 'a.idDepartmentUser', '=', 'd.idDepartmentUser')
                ->join('user as e', 'd.idUser', '=', 'e.idUser')
                ->join('profile as f', 'e.idUser', '=', 'f.idUser')
                ->orderBy('a.created_at', 'desc')
                ->get();
            return response()->json($assistances);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexión a la base de datos'], 500);
        }
    }*/
    public function assistancesAll()
    {
        try {
            $assistances = AssistanceModel::with(['type',
                'service',
                'department_user.department',
                'department_user.department.area',
                'department_user.user.profile',
                'department_user.state'])
            ->orderBy('a.created_at', 'desc')
            ->get();
            return response()->json($assistances);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexión a la base de datos'], 500);
        }
    }
    /*public function assistancesByUser($idUser)
    {
        try {
            $assistances = AssistanceModel::select('a.idAssistance', 'b.name_type', 'c.name_service', 'c.time_seconds', 'a.created_at', 'd.idUser', 'e.usuario', 'f.name_profile', 'f.lastname')
                ->from('assistance as a')
                ->join('type as b', 'a.idType', '=', 'b.idType')
                ->join('service as c', 'a.idService', '=', 'c.idService')
                ->join('department_user as d', 'a.idDepartmentUser', '=', 'd.idDepartmentUser')
                ->join('user as e', 'd.idUser', '=', 'e.idUser')
                ->join('profile as f', 'e.idUser', '=', 'f.idUser')
                ->where('e.idUser', $idUser)
                ->orderBy('a.created_at', 'desc')
                ->get();
            return response()->json($assistances);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexión a la base de datos'], 500);
        }
    }*/
    public function assistancesByUser($idUser)
    {
        try {
            $assistance = AssistanceModel::with(['type',
                'service',
                'department_user.department',
                'department_user.department.area',
                'department_user.department.time',
                'department_user.user.profile',
                'department_user.state'])
            ->whereHas('department_user', function ($query) use ($idUser) {
                $query->where('idUser', $idUser);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            // Verificar si se encontro
            if ($assistance) {
                return response()->json($assistance);
            } else {
                return response()->json(['message' => 'La asistencia no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }
    public function assistancesDetailsByUser($idUser,$start_date, $end_date)
    {
        try {
            $assistances = AssistanceModel::with([
                'type',
                'service',
                'department_user.department',
                'department_user.department.area',
                'department_user.department.time',
                'department_user.user.profile',
                'department_user.state'
            ])
                ->whereHas('department_user', function ($query) use ($idUser) {
                    $query->where('idUser', $idUser);
                })
                ->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
                ->orderBy('created_at', 'asc')
                ->get();
    
            $result = [];
            $entryMap = []; // Mapa para emparejar entradas con salidas
    
            foreach ($assistances as $assistance) {
                if ($assistance->service->name_service === 'Gestión') {
                    $timeDifference = strtotime($assistance->department_user->department->time->end_time)
                                     - strtotime($assistance->department_user->department->time->start_time);
                    $assistance->service->time_seconds = $timeDifference;
                }
    
                if ($assistance->type->name_type === 'Entrada') {
                    if ($assistance->service->name_service === 'Gestión') {
                        $timeDifference = $assistance->service->time_seconds
                                       + strtotime($assistance->department_user->department->time->start_time)
                                       - strtotime($assistance->department_user->department->time->end_time);
                    } else {
                        $timeDifference = null;
                    }
                    
                    $entryMap[$assistance->service->idService][] = [
                        'user' => $assistance->department_user->user,
                        'service' => $assistance->service,
                        'start_date' => $assistance->created_at,
                        'end_date' => null,
                        'time_difference' => $timeDifference
                    ];
                } elseif ($assistance->type->name_type === 'Salida' && isset($entryMap[$assistance->service->idService])) {
                    $entry = array_pop($entryMap[$assistance->service->idService]);
                    $entry['end_date'] = $assistance->created_at;
                    /*if ($entry['service']->name_service !== 'Gestión') {
                        $timeDifference = strtotime($entry['end_date']) - strtotime($entry['start_date']);
                        if ($timeDifference > $entry['service']->time_seconds) {
                            $entry['time_difference'] = $timeDifference - $entry['service']->time_seconds;
                        }
                    }*/
                    $timeDifference = strtotime($entry['end_date']) - strtotime($entry['start_date']);
                    if ($entry['service']->name_service !== 'Gestión') {
                        if ($timeDifference > $entry['service']->time_seconds) {
                            $entry['time_difference'] = $timeDifference - $entry['service']->time_seconds;
                        }
                    }else{
                        $entry['time_difference'] = $entry['service']->time_seconds - $timeDifference;
                    }

                    $result[] = $entry;
                }
            }
    
            // Agregar las entradas sin salida correspondiente
            foreach ($entryMap as $unpairedEntries) {
                foreach ($unpairedEntries as $entry) {
                    $entry['end_date'] = 'Falta marcar';
                    $entry['time_difference'] = null;
                    $result[] = $entry;
                }
            }
            usort($result, function ($a, $b) {
                return strtotime($b['start_date']) - strtotime($a['start_date']);
            });
            return response()->json($result);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexión a la base de datos: '.$e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Crear nuevo assistance
            $assistance = new AssistanceModel();
            $assistance->observation = $request->input('observation');
            $assistance->idDepartmentUser = $request->input('idDepartmentUser');
            $assistance->idType = $request->input('idType');
            $assistance->idService = $request->input('idService');
            $assistance->save();
            
            return response()->json(['message' => 'Asistencia creada correctamente','response'=>$assistance], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idAssistance)
    {
        try {
            $assistance = AssistanceModel::with([
                'type',
                'service',
                'department_user.department',
                'department_user.department.area',
                'department_user.user.profile',
                'department_user.state'])
            ->where('idAssistance', $idAssistance)->first();
            // Verificar si se encontro
            if ($assistance) {
                return response()->json($assistance);
            } else {
                return response()->json(['message' => 'La asistencia no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssistanceModel $assistanceModel, $idAssistance)
    {
        try {
            // Verificar si existe
            $assistance = $assistanceModel->findOrFail($idAssistance);

            // Actualizar los campos
            $assistance->observation = $request->input('observation');
            $assistance->idDepartmentUser = $request->input('idDepartmentUser');
            $assistance->idType = $request->input('idType');
            $assistance->idService = $request->input('idService');
            $assistance->save();

            return response()->json($assistance);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El assistance no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssistanceModel $assistanceModel, $idAssistance)
    {
        try {
            // Verificar si existe
            $assistance = $assistanceModel->findOrFail($idAssistance);

            // Eliminar
            $assistance->delete();
            return response()->json(['message' => 'Assistance eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El assistance no existe'], 400);
        }
    }
}
