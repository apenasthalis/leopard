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
use Lcobucci\Clock\FrozenClock;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Validation\Constraint;
class LoginController extends Controller
{

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
        // $tokenValidado = $this->validateToken($tokenCriado);
        return response([
            'token' => $tokenCriado,
            'message' => 'Login realizado com sucesso',
        ], 200);
    }

    public static function createToken()
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

    // public function validateToken($tokenString)
    // {
    //     $jwt = $tokenString;
    //     $now = new DateTimeImmutable();

    //     $key = InMemory::base64Encoded(
    //         'segredosegredosegredosegredosegredosegredosegredo'
    //     );

    //     $token = (new JwtFacade())->parse(
    //         $jwt,
    //         new Constraint\SignedWith(new Sha256(), $key),
    //         new Constraint\StrictValidAt(new FrozenClock($now)));


    //     if ($token->claims()->get('exp') < $now->getTimestamp()) {
    //         // Token expirou
    //         return ['error' => 'Token expirado.'];
    //     } else {
    //         // Token é válido
    //         return $token->claims()->all();
    //     }

    // }
}
