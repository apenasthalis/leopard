<?php

namespace App\Http\Controllers;

use App\Models\Justificativa;
use Illuminate\Http\Request;

class JustificativaController extends Controller
{
    public function index()
    {
        return Justificativa::all();

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
