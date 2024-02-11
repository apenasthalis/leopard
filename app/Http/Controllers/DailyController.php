<?php

namespace App\Http\Controllers;

use App\Models\Daily;
use Illuminate\Http\Request;

class DailyController extends Controller
{
    public function index()
    {
        return Daily::all();
    }

    public function store(Request $request)
    {
        Daily::create($request->all());
    }

    public function show(string $id)
    {
        return Daily::where('id_employee', $id)->get();
    }


    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
