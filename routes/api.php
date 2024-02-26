<?php

use App\Http\Controllers\BancoDeHorasController;
use App\Http\Controllers\CargaHorariaFuncionarioController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\FeriadoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\JustificativaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware('jwt.auth')->group(function(){

});

Route::get('/usuario', [UsuarioController::class, 'index']);
Route::delete('/usuario', [UsuarioController::class, 'destroy']);



//login -------->
Route::post('/login', [LoginController::class, 'logar']);

Route::get('/storage/{caminho}', function ($caminho) {
    $path = storage_path("app/public/{$caminho}");

    if (!Storage::exists("public/{$caminho}")) {
        abort(404);
    }

    return response()->file($path);
})->where('caminho', '.*');
    
//funcionario ------> 
Route::get('/funcionario', [FuncionarioController::class, 'index']);
Route::get('/funcionario/{id}', [FuncionarioController::class, 'show']);
Route::post('/funcionario', [FuncionarioController::class, 'store']);  
Route::put('/funcionario/{id}', [FuncionarioController::class, 'destroy']);

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
Route::get('/bancodehoras/{id}', [BancoDeHorasController::class, 'show']);

 
//daily ----------> 
Route::get('/daily', [DailyController::class, 'index']);
Route::get('/daily/{id}', [DailyController::class, 'show']);
Route::post('/daily', [DailyController::class, 'store']);
   
//carga horaria funcionario
Route::get('/cargahorariafuncionario', [CargaHorariaFuncionarioController::class, 'index']);
Route::post('/cargahorariafuncionario', [CargaHorariaFuncionarioController::class, 'store']);
Route::put('/cargahorariafuncionario', [CargaHorariaFuncionarioController::class, 'update']);
Route::get('/cargahorariafuncionario/{id}/{ano}/{mes}', [CargaHorariaFuncionarioController::class, 'show']);


//admin 
 


Route::get('/', function(){
    return response()->json([
        'sucess' => true
    ]);
});




// $boAdm = false;
// $chaveSecreta = 'segredosegredosegredosegredosegredosegredosegredo';
// $agora = time();
// $tokenPayload = [
//     'iss' => 'http://localhost/',  // Emissor
//     'aud' => 'http://localhost/',  // Público permitido
//     'iat' => $agora,                // Emitido em
//     'nbf' => $agora + 60,           // Não antes de
//     'exp' => $agora + 3600,         // Expira em 1 hora
//     'isAdmin' => $boAdm,
// ];

// $token = JWT::encode($tokenPayload, $chaveSecreta, 'HS256');

// return $token;