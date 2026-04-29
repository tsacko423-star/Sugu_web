
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <h1>
        Liste des categories
    </h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        Ajouter une categorie
    </a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $categorie )
                <tr>
                    <td>{{ $categorie->id }}</td>
                    <td>{{ $categorie->name }}</td>
                    <td>
                    <a href="#" class="btn btn-primary">modifier</a>
                    <a href="#" class="btn btn-danger">supprimer</a>
                    </td>
                </tr> 
            @endforeach      
        </tbody>
      
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
