<?php

use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CalculatorLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Guest: redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// ── Halaman menunggu persetujuan (user sudah login tapi belum di-approve) ──
Route::middleware(['auth'])->group(function () {

    // Halaman menunggu approval
    Route::get('/waiting-approval', function () {
        if (auth()->user()->isApproved()) {
            return redirect()->route('dashboard');
        }
        return view('auth.waiting-approval');
    })->name('approval.waiting');

    // Profile tetap bisa diakses (agar user bisa logout)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Semua halaman di bawah ini memerlukan login + approved ──
Route::middleware(['auth', 'approved'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Quick Calculator
    Route::get('calculator', [CalculatorController::class, 'index'])->name('calculator.index');

    // Rekap Kalkulator (Simpan & Lihat)
    Route::get('calculator-logs', [CalculatorLogController::class, 'index'])->name('calculator-logs.index');
    Route::post('calculator-logs', [CalculatorLogController::class, 'store'])->name('calculator-logs.store');
    Route::get('calculator-logs/{calculator_log}', [CalculatorLogController::class, 'show'])->name('calculator-logs.show');
    Route::delete('calculator-logs/{calculator_log}', [CalculatorLogController::class, 'destroy'])->name('calculator-logs.destroy');

    // Master Data: Menus
    Route::resource('menus', MenuController::class);
    Route::post('menus/{menu}/recipe', [MenuController::class, 'updateRecipe'])->name('menus.recipe.update');

    // Master Data: Ingredients
    Route::resource('ingredients', IngredientController::class)->except(['show']);

    // Catatan Tim
    Route::get('notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('notes', [NoteController::class, 'store'])->name('notes.store');
    Route::delete('notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // Laporan Kalkulasi
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    // Kelola User (Admin Only)
    Route::middleware('admin')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::patch('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::patch('users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
    });
});

require __DIR__.'/auth.php';
