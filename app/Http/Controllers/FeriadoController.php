<?php

namespace App\Http\Controllers;

use App\Models\Feriado;
use Illuminate\Http\Request;

class FeriadoController extends Controller
{
    public function index()
    {
        return Feriado::all();

    }


    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }


    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
