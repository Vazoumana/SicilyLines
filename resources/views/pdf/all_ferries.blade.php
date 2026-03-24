<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Ferries</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #1e3a8a; color: white; }
        h1 { color: #1e3a8a; text-align: center; }
    </style>
</head>
<body>
    <h1>Liste Complète des Ferries</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Longueur</th>
                <th>Largeur</th>
                <th>Équipements</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ferries as $ferry)
            <tr>
                <td>{{ $ferry->name }}</td>
                <td>{{ $ferry->length }} m</td>
                <td>{{ $ferry->width }} m</td>
                <td>
                    @foreach($ferry->equipments as $eq)
                        {{ $eq->name }}@if(!$loop->last), @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>