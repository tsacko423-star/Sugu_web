<h1>👤 Mon Dashboard </h1>

<a href="{{ route('annonces.create') }}">➕ Ajouter une annonce</a>

<hr>

<h2>📦 Mes annonces</h2>

@foreach($annonces as $annonce)
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <h3>{{ $annonce->titre }}</h3>
        <p>{{ $annonce->prix }} FCFA</p>

        <a href="{{ route('annonces.edit', $annonce->id) }}">✏️ Modifier</a>

        <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Supprimer ?')">🗑 Supprimer</button>
        </form>
    </div>
@endforeach