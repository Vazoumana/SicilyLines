<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FerryController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth', 'verified'])->group(function () {
    
    
    Route::get('/dashboard', [FerryController::class, 'index'])->name('dashboard');

    
    Route::resource('ferries', FerryController::class);

   
    Route::get('/ferry/{id}/pdf', [FerryController::class, 'downloadPdf'])->name('ferry.pdf');
    Route::get('/all-ferries-pdf', [FerryController::class, 'downloadAllPdf'])->name('ferries.pdf_all');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';