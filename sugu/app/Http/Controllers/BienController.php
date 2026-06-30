<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;

class BienController extends Controller
{
    public function index()
    {
        $biens = Bien::with('user')->latest()->get();

        return view('bien.index', compact('biens'));
    }

    public function create()
    {
        return view('bien.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['image'] = $this->storeImages($request);
        unset($validated['images']);

        Bien::create($validated);

        return redirect()->route('biens.index')->with('success', 'Bien cree avec succes.');
    }

    public function show($id)
    {
        $bien = Bien::with('user')->findOrFail($id);

        return view('bien.show', compact('bien'));
    }

    public function edit($id)
    {
        $bien = Bien::findOrFail($id);

        return view('bien.edit', compact('bien'));
    }

    public function update(Request $request, $id)
    {
        $bien = Bien::findOrFail($id);
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ]);

        $newImages = $this->storeImages($request);
        $validated['image'] = array_values(array_filter(array_merge($bien->image ?? [], $newImages)));
        unset($validated['images']);

        $bien->update($validated);

        return redirect()->route('biens.index')->with('success', 'Bien modifie avec succes.');
    }

    public function destroy($id)
    {
        Bien::findOrFail($id)->delete();

        return redirect()->route('biens.index')->with('success', 'Bien supprime avec succes.');
    }

    private function storeImages(Request $request): array
    {
        if (!$request->hasFile('images')) {
            return [];
        }

        return collect($request->file('images'))
            ->map(fn ($image) => $image->store('biens', 'public'))
            ->all();
    }
}
