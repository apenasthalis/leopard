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
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Lcobucci\JWT\Validation\Validator;

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

        $tokenCriado = $this->createToken($usuario->cd_funcionario); 

        $tokenValidado = $this->validarToken($tokenCriado);
        return response([
            'token' => $tokenValidado,
            'user_id' => $usuario->cd_funcionario,
            'message' => 'Login realizado com sucesso',
        ], 200);
    }

    public static function createToken($userId)
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
            ->withClaim('user_id', $userId)
            ->withHeader('foo', 'bar')
            ->getToken($algorithm, $signingKey);
        return $token->toString();
    }

    public function validarToken($tokenString)
    {
        try {
            $parser = new Parser(new JoseEncoder());
            $token = $parser->parse($tokenString);

            $validator = new Validator();

            $constraints = [
                new IdentifiedBy('4f1g23a12aa'),  
                new IssuedBy('http://127.0.0.1:8000/'),  
                new PermittedFor('http://127.0.0.1:8000/'),  
            ];

            foreach ($constraints as $constraint) {
                if (!$validator->validate($token, $constraint)) {
                    throw new \Exception('Token invalid: ' . get_class($constraint));
                }
            }

            return $tokenString;
        } catch (\Exception $e) {
            return false;
        }
    }

}
