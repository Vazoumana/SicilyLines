<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Ferry;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gestion de la flotte : CRUD des ferries, de leurs équipements et de leur
 * photo, plus l'export des fiches au format PDF.
 */
class FerryController extends Controller
{
    /** Liste paginée des ferries (aussi utilisée comme tableau de bord). */
    public function index(): View
    {
        $ferries = Ferry::orderBy('name')->paginate(10);

        return view('ferries.index', compact('ferries'));
    }

    public function create(): View
    {
        $equipments = Equipment::orderBy('name')->get();

        return view('ferries.create', compact('equipments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateFerry($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('ferries', 'public');
        }

        $ferry = Ferry::create($data);
        $ferry->equipments()->sync($request->input('equipments', []));

        return redirect()->route('ferries.index');
    }

    public function show(Ferry $ferry): View
    {
        $ferry->load('equipments');

        return view('ferries.show', compact('ferry'));
    }

    public function edit(Ferry $ferry): View
    {
        $ferry->load('equipments');
        $equipments = Equipment::orderBy('name')->get();

        return view('ferries.edit', compact('ferry', 'equipments'));
    }

    public function update(Request $request, Ferry $ferry): RedirectResponse
    {
        $data = $this->validateFerry($request);

        // Nouvelle photo : on supprime l'ancienne pour ne pas laisser de fichiers inutiles.
        if ($request->hasFile('image')) {
            if ($ferry->image_path) {
                Storage::disk('public')->delete($ferry->image_path);
            }
            $data['image_path'] = $request->file('image')->store('ferries', 'public');
        }

        $ferry->update($data);

        // sync() ajoute les équipements cochés et retire ceux décochés en une seule opération.
        $ferry->equipments()->sync($request->input('equipments', []));

        return redirect()->route('ferries.show', $ferry);
    }

    public function destroy(Ferry $ferry): RedirectResponse
    {
        if ($ferry->image_path) {
            Storage::disk('public')->delete($ferry->image_path);
        }

        // Les lignes de la table pivot partent avec le ferry (ON DELETE CASCADE).
        $ferry->delete();

        return redirect()->route('ferries.index');
    }

    /** Fiche PDF d'un ferry. */
    public function downloadPdf(int $id): Response
    {
        $ferry = Ferry::with('equipments')->findOrFail($id);

        return Pdf::loadView('pdf.ferry', compact('ferry'))
            ->download('ferry-'.str($ferry->name)->slug().'.pdf');
    }

    /** PDF récapitulatif de toute la flotte. */
    public function downloadAllPdf(): Response
    {
        $ferries = Ferry::with('equipments')->orderBy('name')->get();

        return Pdf::loadView('pdf.all_ferries', compact('ferries'))
            ->download('flotte-sicily-lines.pdf');
    }

    /** Règles communes à la création et à la modification. */
    private function validateFerry(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'length' => ['required', 'numeric', 'min:0'],
            'width' => ['required', 'numeric', 'min:0'],
            'speed' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'equipments' => ['nullable', 'array'],
            'equipments.*' => ['integer', 'exists:equipment,id'],
        ], [], [
            'name' => 'nom',
            'length' => 'longueur',
            'width' => 'largeur',
            'speed' => 'vitesse',
        ]);
    }
}
