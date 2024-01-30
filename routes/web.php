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

Route::middleware('auth')->namespace('Main')->group(function () {
    Route::controller(ErrorController::class)
        ->as('error.')
        ->group(function () {
            Route::get('/forbidden', 'forbidden')->name('forbidden');
            Route::get('/notfound', 'notfound')->name('notfound');
        });
});

Route::middleware(['auth', 'checkActiveUser'])->namespace('Main')->group(function () {
    Route::get('/', 'DashboardController@index')->name('index');

    Route::controller(MainController::class)
        ->as('main.')
        // ->middleware('checkRole:Admin,Direktur,Distribu')
        ->group(function () {
            Route::get('/cart', 'cart')->name('cart');
        });

    Route::controller(DashboardController::class)
        ->prefix('dashboard')
        ->as('dashboard.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/chart', 'chart')->name('chart');
            Route::post('/chart-by-kategori', 'chartByKategori')->name('chart.kategori');
            Route::post('/chart-pendapatan', 'chartPendapatan')->name('chart.pendapatan');
        });

    Route::controller(KategoriController::class)
        ->prefix('kategori')
        ->as('kategori.')
        ->middleware('checkRole:Admin,Direktur')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/render', 'render')->name('render');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::get('/print', 'print')->name('print');
        });

    Route::controller(BukuController::class)
        ->prefix('buku')
        ->as('buku.')
        ->middleware('checkRole:Admin,Direktur')
        // ->middleware(['checkRole:Admin','checkRole:Direktur'])
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/render', 'render')->name('render');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::get('/print', 'print')->name('print');
        });

    Route::controller(DistribusiController::class)
        ->prefix('distribusi')
        ->as('distribusi.')
        ->middleware('checkRole:Admin')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/render', 'render')->name('render');
            Route::get('/create', 'create')->name('create');
            Route::get('/detail/{id}', 'detail')->name('detail');
            Route::get('/list-buku/{id}', 'listBuku')->name('list-buku');
            Route::get('/list-distributor', 'listDistributor')->name('list-distributor');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::get('/print', 'print')->name('print');
        });

    Route::controller(KeranjangController::class)
        ->prefix('keranjang')
        ->as('keranjang.')
        ->group(function () {
            Route::post('/tambah', 'tambah')->name('tambah');
            Route::post('/update', 'update')->name('update');
            Route::get('/remove/{id}', 'remove')->name('remove');
            Route::get('/check', 'check')->name('check');
        });

    Route::controller(TransaksiController::class)
        ->prefix('transaksi')
        ->as('transaksi.')
        ->middleware('checkRole:Admin,Direktur')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/render', 'render')->name('search');
            Route::get('/detail/{id}', 'detail')->name('detail');
            Route::post('/update', 'update')->name('update');
            Route::get('/print', 'print')->name('print');
        });

    Route::controller(PembayaranController::class)
        ->prefix('pembayaran')
        ->as('pembayaran.')
        ->middleware('checkRole:Admin,Direktur')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/render', 'render')->name('search');
            Route::post('/update', 'update')->name('update');
            Route::get('/print', 'print')->name('print');
        });

    Route::controller('ProfilController')
        ->prefix('/profil')
        ->name('profil.')
        ->middleware('checkRole:Distributor')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update', 'update')->name('update');
        });

    Route::controller(PenggunaController::class)
        ->prefix('pengguna')
        ->as('pengguna.')
        ->middleware('checkRole:Admin,Direktur')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('/render', 'render')->name('render');
            Route::post('/update', 'update')->name('update');
            Route::get('/print', 'print')->name('print');
        });
});

Route::middleware(['auth', 'checkProfile:Distributor', 'checkRole:Distributor', 'checkActiveUser'])->prefix('distributor')
    ->namespace('Distributor')->as('distributor.')->group(function () {
        Route::controller(KatalogController::class)
            ->prefix('katalog')
            ->as('katalog.')
            // ->middleware(['checkProfile:Distributor'])
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/render', 'render')->name('render');
                Route::get('/search/{value}', 'search')->name('search');
                Route::post('/filter', 'filter')->name('filter');
            });

        Route::controller(KeranjangController::class)
            ->prefix('keranjang')
            ->as('keranjang.')
            // ->middleware(['checkProfile:Distributor'])
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/render', 'render')->name('render');
                Route::post('/update', 'update')->name('update');
                Route::post('/checkout', 'checkout')->name('checkout');
            });

        Route::controller(TransaksiController::class)
            ->prefix('transaksi')
            ->as('transaksi.')
            // ->middleware(['checkProfile:Distributor'])
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/render', 'render')->name('render');
                Route::get('/detail/{id}', 'detail')->name('detail');
                Route::post('/pembayaran', 'pembayaran')->name('pembayaran');
                Route::get('/print', 'print')->name('print');
            });

        Route::controller(PembayaranController::class)
            ->prefix('pembayaran')
            ->as('pembayaran.')
            ->middleware(['checkProfile:Distributor'])
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/render', 'render')->name('render');
                Route::get('/print', 'print')->name('print');
            });

        Route::controller(DistribusiController::class)
            ->prefix('distribusi')
            ->as('distribusi.')
            ->middleware(['checkProfile:Distributor'])
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/find/{id}', 'find')->name('find');
                Route::post('/validasi', 'validasi')->name('validasi');
                Route::post('/transaksi-store', 'transaksiStore')->name('transaksi-store');
            });

        Route::controller(ListDistribusiController::class)
            ->prefix('list-distribusi')
            ->as('list-distribusi.')
            ->middleware(['checkProfile:Distributor'])
            ->group(function () {
                Route::get('', 'index')->name('index');
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
