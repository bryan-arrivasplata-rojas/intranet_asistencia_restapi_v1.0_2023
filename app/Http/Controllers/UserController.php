<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = UserModel::with(['profile', 'profile.rol', 'profile.state'])->orderBy('idUser','desc')->get();
            return response()->json($users);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos'], 500);
        }
    }

    public function userAvailable()
    {
        try {
            $users = UserModel::with(['profile', 'profile.rol', 'profile.state'])->whereDoesntHave('profile')->orderBy('idUser','desc')->get();
            return response()->json($users);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos :'.$e], 500);
        }
    }
    public function userAvailableByIdProfile($idProfile)
    {
        try {
            $usersWithoutProfile = UserModel::with(['profile', 'profile.rol', 'profile.state'])
                ->whereDoesntHave('profile')
                ->orderBy('idUser', 'desc')
                ->get();

            $userWithSpecificProfile = UserModel::with(['profile', 'profile.rol', 'profile.state'])
                ->whereHas('profile', function ($query) use ($idProfile) {
                    $query->where('idProfile', $idProfile);
                })
                ->orderBy('idUser', 'desc')
                ->get();

            $combinedUsers = $usersWithoutProfile->concat($userWithSpecificProfile);
            return response()->json($combinedUsers);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos :'.$e], 500);
        }
    }

    public function userAvailableDepartmentUser()
    {
        try {
            $users = UserModel::with(['department_user', 'department_user.user', 'department_user.state'])->whereDoesntHave('department_user')->orderBy('idUser','desc')->get();
            return response()->json($users);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos :'.$e], 500);
        }
    }
    public function userAvailableDepartmentUserByIdDepartmentUser($idDepartmentUser)
    {
        try {
            $usersWithoutDepartmentUser = UserModel::with(['department_user', 'department_user.user', 'department_user.state'])
                ->whereDoesntHave('department_user')
                ->orderBy('idUser', 'desc')
                ->get();

            $userWithSpecificDepartmentUser = UserModel::with(['department_user', 'department_user.user', 'department_user.state'])
                ->whereHas('department_user', function ($query) use ($idDepartmentUser) {
                    $query->where('idDepartmentUser', $idDepartmentUser);
                })
                ->orderBy('idUser', 'desc')
                ->get();

            $combinedUsers = $usersWithoutDepartmentUser->concat($userWithSpecificDepartmentUser);
            return response()->json($combinedUsers);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos :'.$e], 500);
        }
    }

    public function login($usuario)
    {
        try {
            $user = UserModel::with(['profile', 'profile.rol', 'profile.state','department_user'])->where('usuario', $usuario)->orderBy('usuario', 'desc')->first();
            // Verificar si se encontro un usuario con el correo electronico dado
            if ($user) {
                return response()->json($user);
            } else {
                return response()->json(['message' => 'El usuario no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }
    
    public function usersByArea($idArea)
    {
        try {
            $users = UserModel::select('a.idUser', 'a.password', 'b.name_profile', 'b.lastname', 'b.image', 'b.email', 'c.name_rol', 'g.name_area', 'd.name_department', 'f.name_state')
                ->from('user as a')
                ->join('profile as b', 'a.idUser', '=', 'b.idUser')
                ->join('department_user as e', 'a.idUser', '=', 'e.idUser')
                ->join('department as d', 'd.idDepartment', '=', 'e.idDepartment')
                ->join('rol as c', 'b.idRol', '=', 'c.idRol')
                ->join('state as f', 'b.idState', '=', 'f.idState')
                ->join('area as g', 'd.idArea', '=', 'g.idArea')
                ->where('g.idArea', $idArea)
                ->get();

            return response()->json($users);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexión a la base de datos'], 500);
        }
    }
    public function usersByDepartment($idDepartment)
    {
        try {
            $users = UserModel::select('a.idUser', 'a.password', 'b.name_profile', 'b.lastname', 'b.image', 'b.email', 'c.name_rol', 'c.description_rol', 'd.name_department', 'd.description_department','f.name_state')
                ->from('user as a')
                ->join('profile as b', 'a.idUser', '=', 'b.idUser')
                ->join('department_user as e', 'a.idUser', '=', 'e.idUser')
                ->join('department as d', 'd.idDepartment', '=', 'e.idDepartment')
                ->join('rol as c', 'b.idRol', '=', 'c.idRol')
                ->join('state as f', 'b.idState', '=', 'f.idState')
                ->where('d.idDepartment', $idDepartment)
                ->get();

            return response()->json($users);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexión a la base de datos'], 500);
        }
    }
    public function userState($usuario)
    {
        try {
            $userStates = UserModel::select('f.idState', 'f.name_state')
                ->from('user as a')
                ->join('department_user as b', 'a.idUser', '=', 'b.idUser')
                ->join('department as c', 'b.idDepartment', '=', 'c.idDepartment')
                ->join('area as d', 'c.idArea', '=', 'd.idArea')
                ->join('profile as e', 'a.idUser', '=', 'e.idUser')
                ->join('state as f', function ($join) {
                    $join->on('b.idState', '=', 'f.idState')
                        ->on('c.idState', '=', 'f.idState')
                        ->on('d.idState', '=', 'f.idState')
                        ->on('e.idState', '=', 'f.idState');
                })
                ->where('f.name_state', '=', 'enabled')
                ->where('a.usuario', '=', $usuario)
                ->first();
            if (!$userStates) {
                return response()->json(['name_state' => 'disabled']);
            }
            return response()->json($userStates);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexión a la base de datos: ' . $e->getMessage()], 500);
        }
    }
    public function userService($idUser)
    {
        try {
            $now = Carbon::now('UTC'); // Obtener la fecha y hora actual en UTC
            $now->setTimezone('America/Lima');
            $userServices = DB::table('assistance as a')
                ->join('type as b', 'a.idType', '=', 'b.idType')
                ->join('service as c', 'a.idService', '=', 'c.idService')
                ->join('department_user as d', 'a.idDepartmentUser', '=', 'd.idDepartmentUser')
                ->join('user as e', 'd.idUser', '=', 'e.idUser')
                ->whereDate('a.created_at', $now->toDateString())
                ->where('e.idUser', $idUser)
                ->groupBy('c.name_service','d.idDepartmentUser')
                ->select('c.name_service','d.idDepartmentUser', DB::raw('count(c.name_service) as count_service'))
                ->get();
            return response()->json($userServices);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexión a la base de datos: ' . $e->getMessage()], 500);
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
                'usuario' => 'required|unique:user,usuario',
                'password' => 'required',
            ]);
            
            // Crear nuevo usuario
            $user = new UserModel();
            $user->usuario = $request->input('usuario');
            //$user->password = $request->input('password');
            $user->password = bcrypt($request->input('password'));
            $user->save();
            
            return response()->json(['message' => 'Usuario creado correctamente','response'=>$user], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idUser)
    {
        try {
            $user = UserModel::with(['profile', 'profile.rol', 'profile.state'])->where('idUser', $idUser)->first();
            // Verificar si se encontro un usuario con el correo electronico dado
            if ($user) {
                return response()->json($user);
            } else {
                return response()->json(['message' => 'El usuario no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserModel $userModel, $idUser)
    {
        try {
            // Verificar si el usuario existe
            $user = $userModel->findOrFail($idUser);

            // Validar los campos del formulario
            $request->validate([
                'usuario' => 'required|unique:user,usuario,' . $idUser . ',idUser',
                'password' => 'required',
            ]);

            // Actualizar los campos del usuario
            $user->usuario = $request->input('usuario');
            //$user->password = $request->input('password');
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El usuario no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserModel $userModel, $idUser)
    {
        try {
            // Verificar si el usuario existe
            $user = $userModel->findOrFail($idUser);

            // Eliminar el usuario
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El usuario no existe'], 400);
        }
    }
}