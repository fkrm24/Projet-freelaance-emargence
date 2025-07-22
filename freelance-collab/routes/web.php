<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'menu'])->middleware(['auth'])->name('dashboard.menu');
Route::post('/profil/submit', [ProfilController::class, 'submit'])->middleware(['auth'])->name('profil.submit');
Route::get('/merci', function () {
    return view('merci');
})->middleware(['auth'])->name('merci');

use Carbon\Carbon;

Route::post('/admin/users/{user}/update-disponibilite', [\App\Http\Controllers\AdminController::class, 'updateDisponibilite'])
    ->middleware(['auth', \App\Http\Middleware\Admin::class])
    ->name('admin.users.update-disponibilite');

Route::post('/admin/users/{user}/update-date-modifiee', [\App\Http\Controllers\AdminController::class, 'updateDateModifiee'])
    ->middleware(['auth', \App\Http\Middleware\Admin::class])
    ->name('admin.users.update-date-modifiee');

Route::get('/admin/contacts/{type}/{id}', [\App\Http\Controllers\ContactController::class, 'showContact'])->name('admin.contacts.showContact');

// Routes Admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', \App\Http\Middleware\Admin::class]], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/export-csv', [AdminController::class, 'exportCsv'])->name('admin.export-csv');
    Route::get('/download-cv/{profil}', [AdminController::class, 'downloadCV'])->name('admin.download-cv');
    Route::post('/confidence-index/{profil}', [AdminController::class, 'addConfidenceIndex'])->name('admin.add-confidence-index');
    Route::post('/profils/{profil}/confidence-indices/{indice}/activate', [\App\Http\Controllers\AdminController::class, 'setActiveConfidenceIndex'])->name('admin.confidence-indices.activate');
    Route::post('/profils/{profil}/confidence-indices/reset', [\App\Http\Controllers\ConfidenceIndexController::class, 'reset'])->name('admin.confidence-indices.reset');
    Route::delete('/profils/{profil}', [AdminController::class, 'destroyProfil'])->name('admin.profils.destroy');
    
    // Gestion des sociétés (admin)
    Route::get('/societes-list', [ContactController::class, 'listSocietes'])->name('admin.societes.list');
    Route::post('/societes', [ContactController::class, 'storeSociete'])->name('admin.societes.store');
    Route::delete('/societes/{societe}/detach-contact/{reference}', [ContactController::class, 'detachContact'])->name('admin.societes.detach-contact');
    Route::delete('/societes/{contact}', [ContactController::class, 'destroySociete'])->name('admin.societes.destroy');
    Route::prefix('societes')->name('admin.societes.')->group(function () {
        Route::get('/export-societes', [ContactController::class, 'exportSocietes'])->name('exportSocietes');
        Route::get('/export-all-actions', [ContactController::class, 'exportAllActions'])->name('exportAllActions');
        Route::get('/{contact}/export-actions', [ContactController::class, 'exportActions'])->name('exportActions');
        Route::get('/{contact}/export-contacts', [ContactController::class, 'exportContacts'])->name('exportContacts');
        Route::get('/', [ContactController::class, 'societes'])->name('index');
        Route::get('/{contact}', [ContactController::class, 'showSociete'])->name('show');
        Route::put('/{contact}', [ContactController::class, 'updateSociete'])->name('update');
        Route::post('/{contact}/affecter-contact', [ContactController::class, 'affecterContact'])->name('affecter-contact');
        Route::post('/{contact}/actions', [ContactController::class, 'storeSocieteAction'])->name('actions.store');
        // Sauvegarde des champs "Action à venir" sur toutes les actions de la société
        Route::post('/actions-a-venir', [ContactController::class, 'updateActionsAVenir'])->name('actionsAVenir');
    });
    // Gestion des contacts (admin)
    Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'index'])->name('admin.contacts.index');
    Route::post('/contacts', [App\Http\Controllers\ContactController::class, 'store'])->name('admin.contacts.store');
    Route::get('/contacts/export', [App\Http\Controllers\ContactController::class, 'exportAllContacts'])->name('admin.contacts.export');
    Route::get('/contacts/{reference}', [App\Http\Controllers\ContactController::class, 'show'])->name('admin.contacts.show');
    Route::put('/contacts/{reference}', [App\Http\Controllers\ContactController::class, 'update'])->name('admin.contacts.update');
    Route::delete('/contacts/{reference}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('admin.contacts.destroy');

    // Gestion des contacts manuels (admin)
    Route::resource('manualcontacts', App\Http\Controllers\ManualContactController::class)
        ->only(['edit', 'update', 'destroy'])
        ->names([
            'edit' => 'admin.manualcontacts.edit',
            'update' => 'admin.manualcontacts.update',
            'destroy' => 'admin.manualcontacts.destroy',
        ]);

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route pour la soumission du formulaire freelance
Route::post('/profil/submit', [ProfilController::class, 'submit'])->name('profil.submit');

// Route pour la page de remerciement
Route::get('/merci', function () {
    return view('merci');
})->name('merci');

require __DIR__.'/auth.php';
