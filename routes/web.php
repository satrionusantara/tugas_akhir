<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\SalesController;

use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\MerkController;
use App\Http\Controllers\Admin\MetodeController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\BarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\PemasukanController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\HutangController;
use App\Http\Controllers\Admin\PiutangController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\DiskonController;
use App\Http\Controllers\Admin\CostumerController;
use App\Http\Controllers\Admin\SupplierController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Clear All:
Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('optimize');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return '<h1>Berhasil dibersihkan</h1>';
});

Route::get('/', function () {
    return view('auth.login');
});

// Authentication
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/keluar', [HomeController::class, 'keluar']);
Route::get('/admin/home', [HomeController::class, 'index']);
Route::get('/admin/home/filter/{id}', [HomeController::class, 'index_filter']);
Route::get('/admin/change', [HomeController::class, 'change']);
Route::post('/admin/change_password', [HomeController::class, 'change_password']);
Route::get('/invoice/{id}', [HomepageController::class, 'invoice']);
Route::get('/cetak/{id}', [HomepageController::class, 'cetak']);
Route::get('/cetak/bill/{id}', [HomepageController::class, 'bill']);

// Satuan
Route::prefix('admin/satuan')
    ->name('admin.satuan.')
    ->middleware('cekLevel:1 2')
    ->controller(SatuanController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Supplier
Route::prefix('admin/supplier')
    ->name('admin.supplier.')
    ->middleware('cekLevel:1 2')
    ->controller(SupplierController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Metode
Route::prefix('admin/metode')
    ->name('admin.metode.')
    ->middleware('cekLevel:1 2')
    ->controller(MetodeController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Account
Route::prefix('admin/account')
    ->name('admin.account.')
    ->middleware('cekLevel:1 2')
    ->controller(AccountController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/reset/{id}', 'reset')->name('reset'); // Hanya untuk Account
    });

// Barang
Route::prefix('admin/barang')
    ->name('admin.barang.')
    ->middleware('cekLevel:1 2 3')
    ->controller(BarangController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/filter/{id}', 'read_filter')->name('read_filter');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/detail/{id}', 'detail')->name('detail');
        Route::post('/detail/create/{id}', 'create_detail')->name('create_detail');
        Route::post('/detail/update/{id}', 'update_detail')->name('update_detail');
        Route::get('/detail/delete/{id}', 'delete_detail')->name('delete_detail');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
    });

// Barang Masuk
Route::prefix('admin/barang_masuk')
    ->name('admin.barang_masuk.')
    ->middleware('cekLevel:1 2 3')
    ->controller(BarangMasukController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/filter/{bln}', 'read_filter')->name('read_filter');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/delete/{id}', 'delete')->name('delete');

        Route::get('/detail/{id}', 'detail')->name('detail');
        Route::post('/detail/create/{id}', 'create_detail')->name('create_detail');
        Route::post('/detail/update/{id}', 'update_detail')->name('update_detail');
        Route::get('/detail/delete/{id}', 'delete_detail')->name('delete_detail');

        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
    });

// Barang Keluar
Route::prefix('admin/barang_keluar')
    ->name('admin.barang_keluar.')
    ->middleware('cekLevel:1 2 3')
    ->controller(BarangKeluarController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

// Pengeluaran
Route::prefix('admin/pengeluaran')
    ->name('admin.pengeluaran.')
    ->middleware('cekLevel:1 2 3')
    ->controller(PengeluaranController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/filter/{id}/{bln}', 'read_filter')->name('read_filter');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/cetak/{bln}', 'cetak')->name('cetak');
    });

// Pemasukan
Route::prefix('admin/pemasukan')
    ->name('admin.pemasukan.')
    ->middleware('cekLevel:1 2 3')
    ->controller(PemasukanController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/filter/{bln}', 'read_filter')->name('read_filter');
        Route::get('/cetak/{bln}', 'cetak')->name('cetak');
    });

Route::get('/admin/search-barang', [TransaksiController::class, 'searchBarang']);

// Transaksi
Route::prefix('admin/transaksi')
    ->name('admin.transaksi.')
    ->middleware('cekLevel:1 2 3')
    ->controller(TransaksiController::class)
    ->group(function () {
        Route::get('/', 'read')->name('read');
        Route::get('/filter/{bln}', 'read_filter')->name('read_filter');
        Route::get('/add', 'add')->name('add');
        Route::post('/create', 'create')->name('create');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');

        Route::get('/detail/{id}', 'detail')->name('detail');
        Route::post('/detail/create/{id}', 'create_detail')->name('create_detail');
        Route::get('/detail/delete/{id}', 'delete_detail')->name('delete_detail');

        Route::get('/detail/edit/{id}', 'edit_detail')->name('edit_detail');
        Route::post('/detail/update/{id}', 'update_detail')->name('update_detail');

        Route::post('/bayar/{id}', 'bayar')->name('bayar');
        Route::post('/hutang/{id}', 'hutang')->name('hutang');
        Route::get('/cetak/{id}', 'cetak')->name('cetak');
    });

// // Asset
// Route::prefix('admin/asset')
//     ->name('admin.asset.')
//     ->middleware('cekLevel:1')
//     ->controller(AssetController::class)
//     ->group(function () {
//         Route::get('/', 'read')->name('read');
//         Route::get('/filter/{id}', 'read_filter')->name('read_filter');
//     });