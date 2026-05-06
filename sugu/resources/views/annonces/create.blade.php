@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Créer une annonce</h2>

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

            <form action="{{ route('annonces.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre') }}" class="form-control" placeholder="Titre de l'annonce" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catégorie</label>
                    <select id="categorie_id" name="categorie_id" class="form-control" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Description détaillée">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prix</label>
                    <input type="number" name="prix" value="{{ old('prix') }}" class="form-control" step="0.01" placeholder="Prix en FCFA" required>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Attributs dynamiques</h5>
                        <button type="button" id="add-attribute" class="btn btn-sm btn-outline-primary">Ajouter un attribut</button>
                    </div>

                    <div id="attributes-container"></div>

                    @if($attributs->isEmpty())
                        <div class="alert alert-warning">
                            Aucun attribut défini. Créez d'abord des attributs dans la section <strong>Attributs</strong>.
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Créer l'annonce</button>
                    <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @php
        $attributeOptions = $attributs->map(function ($attribut) {
            return ['id' => $attribut->id, 'nom' => $attribut->nom];
        })->all();
        $oldAttributes = old('attributs', []);
    @endphp

    <div id="attributes-data"
         data-options="{{ htmlspecialchars(json_encode($attributeOptions, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') }}"
         data-old="{{ htmlspecialchars(json_encode($oldAttributes, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') }}"
         style="display: none;"></div>

    <script>
        const dataNode = document.getElementById('attributes-data');
        const attributeOptions = JSON.parse(dataNode.dataset.options || '[]');
        const oldAttributes = JSON.parse(dataNode.dataset.old || '[]');
        const attributesContainer = document.getElementById('attributes-container');
        const addAttributeButton = document.getElementById('add-attribute');
        let attributeIndex = 0;

        function createAttributeRow(selectedId = '', value = '') {
            const row = document.createElement('div');
            row.className = 'row mb-3 align-items-end';

            const options = ['<option value="">Sélectionnez un attribut</option>']
                .concat(attributeOptions.map(attr => `<option value="${attr.id}">${attr.nom}</option>`))
                .join('');

            row.innerHTML = `
                <div class="col-md-5">
                    <label class="form-label">Attribut</label>
                    <select name="attributs[${attributeIndex}][id]" class="form-control" required>
                        ${options}
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Valeur</label>
                    <input type="text" name="attributs[${attributeIndex}][valeur]" value="${value}" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger w-100 remove-attribute">Supprimer</button>
                </div>
            `;

            const select = row.querySelector('select');
            if (selectedId) {
                select.value = selectedId;
            }

            row.querySelector('.remove-attribute').addEventListener('click', () => {
                row.remove();
            });

            attributesContainer.appendChild(row);
            attributeIndex++;
        }

        addAttributeButton.addEventListener('click', () => {
            createAttributeRow();
        });

        if (oldAttributes.length > 0) {
            oldAttributes.forEach(attribut => {
                createAttributeRow(attribut.id || '', attribut.valeur || '');
            });
        }
    </script>
@endpush