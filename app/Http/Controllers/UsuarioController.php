<?php

namespace App\Http\Controllers;

use App\Models\CargaHorariaFuncionario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }


    public function store(Request $request)
    {
        Usuario::create($request->all());
    }

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


