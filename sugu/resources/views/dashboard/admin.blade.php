
<h1>🔥 Dashboard Admin</h1>

<div style="display:flex; gap:20px;">
    <div style="padding:20px; background:#eee;">
        <h3>Total utilisateurs</h3>
        <p>{{ $users }}</p>
    </div>

    <div style="padding:20px; background:#eee;">
        <h3>Total annonces</h3>
        <p>{{ $annonces->count() }}</p>
    </div>
</div>

<hr>

<h2>📢 Toutes les annonces</h2>

@foreach($annonces as $annonce)
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <h3>{{ $annonce->titre }}</h3>

        <p>👤 {{ $annonce->user->name }}</p>
        <p>💰 {{ $annonce->prix }} FCFA</p>

        <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button style="color:red;">Supprimer</button>
        </form>
    </div>
@endforeach