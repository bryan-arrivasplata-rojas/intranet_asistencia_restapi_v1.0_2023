<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentUserController;
use App\Http\Controllers\AssistanceController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('user/login/{usuario}', [UserController::class, 'login']);
Route::get('user/byarea/{idArea}', [UserController::class, 'usersByArea']);
Route::get('user/bydepartment/{idDepartment}', [UserController::class, 'usersByDepartment']);
Route::get('user/available', [UserController::class, 'userAvailable']);
Route::get('user/available/{idProfile}', [UserController::class, 'userAvailableByIdProfile']);
Route::get('user/available_department_user', [UserController::class, 'userAvailableDepartmentUser']);
Route::get('user/available_department_user/{idDepartmentUser}', [UserController::class, 'userAvailableDepartmentUserByIdDepartmentUser']);
Route::get('user/state/{usuario}', [UserController::class, 'userState']);
Route::get('user/service/{idUser}', [UserController::class, 'userService']);
Route::apiResource('user',UserController::class);
Route::apiResource('type',TypeController::class);
Route::apiResource('time',TimeController::class);
Route::apiResource('state',StateController::class);
Route::apiResource('service',ServiceController::class);
Route::apiResource('rol',RolController::class);
Route::apiResource('area',AreaController::class);
Route::apiResource('department',DepartmentController::class);
//Route::get('department/byusers/{idDepartment}', [DepartmentController::class, 'usersByDepartment']);

Route::post('profile/{idProfile}', [ProfileController::class, 'update']);
Route::apiResource('profile',ProfileController::class)->except(['update']);
Route::get('profile/search/{idRol}&{idState}', [ProfileController::class, 'search']);

Route::apiResource('department_user',DepartmentUserController::class);
//Route::get('assistance/all', [AssistanceController::class, 'assistancesAll']);
Route::get('assistance/byuser/{idUser}', [AssistanceController::class, 'assistancesByUser']);
Route::get('assistance/today', [AssistanceController::class, 'indexToday']);
Route::get('assistance/detailsbyuser/{idUser}/{start_date}/{end_date}', [AssistanceController::class, 'assistancesDetailsByUser']);
//http://127.0.0.1:8000/api/assistance/detailsbyuser/6/2023-08-25/2023-08-26
Route::apiResource('assistance',AssistanceController::class);

Route::match(['put', 'delete'], '{resource}', function ($resource) {
    return response()->json(['message' => 'Debe especificar un ID para continuar con ' . $resource], 400);
})->where('resource', 'user|type|time|state|service|rol|area|department|profile|department_user|assistance')->fallback();
