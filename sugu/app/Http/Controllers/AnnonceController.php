<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\AnnonceAttribut;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $annonces = Annonce::with(['categorie', 'user'])
            ->when(Auth::check() && ! $this->isAdmin(Auth::user()), function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('annonces.index', compact('categories', 'annonces'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('annonces.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'images' => ['required', 'array', 'max:5'],
            'images.*' => ['image', 'max:5120'],
            'attributs.nom' => ['nullable', 'array'],
            'attributs.nom.*' => ['nullable', 'string', 'max:255'],
            'attributs.valeur' => ['nullable', 'array'],
            'attributs.valeur.*' => ['nullable', 'string', 'max:255'],
        ]);

        $annonce = Annonce::create([
            'user_id' => $request->user()->id,
            'categorie_id' => $validated['categorie_id'],
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'prix' => $validated['prix'],
            'images' => $this->storeImages($request),
        ]);

        $this->syncAttributs($annonce, $request);

        return redirect()->route('annonces.index')->with('success', 'Annonce creee avec succes.');
    }

    public function show($id)
    {
        $annonce = Annonce::with(['categorie', 'user', 'annonceAttributs'])->findOrFail($id);
        $this->authorizeAnnonceAccess($annonce);

        return view('annonces.show', compact('annonce'));
    }

    public function edit($id)
    {
        $annonce = Annonce::with('annonceAttributs')->findOrFail($id);
        $this->authorizeAnnonceAccess($annonce);
        $categories = Category::all();

        return view('annonces.edit', compact('annonce', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        $this->authorizeAnnonceAccess($annonce);

        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'attributs.nom' => ['nullable', 'array'],
            'attributs.nom.*' => ['nullable', 'string', 'max:255'],
            'attributs.valeur' => ['nullable', 'array'],
            'attributs.valeur.*' => ['nullable', 'string', 'max:255'],
        ]);

        $annonce->update([
            'categorie_id' => $validated['categorie_id'],
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'prix' => $validated['prix'],
        ]);

        $this->syncAttributs($annonce, $request);

        return redirect()->route('annonces.index')->with('success', 'Annonce modifiee avec succes.');
    }

    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);
        $this->authorizeAnnonceAccess($annonce);
        $annonce->delete();

        return redirect()->route('annonces.index')->with('success', 'Annonce supprimee avec succes.');
    }

    public function search(Request $request)
    {
        $categories = Category::all();
        $query = Annonce::with(['categorie', 'user'])->latest();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('titre', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $annonces = $query->get();

        return view('home', compact('categories', 'annonces'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::all();
        $annonces = Annonce::with(['categorie', 'user'])
            ->where('categorie_id', $category->id)
            ->latest()
            ->get();

        return view('home', compact('categories', 'annonces', 'category'));
    }

    private function storeImages(Request $request): array
    {
        if (!$request->hasFile('images')) {
            return [];
        }

        return collect($request->file('images'))
            ->map(fn ($image) => $image->store('annonces', 'public'))
            ->all();
    }

    private function syncAttributs(Annonce $annonce, Request $request): void
    {
        $noms = $request->input('attributs.nom', []);
        $valeurs = $request->input('attributs.valeur', []);

        $annonce->annonceAttributs()->delete();

        foreach ($noms as $index => $nom) {
            $valeur = $valeurs[$index] ?? null;

            if (!$nom || !$valeur) {
                continue;
            }

            AnnonceAttribut::create([
                'annonce_id' => $annonce->id,
                'nom' => $nom,
                'valeur' => $valeur,
            ]);
        }
    }

    private function authorizeAnnonceAccess(Annonce $annonce): void
    {
        if (! Auth::check()) {
            return;
        }

        if ($this->isAdmin(Auth::user())) {
            return;
        }

        abort_unless((int) $annonce->user_id === (int) Auth::id(), 403, 'Acces refuse');
    }

    private function isAdmin($user): bool
    {
        return (bool) ($user->is_admin ?? false)
            || (bool) ($user->is_super_admin ?? false)
            || $user->role === 'admin';
    }
}
