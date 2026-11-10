<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Équipement pouvant être présent à bord d'un ferry (Wifi, bar, restaurant…).
 */
class Equipment extends Model
{
    // "equipment" est indénombrable en anglais : on précise le nom de la table.
    protected $table = 'equipment';

    protected $fillable = ['name'];

    public function ferries(): BelongsToMany
    {
        return $this->belongsToMany(Ferry::class)->withTimestamps();
    }
}
