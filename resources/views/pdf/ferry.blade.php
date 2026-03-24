<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche Ferry : {{ $ferry->name }}</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        h1 { color: #1e3a8a; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; }
        .info-box { margin-bottom: 20px; }
        .label { font-weight: bold; color: #555; }
        .image-container { text-align: center; margin-bottom: 30px; }
        img { max-width: 100%; height: auto; border-radius: 8px; max-height: 300px; }
        .equipments ul { list-style-type: none; padding: 0; }
        .equipments li { background: #f0f0f0; margin: 5px 0; padding: 8px; border-radius: 4px; }
    </style>
</head>
<body>

    <div class="image-container">
        @if($ferry->image_path)
            <img src="{{ public_path('storage/' . $ferry->image_path) }}" alt="Ferry Image">
        @else
            <div style="padding: 50px; background: #eee; color: #999;">Pas d'image</div>
        @endif
    </div>

    <h1>{{ $ferry->name }}</h1>

    <div class="info-box">
        <p><span class="label">Longueur :</span> {{ $ferry->length }} m</p>
        <p><span class="label">Largeur :</span> {{ $ferry->width }} m</p>
        </div>

    <div class="equipments">
        <h3>Équipements à bord :</h3>
        <ul>
            @foreach($ferry->equipments as $equipment)
                <li> - {{ $equipment->name }}</li>
            @endforeach
            
            @if($ferry->equipments->isEmpty())
                <li>Aucun équipement spécifique.</li>
            @endif
        </ul>
    </div>

    <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #888;">
        Document généré par Sicily Lines - {{ date('d/m/Y') }}
    </div>

</body>
</html>