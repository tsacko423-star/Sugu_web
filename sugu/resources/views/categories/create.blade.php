<x-app-layout>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <h1>
        Enregistrer une categorie
    </h1>
     <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                   
                    <div class="form-control w-full">
                        <input type="text" name="name" class="input input-bordered w-full" />
                    </div>
                    <br>

                    <div class="mt-4 flex items-center justify-end">
                       <button class="btn btn-primary" type="submit" data-bs-toggle="collapse"  aria-expanded="false" >
                            Enregistrer
                        </button> <br>
                    </div>
                    <br>
                        <a href="{{ route('categories.index') }}" class="btn btn-danger" type="button" data-bs-toggle="collapse"  aria-expanded="false" >
                            Liste des categories
                        </a> 
                </form>
</x-app-layout>