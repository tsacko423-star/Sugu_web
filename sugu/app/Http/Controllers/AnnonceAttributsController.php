<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnonceAttributsController extends Controller
{
    public function index()
    {
        return redirect()->route('attributs.index');
    }

    public function create()
    {
        return redirect()->route('attributs.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('attributs.index');
    }

    public function show($id)
    {
        return redirect()->route('attributs.show', $id);
    }

    public function edit($id)
    {
        return redirect()->route('attributs.edit', $id);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('attributs.index');
    }

    public function destroy($id)
    {
        return redirect()->route('attributs.index');
    }
}
