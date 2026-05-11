<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une annonce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }
        
        .image-preview {
            position: relative;
            width: 100px;
            height: 100px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .image-preview .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 4px;
            width: 25px;
            height: 25px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
        }
        
        .image-preview .remove-btn:hover {
            background: rgba(220, 53, 69, 1);
        }
        
        .upload-area {
            border: 2px dashed #007bff;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            background: #f0f7ff;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .upload-area:hover {
            border-color: #0056b3;
            background: #e7f1ff;
        }
        
        .upload-area.dragover {
            border-color: #0056b3;
            background: #e7f1ff;
        }
        
        #images {
            display: none;
        }
    </style>
</head>
<body class="bg-light">

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

        <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" value="{{ old('titre') }}" class="form-control" placeholder="Titre de l'annonce" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="categorie_id" class="form-control" required>
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
                <label class="form-label d-block mb-2">Photos de l'article <span class="text-muted">(jusqu'à 5 photos)</span></label>
                
                <div class="upload-area" id="uploadArea">
                    <i class="bi bi-cloud-arrow-up" style="font-size: 2rem; color: #007bff;"></i>
                    <p class="mt-3 mb-0">
                        <strong>Cliquez ou déposez vos photos</strong><br>
                        <small class="text-muted">JPG, PNG jusqu'à 5 MB par photo</small>
                    </p>
                </div>
                
                <input type="file" id="images" name="images[]" multiple accept="image/*" required>
                
                <div class="image-preview-container" id="previewContainer"></div>
                <small class="text-muted d-block mt-2">
                    <span id="imageCount">0</span> image(s) sélectionnée(s)
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Attributs supplémentaires</label>
                <div id="attributs-container">
                    <!-- Les champs d'attributs seront ajoutés ici dynamiquement -->
                </div>
                <button type="button" class="btn btn-secondary mt-2" id="add-attribut">Ajouter un attribut</button>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Créer l'annonce</button>
                <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('images');
    const previewContainer = document.getElementById('previewContainer');
    const imageCount = document.getElementById('imageCount');
    const maxImages = 5;
    let selectedFiles = [];

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = Array.from(e.dataTransfer.files);
        handleFiles(files);
    });

    // Click to select files
    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        handleFiles(files);
    });

    function handleFiles(files) {
        const newFiles = files.filter(file => file.type.startsWith('image/'));
        
        if (newFiles.length + selectedFiles.length > maxImages) {
            alert(`Maximum ${maxImages} images autorisées`);
            return;
        }

        selectedFiles = [...selectedFiles, ...newFiles];
        updatePreview();
    }

    function updatePreview() {
        previewContainer.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'image-preview';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Aperçu ${index + 1}">
                    <button type="button" class="remove-btn" onclick="removeImage(${index})" title="Supprimer">
                        ×
                    </button>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        imageCount.textContent = selectedFiles.length;
        
        // Update file input
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    function removeImage(index) {
        selectedFiles.splice(index, 1);
        updatePreview();
    }

    // Attributs dynamiques
    document.getElementById('add-attribut').addEventListener('click', function() {
        const container = document.getElementById('attributs-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" name="attributs[nom][]" class="form-control" placeholder="Nom de l'attribut" required>
            <input type="text" name="attributs[valeur][]" class="form-control" placeholder="Valeur" required>
            <button type="button" class="btn btn-danger remove-attribut">Supprimer</button>
        `;
        container.appendChild(div);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-attribut')) {
            e.target.parentElement.remove();
        }
    });
</script>

</body>
</html>