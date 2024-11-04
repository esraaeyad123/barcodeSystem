<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarcodeController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/barcodes', [BarcodeController::class, 'store'])->name('barcodes.store');

Route::post('/barcodes/toggle/{code}', [BarcodeController::class, 'toggle']);

Route::get('barcodes/create', [BarcodeController::class, 'create'])->name('barcodes.create');
Route::get('barcodes/{id}', [BarcodeController::class, 'show'])->name('barcodes.show');
// إضافة المسار الخاص بـ scan
Route::get('/scan', [BarcodeController::class, 'scan'])->name('barcodes.scan');

Route::get('/invitation', [BarcodeController::class, 'showBarcodes'])->name('showBarcodes');

Route::get('/all', [BarcodeController::class, 'all'])->name('barcodes.index');


require __DIR__.'/auth.php';
