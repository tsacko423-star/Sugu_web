<x-app-layout>
    <h1>
        Modifier une catégorie
    </h1>
     <form method="POST" action="{{ route('categories.update', $category->id) }}">
                    @csrf
                    @method('PUT')
                   
                    <div class="form-control w-full">
                        <input type="text" name="name" value="{{ $category->name }}" class="input input-bordered w-full" placeholder="Nom de la catégorie" required />
                    </div>
                    <br>
                    <div class="form-control w-full">
                        <input type="text" name="icon" value="{{ $category->icon }}" class="input input-bordered w-full" placeholder="Icône Bootstrap (ex: house, car-front)" />
                    </div>
                    <br>

                    <div class="mt-4 flex items-center justify-end">
                       <button class="btn btn-primary" type="submit" data-bs-toggle="collapse"  aria-expanded="false" >
                            Modifier
                        </button> <br>
                    </div>
                    <br>
                        <a href="{{ route('categories.index') }}" class="btn btn-danger" type="button" data-bs-toggle="collapse"  aria-expanded="false" >
                            Liste des categories
                        </a> 
                </form>
</x-app-layout>