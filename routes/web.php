<?php
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\FormController;
use App\Models\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    DB::enableQueryLog();
    $value = Component::limit(100)->with('panel')->get();
    $query = DB::getQueryLog();
    return [$value,$query];
});

// Route for displaying a listing of the resource
Route::get('/forms', [FormController::class, 'index'])->name('forms.index');

// Route for storing a newly created resource in storage
Route::post('/forms', [FormController::class, 'store'])->name('forms.store');

// Route to fetch statistics
Route::get('/forms/stats/', [FormController::class, 'stats'])->name('forms.stats');

// Route for displaying the specified resource
Route::get('/forms/{id}', [FormController::class, 'show'])->name('forms.show');

// Route for showing the form for editing the specified resource
Route::get('/forms/{id}/edit', [FormController::class, 'edit'])->name('forms.edit');

// Route for updating the specified resource in storage
Route::put('/forms/{id}', [FormController::class, 'update'])->name('forms.update');

// Route for removing the specified resource from storage
Route::delete('/forms/{id}', [FormController::class, 'destroy'])->name('forms.destroy');

// Display a listing of the resource
Route::get('/components', [ComponentController::class, 'index'])->name('components.index');

// Store a newly created resource in storage
Route::post('/components', [ComponentController::class, 'store'])->name('components.store');

// Display the specified resource
Route::get('/components/{id}', [ComponentController::class, 'show'])->name('components.show');

// Update the specified resource in storage
Route::put('/components/{id}', [ComponentController::class, 'update'])->name('components.update');

// Remove the specified resource from storage
Route::delete('/components/{id}', [ComponentController::class, 'destroy'])->name('components.destroy');

// Show the form for creating a new resource
Route::get('/components/create', [ComponentController::class, 'create'])->name('components.create');

// Show the form for editing the specified resource
Route::get('/components/{id}/edit', [ComponentController::class, 'edit'])->name('components.edit');
