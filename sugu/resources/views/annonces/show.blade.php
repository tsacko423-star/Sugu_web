@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="card">
        <div class="card-header bg-secondary-bg border-0">
            <h2 class="mb-0">{{ $annonce->titre }}</h2>
        </div>
        <div class="card-body">
            <div class="row gy-4">
                <div class="col-md-8">
                    <h5 class="text-secondary">Description</h5>
                    <p class="card-text text-secondary">{{ $annonce->description }}</p>

                    <h5 class="text-secondary mt-4">Prix</h5>
                    <p class="h4 text-primary">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</p>

                    <h5 class="text-secondary mt-4">Catégorie</h5>
                    <p><span class="badge bg-secondary">{{ $annonce->categorie->name }}</span></p>

                    @if($annonce->annonceAttributs->count() > 0)
                        <h5 class="text-secondary mt-4">Attributs</h5>
                        <ul class="list-group list-group-flush mb-0">
                            @foreach($annonce->annonceAttributs as $attribut)
                                <li class="list-group-item d-flex justify-content-between bg-secondary-bg border-0 px-0 py-2">
                                    <strong>{{ $attribut->nom }}:</strong>
                                    <span>{{ $attribut->valeur }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <h5 class="text-secondary mt-4">Publié par</h5>
                    <p class="text-secondary">{{ $annonce->user->name }}</p>

                    <h5 class="text-secondary mt-4">Date de publication</h5>
                    <p class="text-secondary">{{ $annonce->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="col-md-4">
                    <div class="d-grid gap-3">
                        <a href="{{ route('annonces.edit', $annonce->id) }}" class="btn btn-luxe">Modifier</a>

                        <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-dark w-100">Supprimer</button>
                        </form>

                        <a href="{{ route('annonces.index') }}" class="btn btn-outline-dark w-100">Retour à la liste</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($annonce->attributs->count() > 0)
        <div class="card mt-4">
            <div class="card-header bg-secondary-bg border-0">
                <h5 class="mb-0">Caractéristiques supplémentaires</h5>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    @foreach($annonce->attributs as $attribut)
                        <div class="col-md-6">
                            <div class="bg-accent p-3 rounded-3">
                                <strong>{{ $attribut->nom }}:</strong>
                                <p class="mb-0 text-secondary">{{ $attribut->valeur }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
