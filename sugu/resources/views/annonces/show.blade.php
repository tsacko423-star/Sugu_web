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
                    @php
                        $images = is_array($annonce->images) ? $annonce->images : [];
                    @endphp

                    @if(count($images) > 0)
                        <div id="annonceImagesCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                            <div class="carousel-inner rounded-3 overflow-hidden">
                                @foreach($images as $image)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image) }}"
                                             class="d-block w-100 annonce-show-image"
                                             alt="{{ $annonce->titre }} image {{ $loop->iteration }}">
                                    </div>
                                @endforeach
                            </div>

                            @if(count($images) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#annonceImagesCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Image precedente</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#annonceImagesCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Image suivante</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="annonce-show-placeholder mb-4">
                            <i class="bi bi-{{ $annonce->categorie->icon ?? 'tag' }}"></i>
                        </div>
                    @endif

                    <h5 class="text-secondary">Description</h5>
                    <p class="card-text text-secondary">
                        {{ $annonce->description }}
                    </p>

                    <h5 class="text-secondary mt-4">Prix</h5>
                    <p class="h4 text-primary">
                        {{ number_format($annonce->prix, 0, ',', ' ') }} FCFA
                    </p>

                    <h5 class="text-secondary mt-4">Catégorie</h5>
                    <p>
                        <span class="badge bg-secondary">
                            {{ $annonce->categorie->name }}
                        </span>
                    </p>

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
                    <p class="text-secondary">
                        {{ $annonce->user->name }}
                    </p>

                    <h5 class="text-secondary mt-4">Date de publication</h5>
                    <p class="text-secondary">
                        {{ $annonce->created_at->format('d/m/Y à H:i') }}
                    </p>

                </div>

                <div class="col-md-4">

                    <div class="d-grid gap-3">

                        @auth

                            @if(auth()->id() === $annonce->user_id)

                                <a href="{{ route('annonces.edit', $annonce->id) }}"
                                   class="btn btn-luxe">

                                    Modifier

                                </a>

                                <form action="{{ route('annonces.destroy', $annonce->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-dark w-100">

                                        Supprimer

                                    </button>

                                </form>

                            @else

                                <!-- Contact vendeur utilisateur connecté -->

                                <div class="card" id="contact-vendeur">

                                    <div class="card-header">
                                        Envoyer un message au vendeur
                                    </div>

                                    <div class="card-body">

                                        <form action="{{ route('message.send') }}"
                                              method="POST">

                                            @csrf

                                            <input type="hidden"
                                                   name="receiver_id"
                                                   value="{{ $annonce->user_id }}">

                                            <div class="mb-3">

                                                <label for="contenu-connecte" class="form-label">Message</label>
                                                <textarea name="contenu"
                                                          id="contenu-connecte"
                                                          class="form-control"
                                                          rows="3"
                                                          placeholder="Votre message..."
                                                          required></textarea>

                                            </div>

                                            <button type="submit"
                                                    class="btn btn-primary w-100">

                                                Envoyer

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            @endif

                        @else

                            <!-- Contact vendeur visiteur -->

                            <div class="card" id="contact-vendeur">

                                <div class="card-header">
                                    Envoyer un message au vendeur
                                </div>

                                <div class="card-body">

                                    <form action="{{ route('message.send') }}"
                                          method="POST">

                                        @csrf

                                        <input type="hidden"
                                               name="receiver_id"
                                               value="{{ $annonce->user_id }}">

                                        <div class="mb-3">

                                            <label for="sender_name" class="form-label">Nom</label>
                                            <input type="text"
                                                   id="sender_name"
                                                   name="sender_name"
                                                   class="form-control"
                                                   placeholder="Votre nom"
                                                   required>

                                        </div>

                                        <div class="mb-3">

                                            <label for="sender_email" class="form-label">Email</label>
                                            <input type="email"
                                                   id="sender_email"
                                                   name="sender_email"
                                                   class="form-control"
                                                   placeholder="Votre email"
                                                   required>

                                        </div>

                                        <div class="mb-3">

                                            <label for="contenu-visiteur" class="form-label">Message</label>
                                            <textarea name="contenu"
                                                      id="contenu-visiteur"
                                                      class="form-control"
                                                      rows="3"
                                                      placeholder="Votre message..."
                                                      required></textarea>

                                        </div>

                                        <button type="submit"
                                                class="btn btn-primary w-100">

                                            Envoyer

                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endauth

                        <a href="{{ route('annonces.index') }}"
                           class="btn btn-outline-dark w-100">

                            Retour à la liste

                        </a>

                    </div>

                </div>

            </div>
        </div>
    </div>

    @if($annonce->attributs->count() > 0)

        <div class="card mt-4">

            <div class="card-header bg-secondary-bg border-0">

                <h5 class="mb-0">
                    Caractéristiques supplémentaires
                </h5>

            </div>

            <div class="card-body">

                <div class="row gy-3">

                    @foreach($annonce->attributs as $attribut)

                        <div class="col-md-6">

                            <div class="bg-accent p-3 rounded-3">

                                <strong>{{ $attribut->nom }}:</strong>

                                <p class="mb-0 text-secondary">
                                    {{ $attribut->valeur }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    @endif

</div>
@endsection

@push('styles')
<style>
    .annonce-show-image {
        aspect-ratio: 16 / 9;
        object-fit: cover;
        background: var(--sugu-bg-card, #111827);
    }

    .annonce-show-placeholder {
        aspect-ratio: 16 / 9;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--sugu-bg-card, #111827);
        border: 1px solid var(--sugu-border, #1f2937);
        color: var(--sugu-text-muted, #94a3b8);
    }

    .annonce-show-placeholder i {
        font-size: clamp(3rem, 8vw, 5rem);
    }
</style>
@endpush
