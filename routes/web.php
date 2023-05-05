<?php

use Illuminate\Support\Facades\Route;

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
    return view('templates.master');
});

Route::middleware('auth')->namespace('Main')->group(function () {
    Route::controller(DashboardController::class)
        ->prefix('dashboard')
        ->as('dashboard.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/chart', 'chart')->name('chart');
            Route::post('/chart-terlaris', 'chartTerlaris')->name('chart.terlaris');
            Route::post('/chart-pendapatan', 'chartPendapatan')->name('chart.pendapatan');
        });

    Route::controller(KategoriController::class)
        ->prefix('kategori')
        ->as('kategori.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/render', 'render')->name('render');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
        });

    Route::controller(BukuController::class)
        ->prefix('buku')
        ->as('buku.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/render', 'render')->name('render');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
        });

    Route::controller(KeranjangController::class)
        ->prefix('keranjang')
        ->as('keranjang.')
        ->group(function () {
            Route::get('/tambah', 'tambah')->name('tambah');
            Route::post('/update', 'update')->name('update');
            Route::get('/remove/{id}', 'remove')->name('remove');
            Route::get('/check', 'check')->name('check');
        });

    Route::controller(TransaksiController::class)
        ->prefix('transaksi')
        ->as('transaksi.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/cari-buku/{slug}', 'search')->name('search');
            Route::post('/checkout', 'checkout')->name('checkout');
        });
});

Route::middleware('guest')->namespace('Main')->group(function () {
    Route::controller(SignupController::class)
        ->prefix('signup')
        ->as('signup.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'signup')->name('signup');
        });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
