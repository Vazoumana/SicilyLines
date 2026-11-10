<?php

use App\Models\Equipment;
use App\Models\Ferry;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('les invités sont redirigés vers la connexion', function () {
    $this->get('/ferries')->assertRedirect('/login');
    $this->get('/all-ferries-pdf')->assertRedirect('/login');
});

test('la liste des ferries s\'affiche', function () {
    $ferry = Ferry::factory()->create(['name' => 'Eduardo']);

    $this->actingAs(User::factory()->create())
        ->get('/ferries')
        ->assertOk()
        ->assertSee('Eduardo');
});

test('un ferry peut être créé avec ses équipements et sa photo', function () {
    Storage::fake('public');
    $wifi = Equipment::create(['name' => 'Wifi']);
    $bar = Equipment::create(['name' => 'Bar']);

    $this->actingAs(User::factory()->create())
        ->post('/ferries', [
            'name' => 'Platone',
            'length' => 25,
            'width' => 7,
            'speed' => 16,
            'equipments' => [$wifi->id, $bar->id],
            'image' => UploadedFile::fake()->image('platone.jpg'),
        ])
        ->assertRedirect('/ferries');

    $ferry = Ferry::where('name', 'Platone')->firstOrFail();
    expect($ferry->equipments)->toHaveCount(2);
    Storage::disk('public')->assertExists($ferry->image_path);
});

test('les champs obligatoires sont validés', function () {
    $this->actingAs(User::factory()->create())
        ->post('/ferries', [])
        ->assertSessionHasErrors(['name', 'length', 'width', 'speed']);
});

test('modifier un ferry met à jour ses équipements', function () {
    $wifi = Equipment::create(['name' => 'Wifi']);
    $bar = Equipment::create(['name' => 'Bar']);
    $ferry = Ferry::factory()->create();
    $ferry->equipments()->attach($wifi);

    $this->actingAs(User::factory()->create())
        ->put("/ferries/{$ferry->id}", [
            'name' => 'Nouveau nom',
            'length' => 30,
            'width' => 8,
            'speed' => 20,
            'equipments' => [$bar->id],
        ])
        ->assertRedirect("/ferries/{$ferry->id}");

    $ferry->refresh();
    expect($ferry->name)->toBe('Nouveau nom')
        ->and($ferry->equipments->pluck('name')->all())->toBe(['Bar']);
});

test('supprimer un ferry supprime aussi ses associations', function () {
    $wifi = Equipment::create(['name' => 'Wifi']);
    $ferry = Ferry::factory()->create();
    $ferry->equipments()->attach($wifi);

    $this->actingAs(User::factory()->create())
        ->delete("/ferries/{$ferry->id}")
        ->assertRedirect('/ferries');

    expect(Ferry::count())->toBe(0);
    $this->assertDatabaseCount('equipment_ferry', 0);
});

test('les pages de création, de fiche et de modification s\'affichent', function () {
    Equipment::create(['name' => 'Wifi']);
    $ferry = Ferry::factory()->create(['name' => 'Eduardo']);
    $user = User::factory()->create();

    $this->actingAs($user)->get('/ferries/create')->assertOk()->assertSee('Wifi');
    $this->actingAs($user)->get("/ferries/{$ferry->id}")->assertOk()->assertSee('Eduardo');
    $this->actingAs($user)->get("/ferries/{$ferry->id}/edit")->assertOk()->assertSee('Eduardo');
});

test('les fiches PDF sont générées', function () {
    $ferry = Ferry::factory()->create(['name' => 'Eduardo']);
    $user = User::factory()->create();

    $this->actingAs($user)->get("/ferry/{$ferry->id}/pdf")
        ->assertOk()->assertHeader('content-type', 'application/pdf');

    $this->actingAs($user)->get('/all-ferries-pdf')
        ->assertOk()->assertHeader('content-type', 'application/pdf');
});
