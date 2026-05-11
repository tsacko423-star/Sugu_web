@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="card p-4">
        <div class="mb-4">
            <h2 class="h3">Modifier l'annonce</h2>
            <p class="text-secondary">Mettez à jour les informations de votre annonce.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('annonces.update', $annonce->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" value="{{ old('titre', $annonce->titre) }}" class="form-control" placeholder="Titre de l'annonce" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="categorie_id" class="form-select" required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories ?? [] as $categorie)
                        <option value="{{ $categorie->id }}" {{ old('categorie_id', $annonce->categorie_id) == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Description détaillée">{{ old('description', $annonce->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Prix</label>
                <input type="number" name="prix" value="{{ old('prix', $annonce->prix) }}" class="form-control" step="0.01" placeholder="Prix en FCFA" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Attributs supplémentaires</label>
                <div id="attributs-container">
                    @foreach($annonce->annonceAttributs as $attribut)
                        <div class="input-group mb-3">
                            <input type="text" name="attributs[nom][]" value="{{ $attribut->nom }}" class="form-control" placeholder="Nom de l'attribut" required>
                            <input type="text" name="attributs[valeur][]" value="{{ $attribut->valeur }}" class="form-control" placeholder="Valeur" required>
                            <button type="button" class="btn btn-outline-dark remove-attribut">Supprimer</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-dark mt-2" id="add-attribut">Ajouter un attribut</button>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-luxe">Modifier l'annonce</button>
                <a href="{{ route('annonces.index') }}" class="btn btn-outline-dark">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('add-attribut').addEventListener('click', function() {
        const container = document.getElementById('attributs-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-3';
        div.innerHTML = `
            <input type="text" name="attributs[nom][]" class="form-control" placeholder="Nom de l'attribut" required>
            <input type="text" name="attributs[valeur][]" class="form-control" placeholder="Valeur" required>
            <button type="button" class="btn btn-outline-dark remove-attribut">Supprimer</button>
        `;
        container.appendChild(div);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-attribut')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endpush
