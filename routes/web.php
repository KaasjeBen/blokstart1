<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('portfolio');
})->name('portfolio.home');

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');
    route::get('/portfolio/{id}', [PortfolioController::class, 'show'])->name('portfolio.show');
    route::post('/portfolio', [PortfolioController::class, 'store'])->name('portfolio.store');
});



require __DIR__.'/auth.php';
