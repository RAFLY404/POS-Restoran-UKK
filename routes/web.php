<?php

use Midtrans\Transaction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MidtransWebhookController;

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
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/cart', [HomeController::class, 'kasir'])->name('home.kasir');


Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
Route::post('/checkoutp', [TransactionController::class, 'checkoutp'])->name('checkoutp');
Route::post('/checkoutKasir', [TransactionController::class, 'checkoutKasir'])->name('checkoutKasir');
Route::get('/laporanpenjualan', [TransactionController::class, 'viewLaporan'])->name('laporan');
Route::post('/exportpdf', [TransactionController::class, 'exportPDF'])->name('exportpdf');

Route::get('/midtrans-notification', [TransactionController::class, 'notif'])->name('midtrans-notification');

Route::get('/histori', [HomeController::class, 'histori'])->middleware(['auth', 'verified'])->name('histori');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
Route::put('/transactions/{id}/update-status', [TransactionController::class, 'updateStatus'])->name('update.transaction.status');
Route::get('/transactions/{id}', [TransactionController::class, 'show']);


Route::resource('menus', MenuController::class)->names([
    'index' => 'menus.index',
    'create' => 'menus.create',
    'store' => 'menus.store',
    'show' => 'menus.show',
    'edit' => 'menus.edit',
    'update' => 'menus.update',
    'destroy' => 'menus.destroy',
]);

// Route::get('/cart', function () {
//     return view('cart');
// })->name('cart');

// Route::get('/histori', function () {
//     return view('histori');
// })->middleware(['auth', 'verified'])->name('histori');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::post('/callback', [MidtransWebhookController::class, 'callback'])->name('callback');
Route::post('/handle', [MidtransWebhookController::class, 'handle'])->name('handle');


// Route::get('/home', function () {
//     return view('dashboard');
// })->name('dashboard');
