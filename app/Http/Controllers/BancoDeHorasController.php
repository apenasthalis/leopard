<?php

namespace App\Http\Controllers;

use App\Models\BancoDeHoras;
use Illuminate\Http\Request;

class BancoDeHorasController extends Controller
{
    public function index()
    {
        return BancoDeHoras::all();

    }


    public function store(Request $request)
    {
        BancoDeHoras::create($request->all());

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
