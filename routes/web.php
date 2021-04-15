<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\backend\DefaultController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\Console\Input\Input;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| alooo
*/

Route::get('/', [App\Http\Controllers\frontend\WelcomeController::class, 'index'])->name('welcome.Index');

Route::get('/profile', [App\Http\Controllers\frontend\ProfileController::class, 'index'])->middleware('auth')->name('profile.Index');
Route::get('/reservations', [App\Http\Controllers\frontend\ProfileController::class, 'reservations'])->middleware('auth')->name('profile.Reservations');


Route::post('/welcome/kitapAra', [\App\Http\Controllers\frontend\WelcomeController::class, 'kitapAra'])->name('welcome.kitapAra');

/* Google Oturum Aç Routing */
Route::get('login/google', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('googleLogin');
Route::get('login/google/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback'])->name('googleLoginRedirect');

Route::get('/kitap/{id}/{slug}', [App\Http\Controllers\frontend\BookController::class, 'index'])->name('books.DetaySayfa');

Route::get('/reservation/{id}', [App\Http\Controllers\frontend\BookController::class, 'bookRez'])->name('books.Reservation');

Route::prefix('admin')->group(function () {
    Route::get('/', [DefaultController::class, 'index'])->name('admin.Index')->middleware('KutuphaneYoneticisi');;

    Route::get('/settings', [App\Http\Controllers\backend\SettingsController::class, 'index'])->name('settings.Index')->middleware('admin');
    Route::post('sortable', [App\Http\Controllers\backend\SettingsController::class, 'sortable'])->name('settings.Sortable')->middleware('admin');
    Route::get('/settings/delete/{id}', [App\Http\Controllers\backend\SettingsController::class, 'delete'])->name('settings.Delete')->middleware('admin');
    Route::get('/settings/edit/{id}', [App\Http\Controllers\backend\SettingsController::class, 'edit'])->name('settings.Edit')->middleware('admin');
    Route::post('/settings/update/{id}', [App\Http\Controllers\backend\SettingsController::class, 'update'])->name('settings.Update')->middleware('admin');

    // Kullanıcı Routing
    Route::resource('/users', App\Http\Controllers\backend\UserController::class)->middleware('admin');;

    // Kütüphane Routing
    Route::resource('/libraries', App\Http\Controllers\backend\LibrariesController::class)->middleware('admin');;

    // Kitap Routing
    Route::resource('/books', App\Http\Controllers\backend\BooksController::class)->middleware('KutuphaneYoneticisi');

    // Kitap Arama
    Route::any('/books{q?}',[\App\Http\Controllers\backend\BooksController::class, 'index'])->name('books.Search')->middleware('KutuphaneYoneticisi');

    // Rezervasyon Arama
    Route::post('/rents{q?}',[\App\Http\Controllers\backend\RentsController::class, 'index'])->name('rents.Search')->middleware('KutuphaneYoneticisi');

    // Kitap QRCode Routing
    Route::get('/books/qrcode/{id}', [App\Http\Controllers\backend\BooksController::class, 'myqr'])->name('books.qrcode')->middleware('KutuphaneYoneticisi');

    // Rent Routing
    Route::resource('/rents', App\Http\Controllers\backend\RentsController::class)->middleware('KutuphaneYoneticisi');
    Route::post('/rents/check/{id}', [App\Http\Controllers\backend\RentsController::class, 'check'])->name('rents.Check')->middleware('KutuphaneYoneticisi');
    Route::post('/rents/getbook/{id}', [App\Http\Controllers\backend\RentsController::class, 'getbook'])->name('rents.GetBook')->middleware('KutuphaneYoneticisi');

    // Textbox içerisinde eski yazarları arama Routing
    Route::post('/books/yazarAra', [\App\Http\Controllers\backend\BooksController::class, 'yazarAra'])->name('books.yazarAra')->middleware('KutuphaneYoneticisi');

    // Textbox içerisinde eski yayınevlerini arama Routing
    Route::post('/books/yayineviAra', [\App\Http\Controllers\backend\BooksController::class, 'yayineviAra'])->name('books.yayineviAra')->middleware('KutuphaneYoneticisi');;

    Route::post('/logout', [\App\Http\Controllers\backend\UserController::class, 'logout'])->name('users.logout');
});

require __DIR__ . '/auth.php';


