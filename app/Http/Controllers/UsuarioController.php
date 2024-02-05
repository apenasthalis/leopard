<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;
use DateTimeImmutable;
use Illuminate\Validation\ValidationData;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }


    function logar(Request $request)
    {



        $usuario = Usuario::where('login', $request['login'])
        ->first();



        try {
            $validatedData = $request->validate([
                'login' => ['required'],
                'senha' => ['required']
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        if (!Usuario::areCredentialsinvalid($usuario, $validatedData['senha'])) {
            return response(['message' => 'Errou!!!!'], 401);
        }

        $tokenCriado = $this->createToken();
        return response([
            'token' => $tokenCriado,
            'message' => 'Login realizado com sucesso',
        ], 200);

    }

    public function createToken()
    {
        $tokenBuilder = new Builder(new JoseEncoder(), ChainedFormatter::default());
        $algorithm = new Sha256();
        $signingKey = InMemory::plainText('segredosegredosegredosegredosegredosegredosegredo');
        $now   = new DateTimeImmutable();
        $token = $tokenBuilder
            ->issuedBy('http://127.0.0.1:8000/')
            ->permittedFor('http://127.0.0.1:8000/')
            ->identifiedBy('4f1g23a12aa')
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            ->expiresAt($now->modify('+1 hour'))
            ->withHeader('foo', 'bar')
            ->getToken($algorithm, $signingKey);

      

        return $token->toString();
    }


    // public function handle(Request $request, Closure $next)
    // {
    //     $token = $request->bearerToken();

    //     if (!$token) {
    //         return response()->json(['error' => 'Token não fornecido'], 401);
    //     }

    //     $signer = new Sha256();

    //     try {
    //         $parsedToken = (new Parser())->parse((string) $token);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Token inválido'], 401);
    //     }

    //     // Adicione aqui suas regras de validação personalizadas
    //     $validationData = new ValidationData();
    //     $validationData->setIssuer('http://127.0.0.1:8000/'); // Substitua com o emissor do seu token

    //     if (!$parsedToken->validate($validationData) || !$parsedToken->verify($signer, 'segredosegredosegredosegredosegredosegredosegredo')) {
    //         return response()->json(['error' => 'Token inválido'], 401);
    //     }

    //     // Adicione o token decodificado à requisição, se necessário
    //     $request->attributes->add(['token' => $parsedToken]);

    //     return $next($request);
    // }


    public function show(string $id)
    {
   
    }



    public function update(Request $request, $id)
    {
        $data = [
            
            'cd_usuario' => $request->cd_usuario,
            'login' => $request->login,
            'senha' => $request->senha,
            'email' => $request->email
        ];
        
        // dd($id);


        Usuario::where('cd_usuario', $id)->update($data);

    }

    public function destroy($id)
    {

        Usuario::where('cd_usuario', $id)->dalete();
    }
}


