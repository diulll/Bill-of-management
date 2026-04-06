<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Quick Calculator
Route::get('calculator', [\App\Http\Controllers\CalculatorController::class, 'index'])->name('calculator.index');

// Master Data: Menus
Route::resource('menus', MenuController::class);
Route::post('menus/{menu}/recipe', [MenuController::class, 'updateRecipe'])->name('menus.recipe.update');

// Master Data: Ingredients
Route::resource('ingredients', IngredientController::class)->except(['show']);

// Penjualan
Route::resource('sales', SaleController::class);

// Laporan Kalkulasi
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
