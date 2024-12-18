<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\RiwayatBelanjaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\PromosiController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\TransaksiPemasokController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanSuperAdminController;
use App\Models\Kategori;

// Rute untuk halaman home
Route::get('/home', function () {
    return view('customer.home');
})->name('customer.home');

// Route::get('/home', [HomeController::class, 'index'])->name('customer.home');
//Route::get('/', [HomeController::class, 'index'])->name('customer.home');

Route::middleware(['auth', 'role:admin,super_admin,kurir'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard.index');
});


// Rute login dan registrasi
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/home', [ProdukController::class, 'showProductsForCustomer'])->name('customer.home');
});

// Registrasi rute
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Halaman statis untuk customer
Route::get('/about', function() {
    return view('customer.about');
});
Route::get('/shop', function() {
    return view('customer.shop');
});

Route::get('/shop', [ProdukController::class, 'showShop'])->name('customer.shop');
// // This is the only route you need for /shop


Route::get('/shop-single', function() {
    return view('customer.shop-single');
});
Route::get('/contact', function() {
    return view('customer.contact');
});

// Rute produk
Route::resource('produk', ProdukController::class)->middleware(['auth', 'role:admin']);

Route::get('/home', [ProdukController::class, 'showProductsForCustomer']);

Route::get('customer/product/{id}', [ProdukController::class, 'showProductForCustomer'])->name('customer.show');

// Rute untuk pencarian produk di admin
Route::get('/search', [ProdukController::class, 'search'])->name('search');

// //Rute untuk pencarian produk di customer
// Route::get('/search', [ProdukController::class, 'search'])->name('search');

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('customer.profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('customer.update-profile');
});

// Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Rute kategori
Route::resource('kategori', KategoriController::class);

Route::get('/cart', [CartController::class, 'index'])->name('cart')->middleware(['auth', 'role:customer']);
Route::post('/cart/add', [CartController::class, 'add'])->name('customer.cart.add')->middleware(['auth', 'role:customer']); // Change GET to POST
Route::post('/cart/update', [CartController::class, 'update'])->name('customer.cart.update')->middleware(['auth', 'role:customer']);
Route::post('/cart/remove', [CartController::class, 'remove'])->name('customer.cart.remove')->middleware(['auth', 'role:customer']);
// Route::get('/cart/count', [CartController::class, 'cartCount'])->name('customer.cart.count');
Route::get('/cart/count', [CartController::class, 'count'])->middleware(['auth', 'role:customer']);
// Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('customer.cart.applyCoupon');
// Route::post('/cart/apply-coupon', [CartController::class, 'applyDiscounts'])->name('customer.cart.applyCoupon');
Route::post('/cart/apply-discounts', [CartController::class, 'applyDiscounts'])->name('customer.cart.apply-discounts')->middleware(['auth', 'role:customer']);

// Route::post('/cart/apply-coupon', [CartController::class, 'applyDiscounts']);
// Route untuk menampilkan form checkout
Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.form')->middleware(['auth', 'role:customer']);

// Route untuk memproses checkout
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process')->middleware(['auth', 'role:customer']);

// Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
// Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

Route::get('/nota/{id}', [NotaController::class, 'show'])->name('nota')->middleware(['auth', 'role:customer']); // Route untuk halaman nota

Route::get('/riwayat-belanja', [RiwayatBelanjaController::class, 'index'])->middleware('auth')->name('riwayat.belanja')->middleware(['auth', 'role:customer']);

Route::get('/pembayaran/input/{id}', [PembayaranController::class, 'create'])->name('input.pembayaran')->middleware(['auth', 'role:customer']);
Route::get('/pembayaran/lihat/{id}', [PembayaranController::class, 'show'])->name('lihat.pembayaran')->middleware(['auth', 'role:customer']);
Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store')->middleware(['auth', 'role:customer']);

// // Route::post('/orders/{id}/payment', [PembayaranController::class, 'store'])->name('orders.payment.store');

Route::prefix('dashboard')->middleware('auth', 'role:admin,kurir')->group(function () {
    Route::resource('pesanan', AdminPesananController::class)->names([
        'index' => 'dashboard.pesanan.index',
        'show' => 'dashboard.pesanan.show',
        'edit' => 'dashboard.pesanan.edit',
        'update' => 'dashboard.pesanan.update',
    ]);
});


Route::get('/dashboard/pembayaran', [PembayaranController::class, 'index'])->name('dashboard.pembayaran.index')->middleware(['auth', 'role:admin']);
Route::get('/dashboard/pembayaran/{id}', [PembayaranController::class, 'showAdmin'])->name('dashboard.pembayaran.show')->middleware(['auth', 'role:admin']);

// ulasan
Route::get('/ulasan/{id}', [UlasanController::class, 'create'])->name('input.ulasan')->middleware(['auth', 'role:customer']);
Route::post('/ulasan/{id}', [UlasanController::class, 'store'])->name('simpan.ulasan')->middleware(['auth', 'role:customer']);

Route::resource('promosi', PromosiController::class)->middleware(['auth', 'role:admin']);

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard/pengguna', [UserController::class, 'index'])->name('dashboard.pengguna.index');
    Route::get('/dashboard/pengguna/create', [UserController::class, 'create'])->name('dashboard.pengguna.create');
    Route::post('/dashboard/pengguna', [UserController::class, 'store'])->name('dashboard.pengguna.store');
    Route::get('/dashboard/pengguna/{id}/edit', [UserController::class, 'edit'])->name('dashboard.pengguna.edit');
    Route::get('/dashboard/pengguna/{id}', [UserController::class, 'show'])->name('dashboard.pengguna.show');
    Route::put('/dashboard/pengguna/{id}', [UserController::class, 'update'])->name('dashboard.pengguna.update');
    Route::delete('/dashboard/pengguna/{id}', [UserController::class, 'destroy'])->name('dashboard.pengguna.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Pemasok Routes
    Route::get('/dashboard/pemasok', [PemasokController::class, 'index'])->name('dashboard.pemasok.index');
    Route::get('/dashboard/pemasok/create', [PemasokController::class, 'create'])->name('dashboard.pemasok.create');
    Route::post('/dashboard/pemasok', [PemasokController::class, 'store'])->name('dashboard.pemasok.store');
    Route::get('/dashboard/pemasok/{id}/edit', [PemasokController::class, 'edit'])->name('dashboard.pemasok.edit');
    Route::get('/dashboard/pemasok/{id}', [PemasokController::class, 'show'])->name('dashboard.pemasok.show');
    Route::put('/dashboard/pemasok/{id}', [PemasokController::class, 'update'])->name('dashboard.pemasok.update');
    Route::delete('/dashboard/pemasok/{id}', [PemasokController::class, 'destroy'])->name('dashboard.pemasok.destroy');

    // Transaksi Pemasok Routes
    Route::get('/dashboard/transaksipemasok', [TransaksiPemasokController::class, 'index'])->name('dashboard.transaksipemasok.index');
    Route::get('/dashboard/transaksipemasok/create', [TransaksiPemasokController::class, 'create'])->name('dashboard.transaksipemasok.create');
    Route::post('/dashboard/transaksipemasok', [TransaksiPemasokController::class, 'store'])->name('dashboard.transaksipemasok.store');
    Route::get('/dashboard/transaksipemasok/{id}/edit', [TransaksiPemasokController::class, 'edit'])->name('dashboard.transaksipemasok.edit');
    Route::get('/dashboard/transaksipemasok/{id}', [TransaksiPemasokController::class, 'show'])->name('dashboard.transaksipemasok.show');
    Route::put('/dashboard/transaksipemasok/{id}', [TransaksiPemasokController::class, 'update'])->name('dashboard.transaksipemasok.update');
    Route::delete('/dashboard/transaksipemasok/{id}', [TransaksiPemasokController::class, 'destroy'])->name('dashboard.transaksipemasok.destroy');
});

//route laporan admin
Route::get('/cetak-pdf/produk', [ProdukController::class, 'cetakPDF'])->name('produk.cetak-pdf')->middleware(['auth', 'role:admin']);
Route::get('/cetak-pdf/pesanan', [AdminPesananController::class, 'cetakPDF'])->name('pesanan.cetak-pdf')->middleware(['auth', 'role:admin']);
Route::get('/cetak-pdf/pembayaran', [PembayaranController::class, 'cetakPDF'])->name('pembayaran.cetak-pdf')->middleware(['auth', 'role:admin']);
Route::get('/cetak-pdf/promosi', [PromosiController::class, 'cetakPdf'])->name('promosi.cetak-pdf')->middleware(['auth', 'role:admin']);
Route::get('/cetak-pdf/pemasok', [PemasokController::class, 'cetakPdf'])->name('pemasok.cetak-pdf')->middleware(['auth', 'role:admin']);
Route::get('/cetak-pdf/transaksipemasok', [TransaksiPemasokController::class, 'cetakPdf'])->name('transaksipemasok.cetak-pdf')->middleware(['auth', 'role:admin']);

//route laporan super admin
Route::get('/cetak-pdf/pengguna', [UserController::class, 'cetakPdf'])->name('pengguna.cetak-pdf')->middleware(['auth', 'role:super_admin']);
Route::get('/laporan/pesanan', [LaporanSuperAdminController::class, 'cetakPesanan'])->name('laporan.pesanan')->middleware(['auth', 'role:super_admin']);
Route::get('/laporan/pembayaran', [LaporanSuperAdminController::class, 'cetakPembayaran'])->name('laporan.pembayaran')->middleware(['auth', 'role:super_admin']);
Route::get('/laporan/transaksi-pemasok', [LaporanSuperAdminController::class, 'cetakTransaksiPemasok'])->name('laporan.transaksi-pemasok')->middleware(['auth', 'role:super_admin']);
Route::get('/laporan', function () {
    return view('dashboard.laporan.index');
})->name('laporan.index')->middleware(['auth', 'role:super_admin']);
