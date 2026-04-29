<x-app-layout>
    <main>
    <h1>Créer un emploi</h1>
    <form action="{{ route('emplois.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="titre">Titre:</label>
            <input type="text" name="titre" id="titre" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>
        </div>
        <div>
            <label for="salaire">Salaire:</label>
            <input type="number" name="salaire" id="salaire" step="0.01" required>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" name="image" id="image">
        </div>
        <button type="submit">Créer</button>
    </form>
    </main>
</x-app-layout>