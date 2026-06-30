<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use Illuminate\Http\Request;

class VoitureController extends Controller
{
    public function index()
    {
        $voitures = Voiture::with('user')->latest()->get();

        return view('voitures.index', compact('voitures'));
    }

    public function create()
    {
        return view('voitures.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'marque' => ['required', 'string', 'max:255'],
            'modele' => ['required', 'string', 'max:255'],
            'annee' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'prix' => ['required', 'numeric', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['image'] = $this->storeImages($request);
        unset($validated['images']);

        Voiture::create($validated);

        return redirect()->route('voitures.index')->with('success', 'Voiture creee avec succes.');
    }

    public function show($id)
    {
        $voiture = Voiture::with('user')->findOrFail($id);

        return view('voitures.show', compact('voiture'));
    }

    public function edit($id)
    {
        $voiture = Voiture::findOrFail($id);

        return view('voitures.edit', compact('voiture'));
    }

    public function update(Request $request, $id)
    {
        $voiture = Voiture::findOrFail($id);
        $validated = $request->validate([
            'marque' => ['required', 'string', 'max:255'],
            'modele' => ['required', 'string', 'max:255'],
            'annee' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'prix' => ['required', 'numeric', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ]);

        $newImages = $this->storeImages($request);
        $validated['image'] = array_values(array_filter(array_merge($voiture->image ?? [], $newImages)));
        unset($validated['images']);

        $voiture->update($validated);

        return redirect()->route('voitures.index')->with('success', 'Voiture modifiee avec succes.');
    }

    public function destroy($id)
    {
        Voiture::findOrFail($id)->delete();

        return redirect()->route('voitures.index')->with('success', 'Voiture supprimee avec succes.');
    }

    private function storeImages(Request $request): array
    {
        if (!$request->hasFile('images')) {
            return [];
        }

        return collect($request->file('images'))
            ->map(fn ($image) => $image->store('voitures', 'public'))
            ->all();
    }
}
