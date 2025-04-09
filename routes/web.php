<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PermissionController;
use App\Http\Controllers\auth\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MercaderiaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\VentaDetalleController;
use App\Http\Controllers\ProveedorController;
use App\Models\Venta;
use Illuminate\Auth\Events\Login;
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

// Route to handle page reload in Vue except for api routes
/*Route::get('/', function () {
    return view('welcome');
})->name('dashboard')->middleware('auth');//->where('any', '^(?!api\/)[\/\w\.-]*');
*/

Route::middleware("auth")->group(function(){
    Route::get('/',[HomeController::class, 'index']);
    //function(){return view('/welcome');});
});

Route::prefix('auth')->group(function(){
    Route::get('login',[LoginController::class,'index'])->name('login');
    Route::post('logout',[LoginController::class,'logout'])->name('logout');
    Route::post('login',[LoginController::class,'login']);
    Route::get('register',[RegisterController::class,'create']);
    Route::post('register',[RegisterController::class,'store']);
});

//Protegidas;
/*Route::middleware('auth')->group(function(){
    Route::get('dashboard',function(){
       return view('welcome');
    })->name('dashboard'); 
});*/

/**Autenticacion */
//Route::get('/', [HomeController::class, 'index']);
/*Route::get('/login', [SessionController::class,'create'])->name('login.index');
Route::post('/login', [SessionController::class,'store'])->name('login.store');
Route::post('/logout', [SessionController::class,'logout'])->name('login.logout');
Route::get('/register', [RegisterController::class, 'create'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');*/
//**Fin Autenticacion */
Route::middleware("auth")->group(function(){
Route::post('proveedor/getProveedores', [ProveedorController::class, 'getProveedores']);
Route::resource("proveedor", "App\Http\Controllers\ProveedorController");
Route::resource("persona", "App\Http\Controllers\PersonaController");
Route::post('cliente/getClientes', [ClienteController::class, 'getClientes']);
Route::resource("cliente", "App\Http\Controllers\ClienteController");
Route::post('mercaderia/getByCodigo', [MercaderiaController::class, 'getByCodigo']);
Route::post('mercaderia/getMercaderias', [MercaderiaController::class, 'getMercaderias']);
Route::post('mercaderia/getMercaderiaCodigo', [MercaderiaController::class, 'getMercaderiaCodigo']);
Route::resource("mercaderia", "App\Http\Controllers\MercaderiaController");
Route::resource("stock", "App\Http\Controllers\StockController");
Route::resource("caja", "App\Http\Controllers\CajaController");
Route::resource("cajaDetalle", "App\Http\Controllers\CajaDetalleController");
Route::get('reportesVentas', [VentaDetalleController::class, 'reportesVentas']);
Route::post('ventasPorProductos', [VentaDetalleController::class, 'ventasPorProductos']);
Route::resource("venta", "App\Http\Controllers\VentaController");
Route::delete('ventaDetalle/{id}', [VentaDetalleController::class, 'destroy']);
Route::delete('ventaDetalle/borrarItem', [VentaDetalleController::class, 'borrarItem']);
Route::resource("ventaDetalle", "App\Http\Controllers\VentaDetalleController");
Route::resource("compra", "App\Http\Controllers\CompraController");
Route::resource("compraDetalle", "App\Http\Controllers\CompraDetalleController");
Route::resource("gasto", "App\Http\Controllers\GastoController");

});

Route::resource("hosting", "App\Http\Controllers\HostingController");
Route::resource("permissions", PermissionController::class);//"App\Http\Controllers\Auth\PermissionsController"
//Crear ek SIM LINK para acceder a Storage de Laravel
Route::get('storage-link', function(){
    Artisan::call('storage:link');
});
Route::get('optimize', function(){
    Artisan::call('optimize');
    echo "termina optimize";
});

Route::get('optimize-clear', function(){
    Artisan::call('optimize:clear');
    echo "termina optimize clear";
});

Route::get('route-list', function(){
    Artisan::call('route:list');
    echo "termina route_list";
});

/*Route::resource("cobros", "App\Http\Controllers\CobrosCabecerasController");
Route::controller(ArchivoDeudaController::class)->group(function () {
    Route::post('/{id}', 'getSocio')->name('archivoDeuda.getSocio');
    Route::resource("archivoDeuda", "App\Http\Controllers\ArchivoDeudaController");
    //Route::post('/orders', 'store');
});*/
//Route::get('/archivosDeudas/{socio_id}', [\App\Http\Controllers\ArchivoDeudaController::class, 'getSocio']);
//Route::post('/geSocio/{socio_id}', [ArchivoDeudaController::class, 'getSocio']);
/*Route::post('archivoDeudaDetalle/getSocio', [ArchivoDeudaDetalleController::class, 'getSocio']);
Route::post('archivoDeudaDetalle/getSociopordni', [ArchivoDeudaDetalleController::class, 'getSociopordni']);
Route::post('servicio/getServicioPorCod', [ServicioController::class, 'getServicioPorCod']);
Route::get('archivoDeudaDetalle/{archivo_id}/exportar', [ArchivoDeudaDetalleController::class, 'exportar']);
Route::resource("archivoDeuda", "App\Http\Controllers\ArchivoDeudaController");
//Route::post('archivoDeudaDetalle/addArchivoDeuda', [ArchivoDeudaDetalleController::class, 'addArchivoDeuda']);
Route::post('archivoDeudaDetalle/store', [ServicioController::class, 'store']);
Route::resource("archivoDeudaDetalle", "App\Http\Controllers\ArchivoDeudaDetalleController");

Route::resource("servicio", "App\Http\Controllers\ServicioController");
Route::resource("rendicion", "App\Http\Controllers\RendicionController");
Route::resource("rendicionesDetalle", "App\Http\Controllers\RendicionDetalleController");

*/

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
