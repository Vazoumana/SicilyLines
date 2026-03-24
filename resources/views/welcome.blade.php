<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SicilyLines - Accueil</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <style>
            
            body {
                background-color: #5daade; 
            }
            .navbar-custom {
                background-color: #0d4e80; 
                border-bottom: 4px solid #2563eb;
            }
            .sicily-text {
                font-family: serif;
                color: #2dd4bf; 
                font-weight: bold;
                font-style: italic;
            }
            .lines-text {
                color: #fbbf24; 
                font-weight: bold;
                text-transform: uppercase;
            }
            
            .carousel-item img {
                height: 500px;
                object-fit: cover;
                border-radius: 10px;
            }
           
            .thumb-img {
                height: 150px;
                object-fit: cover;
                width: 100%;
                cursor: pointer;
                border-radius: 8px;
                transition: transform 0.2s;
                border: 2px solid transparent;
            }
            .thumb-img:hover {
                transform: scale(1.05);
                border-color: white;
            }
        </style>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3">
            <div class="container">
                <a class="navbar-brand" href="#">
    <img src="{{ asset('images/logo-sicilylines.png') }}" alt="Sicily Lines Logo" height="50">
</a>

                <div class="ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary fw-bold px-4">Tableau de bord</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary fw-bold px-4">Connexion</a>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <div class="container mt-5">
            
            <div id="monCarrousel" class="carousel slide shadow-lg rounded" data-bs-ride="carousel">
                
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/sicile_1.jpg" class="d-block w-100" alt="Sicile">
                    </div>
                    <div class="carousel-item">
                        <img src="images/sicile_2.jpg" class="d-block w-100" alt="Port">
                    </div>
                    <div class="carousel-item">
                        <img src="images/sicile_3.jpg" class="d-block w-100" alt="Ruines">
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#monCarrousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#monCarrousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>

            <div class="row mt-4 g-3">
                <div class="col-4">
                    <img src="images/sicile_1.jpg" 
                         class="thumb-img shadow" 
                         data-bs-target="#monCarrousel" data-bs-slide-to="0">
                </div>
                <div class="col-4">
                    <img src="images/sicile_2.jpg" 
                         class="thumb-img shadow" 
                         data-bs-target="#monCarrousel" data-bs-slide-to="1">
                </div>
                <div class="col-4">
                    <img src="images/sicile_3.jpg" 
                         class="thumb-img shadow" 
                         data-bs-target="#monCarrousel" data-bs-slide-to="2">
                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>