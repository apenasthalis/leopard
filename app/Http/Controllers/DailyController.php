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
    }


    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
