<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class Usuario extends Model
{
    // use HasApiTokens, HasFactory;

    // protected $password = 'senha';
    // protected $email = 'login';
    protected $table = 'tb_usuario';
    public $timestamps = false;


    protected $fillable = [
        'cd_usuario',
        'cd_funcionario',
        'login',
        'senha',
        'email'
    ];


    public static function areCredentialsinvalid($usuario, $senha)
    {
        try {
            $hash1 = md5($senha);
            // $hash = password_verify($senha, $usuario['senha']);
            if ($hash1 === $usuario['senha']) {
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
  

   // try {
    //     $validatedData = $request->validate([
    //         'email' => ['required', 'string', 'email'],
    //         'password' => ['required', 'string'],
    //     ]);
    // } catch (\Illuminate\Validation\ValidationException $e) {
    //     return response()->json(['errors' => $e->errors()], 422);
    // }
    // $user = User::Where('email', $validatedData['email'])->first();

    // if (User::areCredentialsinvalid($user, $validatedData['password'])) {
    //     return response(['message' => 'Senha inválida'], 401);
    // }

    // $token = $user->createToken('token-name')->plainTextToken;

    // return response([
    //     'token' => $token,
    //     'message' => 'Login realizado com sucesso',
    // ], 200);
