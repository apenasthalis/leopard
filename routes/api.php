<?php

use App\Http\Controllers\BancoDeHorasController;
use App\Http\Controllers\CargaHorariaFuncionarioController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\FeriadoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\JustificativaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//usuario -------->
Route::get('/usuario', [UsuarioController::class, 'index']);
Route::post('/usuario', [UsuarioController::class, 'store']);   
    
//funcionario ------> 
Route::get('/funcionario', [FuncionarioController::class, 'index']);
Route::post('/funcionario', [FuncionarioController::class, 'store']);  
Route::put('/funcionario', [FuncionarioController::class, 'update']);
Route::delete('/funcionario', [FuncionarioController::class, 'destroy']);

//justificativa ---->
Route::get('/justificativa', [JustificativaController::class, 'index']);
Route::post('/justificativa', [JustificativaController::class, 'store']);
Route::put('/justificativa', [JustificativaController::class, 'update']);


//feriado --------> 
Route::get('/feriado', [FeriadoController::class, 'index']);
Route::post('/feriado', [FeriadoController::class, 'store']);
Route::put('/feriado', [FeriadoController::class, 'update']);
Route::delete('/feriado', [FeriadoController::class, 'destroy']);

//Banco De Horas ---------->
Route::get('/bancodehoras', [BancoDeHorasController::class, 'index']);
Route::post('/bancodehoras', [BancoDeHorasController::class, 'store']);
Route::put('/bancodehoras', [BancoDeHorasController::class, 'update']);
 
//daily ----------> 
Route::get('/daily', [DailyController::class, 'index']);
Route::post('/daily', [DailyController::class, 'store']);
   
//carga horaria funcionario
Route::get('/cargahorariafuncionario', [CargaHorariaFuncionarioController::class, 'index']);
Route::post('/cargahorariafuncionario', [CargaHorariaFuncionarioController::class, 'store']);
Route::put('/cargahorariafuncionario', [CargaHorariaFuncionarioController::class, 'update']);
Route::get('/cargahorariafuncionario/{id}', [CargaHorariaFuncionarioController::class, 'show']);


//admin 



Route::get('/', function(){
    return response()->json([
        'sucess' => true
    ]);
});