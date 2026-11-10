<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Un ferry de la flotte Sicily Lines.
 *
 * Dimensions en mètres, vitesse en nœuds. Seul le chemin de la photo est
 * stocké en base (image_path) : le fichier lui-même est sur le disque "public".
 */
class Ferry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'length',
        'width',
        'speed',
        'capacity',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'length' => 'float',
            'width' => 'float',
            'speed' => 'integer',
            'capacity' => 'integer',
        ];
    }

    /**
     * Équipements disponibles à bord (relation plusieurs-à-plusieurs via la
     * table pivot equipment_ferry).
     */
    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class)->withTimestamps();
    }
}
