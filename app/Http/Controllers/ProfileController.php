<?php

namespace App\Http\Controllers;

use App\Models\ProfileModel;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $profiles = ProfileModel::with('user','rol','state')->orderBy('name_profile','asc')->get();
            return response()->json($profiles);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos'], 500);
        }
    }
    public function search($idRol,$idState)
    {
        try {
            // Iniciar la consulta con todos los registros
            $query = ProfileModel::with('user','rol','state')->orderBy('name_profile', 'asc');

            // Aplicar filtros según los valores recibidos
            if ($idRol>-1) {
                $query->where('idRol', $idRol);
            }
            if($idState>-1){
                $query->where('idState', $idState);
            }

            // Obtener los registros filtrados
            $profiles = $query->get();
            return response()->json($profiles);
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
            $name_image = null;
            // Validar campos
            $request->validate([
                'idUser' => 'required|unique:profile,idUser'
            ]);
            $userController  = new UserController();
            $userResponse = $userController->show($request->input('idUser'));
            $profile_path = 'images_profile/';
            $extension = '.png';
            if ($userResponse->getStatusCode() == 200) {
                $user = $userResponse ->getOriginalContent();
                if(isset($user->usuario)){
                    $usuario = $user->usuario;
                    $name_image = $usuario.$extension;
                    $image_path = $profile_path.$name_image;
                    $image_path_default = $profile_path.'default'.$extension;

                    if ($request->hasFile('image')) {
                        $image = $request->file('image');
                        if ($image->move(public_path($profile_path), $usuario.$extension)){
                            $name_image = $image_path;
                        }else{
                            return response()->json(['message' => 'Error de servidor'], 500);
                        }
                    }else{
                        $name_image = $image_path_default;
                    }
                }else{
                    return response()->json(['message' => 'No se cuenta con el usuario solicitado'], 400);
                }
            }else{
                return response()->json(['message' => 'Problemas con encontrar el usuario'], 400);
            }
            
            // Crear nuevo profile
            $profile = new ProfileModel();
            $profile->name_profile = $request->input('name_profile');
            $profile->lastname = $request->input('lastname');
            $profile->email = $request->input('email');
            $profile->image = $name_image;
            $profile->idState = $request->input('idState');
            $profile->idUser = $request->input('idUser');
            $profile->idRol = $request->input('idRol');
            $profile->save();
            
            return response()->json(['message' => 'Perfil creado correctamente','response'=>$profile], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idProfile)
    {
        try {
            $profile = ProfileModel::with('user','rol','state')->where('idProfile', $idProfile)->first();
            // Verificar si se encontro
            if ($profile) {
                return response()->json($profile);
            } else {
                return response()->json(['message' => 'El perfil no existe'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfileModel $profileModel, $idProfile)
    {
        try {
            $profile = $profileModel->findOrFail($idProfile);
            $userController  = new UserController();
            $userResponse_actual = $userController->show($profile->idUser);
            $user_actual = $userResponse_actual->getOriginalContent();
            $profile_path = 'images_profile/';
            $extension = '.png';
            if ($userResponse_actual->getStatusCode() == 200) {
                if(isset($user_actual->usuario)){
                    $usuario_actual = $user_actual->usuario;
                    $name_image_nuevo = $usuario_actual.$extension;
                    $image_path_nuevo = $profile_path.$name_image_nuevo;
                    $image_path_default = $profile_path.'default'.$extension;
                    
                    $ruta_actual = public_path($profile->image);
                    $ruta_nueva = public_path($image_path_nuevo);
                    $request->validate([
                        'idUser' => [
                            'required',
                            Rule::unique('profile')->ignore($idProfile, 'idProfile'),
                        ]
                    ]);
                    if ($request->hasFile('image')) {
                        $image = $request->file('image');
                        if ($profile->image != $image_path_default){  
                            if (file_exists($ruta_actual)) {
                                if(!unlink($ruta_actual)){
                                    return response()->json(['message' => 'Error de servidor'], 500);
                                }
                            }
                        }
                        if(!$image->move(public_path($profile_path), $name_image_nuevo)){
                            return response()->json(['message' => 'Error de servidor'], 500);
                        }
                        $profile->image = $image_path_nuevo;
                    }
                    $profile->name_profile = $request->input('name_profile');
                    $profile->lastname = $request->input('lastname');
                    $profile->email = $request->input('email');
                    $profile->idState = $request->input('idState');
                    $profile->idUser = $request->input('idUser');
                    $profile->idRol = $request->input('idRol');
                    $profile->save();
                    return response()->json($profile);
                }else{
                    return response()->json(['message' => 'No cuenta con usuario'], 400);
                }
            }else{
                return response()->json(['message' => 'Problemas con encontrar el usuario'], 400);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'El profile no existe'], 400);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfileModel $profileModel, $idProfile)
    {
        try {
            // Verificar si existe
            $profile = $profileModel->findOrFail($idProfile);
            $profile_path = 'images_profile/';
            $extension = '.png';
            $image_path_default = $profile_path.'default'.$extension;

            $ruta_actual = public_path($profile->image);

            if ($profile->image != $image_path_default){
                if (file_exists($ruta_actual)) {
                    if(!unlink($ruta_actual)){
                        return response()->json(['error'=>'Detección de error','message' => 'Error de servidor'], 500);
                    }
                }
            }
            // Eliminar
            $profile->delete();
            return response()->json(['message' => 'Profile eliminado correctamente']);
        } catch (QueryException $e) {
            return response()->json(['error'=>'Detección de error','message' => 'Error de conexion a la base de datos: '.$e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Detección de error','message' => 'El profile no existe'], 400);
        }
    }
}