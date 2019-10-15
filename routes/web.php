<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/sliders/home', 'SliderController@indexHome')->name('Listar Sliders Home');

Route::get('/home', 'HomeController@index')->name('home');

//Rutas de sliders
Route::get('/sliders', 'SliderController@index')->name('Listar Sliders');
Route::post('/slider/crear/actualizar', 'SliderController@crearOactualizar')->name('Crear o Actualizar Sliders');
Route::post('/slider/eliminar', 'SliderController@eliminar')->name('Borrar Slider');
Route::post('slider/ubicaciones/actualizar', 'SliderController@ubicaciones')->name('Actualizar Ubicaciones');

//Rutas de páginas
Route::get('/nosotros', 'PaginaController@indexNosotros')->name('Listar Nosotros');
Route::get('/comunidad', 'PaginaController@indexComunidad')->name('Listar Comunidad');
Route::get('/servicios/mensaje', 'PaginaController@indexServicios')->name('Listar Servicios');
Route::get('/registro', 'PaginaController@indexLogin')->name('Listar Registro');
Route::post('/general/actualizar', 'GeneralController@actualizar')->name('Actualizar página general');
Route::post('/nosotros/actualizar', 'PaginaController@actualizarNosotros')->name('Actualizar página nosotros');
Route::post('/comunidad/actualizar', 'PaginaController@actualizarComunidad')->name('Actualizar página comunidad');
Route::post('/servicios/actualizar', 'PaginaController@actualizarServicios')->name('Actualizar página servicios');
Route::post('/login/actualizar', 'PaginaController@actualizarLogin')->name('Actualizar página login');

//Rutas de servicios
Route::get('/servicios', 'ServicioController@index')->name('Listar Servicios');
Route::post('/servicio/crear/actualizar', 'ServicioController@crearOactualizar')->name('Crear o Actualizar Servicio');
Route::post('/servicio/eliminar', 'ServicioController@eliminar')->name('Borrar Servicio');

//Rutas de categorías
Route::get('/categorias', 'CategoriaDocumentoController@index')->name('Listar Categorias');
Route::post('/categoria/crear/actualizar', 'CategoriaDocumentoController@crearOactualizar')->name('Crear o Actualizar Categorias');
Route::post('/categoria/restaurar', 'CategoriaDocumentoController@restaurar')->name('Resturar Categoria');
Route::post('/categoria/eliminar', 'CategoriaDocumentoController@eliminar')->name('Borrar Categoria');

//Rutas de subcategorias
Route::get('/subcategorias/{id}', 'SubCategoriaDocumentoController@index')->name('Listar SubCategorias');
Route::post('/subcategoria/crear/actualizar', 'SubCategoriaDocumentoController@crearOactualizar')->name('Crear o Actualizar SubCategorias');
Route::post('/subcategoria/restaurar', 'SubCategoriaDocumentoController@restaurar')->name('Resturar SubCategoria');
Route::post('/subcategoria/eliminar', 'SubCategoriaDocumentoController@eliminar')->name('Borrar SubCategoria');

//Rutas de doocumentos
Route::get('/documentos/{estado}', 'DocumentoController@index')->name('Listar Documentos');
Route::post('/documento/crear/actualizar', 'DocumentoController@crearOactualizar')->name('Crear o Actualizar Documentos');
Route::post('/documento/restaurar', 'DocumentoController@restaurar')->name('Resturar Documentos');
Route::post('/documento/eliminar', 'DocumentoController@eliminar')->name('Borrar Documento');

//Rutas de categorías de usuario
Route::get('/categorias/usuario', 'CategoriaUsuarioController@index')->name('Listar Categorias Usuario');
Route::post('/categoria/usuario/crear/actualizar', 'CategoriaUsuarioController@crearOactualizar')->name('Crear o Actualizar Categorias Usuario');
Route::post('/categoria/usuario/restaurar', 'CategoriaUsuarioController@restaurar')->name('Resturar Categoria Usuario');
Route::post('/categoria/usuario/eliminar', 'CategoriaUsuarioController@eliminar')->name('Borrar Categoria Usuario');