<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JsonUploadController;
use App\Http\Controllers\TransactionsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('upload');
});

// Start of Upload json files route
Route::post('/upload-json', [JsonUploadController::class,'upload'])->name('upload.json');
// End of Upload json files route

// Start of transactions routes
Route::get('/transactions', [TransactionsController::class, 'index']);
// End of transactions routes

