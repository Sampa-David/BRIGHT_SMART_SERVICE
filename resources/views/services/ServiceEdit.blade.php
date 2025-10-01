<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le service - {{config('app.name')}}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --default-font: "Roboto", system-ui, -apple-system, "Segoe UI", sans-serif;
            --heading-font: "Quicksand", sans-serif;
            --default-color: #1B1464;
            --accent-color: #FF6B00;
            --surface-color: #f9f9f9;
        }

        body {
            font-family: var(--default-font);
            background-color: var(--surface-color);
            color: var(--default-color);
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-family: var(--heading-font);
            font-weight: 700;
            color: var(--default-color) !important;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-family: var(--heading-font);
            color: var(--default-color);
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .edit-form {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .form-label {
            font-weight: 500;
            color: var(--default-color);
        }

        .form-control {
            border: 2px solid #e9ecef;
            padding: 0.75rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 0, 0.1);
        }

        .btn-primary {
            background-color: var(--default-color);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .current-image {
            max-width: 200px;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .back-link {
            color: var(--default-color);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--accent-color);
            transform: translateX(-5px);
        }

        .back-link i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('img/bright.jpg') }}" alt="Logo" style="height: 40px;" class="d-inline-block align-text-top me-2">
                Bright Smart Services
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="mb-4">
            <a href="{{ route('services.manage') }}" class="back-link">
                <i class="bi bi-arrow-left"></i>
                Retour à la liste
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title">
                    <h2>Modifier le service</h2>
                    <p>Mettez à jour les informations du service</p>
                </div>

                <div class="edit-form">
                    <form action="{{ route('services.ServiceUpdate', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label">Nom du service</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $service->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Image actuelle</label>
                            <div>
                                <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="current-image">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Nouvelle image (optionnel)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>