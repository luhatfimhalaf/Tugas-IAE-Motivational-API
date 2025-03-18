<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;

Route::get('/', [QuoteController::class, 'index'])->name('quotes.index');
Route::get('/quotes/create', [QuoteController::class, 'create'])->name('quotes.create');
Route::post('/quotes/search-author', [QuoteController::class, 'searchAuthor'])->name('quotes.searchAuthor');
Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
Route::put('/quotes/{quote}', [QuoteController::class, 'update'])->name('quotes.update');
Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');
Route::get('/quotes/search', [QuoteController::class, 'search'])->name('quotes.search');
