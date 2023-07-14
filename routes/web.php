<?php

use Illuminate\Support\Facades\Route;

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

use App\Models\Hotel;

Auth::routes();

// SE  MODIFICARON A [/HOME/] y [/}

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('hoteles');


// RUTAS PARA TODOS SIN EXCEPCION
Route::get('/', function() {
    $hoteles_full = Hotel::get();
        return view('welcome',compact('hoteles_full'));
})->name('home');



// RUTAS PARA USUARIOS Y HOTELES
Route::get('/usuario/{usuario_id}/configuracion/perfil', [App\Http\Controllers\HomeController::class, 'perfil'])->name('perfil');
Route::get('/usuario/{usuario_id}/transacciones/', [App\Http\Controllers\HomeController::class, 'ventas'])->name('ventas');




// RUTAS SOLO PARA USUARIOS
Route::post('/registrar/comentario', [App\Http\Controllers\ResenaController::class, 'store'])->name('comentar');

Route::get('/usuario/{id}/edit/celular', [App\Http\Controllers\PersonaController::class, 'editCelular'])->name('editar-celular');
Route::post('/usuario/{id}/edit/datospersonales', [App\Http\Controllers\PersonaController::class, 'editDatosPersonales'])->name('editar-datos-personales');




// RUTAS SOLO PARA HOTELES
Route::get('/hotel/{ruc_hotel}/{id_user}', [App\Http\Controllers\HotelController::class, 'index'])->name('hotel');

Route::get('/registrar/habitacion', [App\Http\Controllers\HabitacionController::class, 'store'])->name('registrar-habitacion');
Route::post('/registrar/foto', [App\Http\Controllers\FotoController::class, 'store'])->name('registrar-foto');
Route::post('/registrar/reservacion', [App\Http\Controllers\ReservacionController::class, 'store'])->name('concretar-reservacion');

Route::get('/hotel/{id}/edit/titulo', [App\Http\Controllers\HotelController::class, 'editTitulo'])->name('editar-titulo');
Route::get('/hotel/{id}/edit/location', [App\Http\Controllers\HotelController::class, 'editLocation'])->name('editar-lotation');
Route::get('/hotel/{id}/edit/name', [App\Http\Controllers\Controller::class, 'editName'])->name('editar-name');
Route::get('/hotel/{id}/edit/password', [App\Http\Controllers\Controller::class, 'editPassword'])->name('editar-password');
Route::get('/hotel/{id}/edit/telefono', [App\Http\Controllers\HotelController::class, 'editTelefono'])->name('editar-telefono');

Route::get('/graficas', [App\Http\Controllers\HomeController::class, 'graficas'])->name('graficas');




// RUTAS SOLO PARA ADMINISTRADORES
Route::get('/cuentas', [App\Http\Controllers\HomeController::class, 'cuentas'])->name('cuentas');

Route::post('/registar/hotel', [App\Http\Controllers\HotelController::class,'registrar'])->name('registrar_hot');
Route::post('/registar/usuario', [App\Http\Controllers\PersonaController::class,'store'])->name('registrar_usu');
