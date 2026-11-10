<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table pivot entre ferries et équipements.
     * ON DELETE CASCADE : supprimer un ferry (ou un équipement) supprime ses
     * associations, pour ne jamais laisser de lignes orphelines.
     */
    public function up(): void
    {
        Schema::create('equipment_ferry', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ferry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_ferry');
    }
};
