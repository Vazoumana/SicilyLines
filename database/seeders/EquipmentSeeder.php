<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = [
            'Accès Handicapés',
            'Wifi',
            'Bar',
            'Restaurant',
            'Toilettes',
            'Climatisation',
            'Pont Promenade',
        ];

        foreach ($equipments as $name) {
            Equipment::firstOrCreate(['name' => $name]);
        }
    }
}
