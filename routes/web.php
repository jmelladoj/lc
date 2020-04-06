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

use App\Pagina;

Route::get('/', function () {
    $pagina_nosotros = Pagina::find(1);
    return view('welcome')->with(compact('pagina_nosotros'));
});

Auth::routes();



Route::get('/politicas', 'PaginaController@indexHomePoliticas')->name('Mostrar Página de politicas');
Route::get('/nosotros', 'PaginaController@indexHomeNosotros')->name('Mostrar Página nosotros');
Route::get('/comunidad', 'PaginaController@indexHomeComunidad')->name('Mostrar Página Comunidad');
Route::get('/servicios', 'PaginaController@indexHomeServicios')->name('Mostrar Página Servicios');
Route::get('/busqueda/{id}', 'PaginaController@indexHomeBusqueda')->name('Mostrar Resultados Búsqueda');
Route::get('/contacto', 'PaginaController@indexHomeContacto')->name('Mostrar Página Contacto');
Route::post('/contacto/generar', 'PaginaController@contacto')->name('Generar alerta contácto');
Route::get('/documentos/busqueda/{categoria}', 'DocumentoController@indexBusqueda')->name('Mostrar Resultados Búsqueda por Categoriá');



Route::get('/sliders/comunidad/home', 'SliderComunidadController@indexHome')->name('Listar Sliders Home Comunidad');
Route::get('/sliders/home', 'SliderController@indexHome')->name('Listar Sliders Home');
Route::get('/categorias/home', 'CategoriaDocumentoController@indexHome')->name('Listar Categorias Home');
Route::get('/sliders/ubicacion/{ubicacion}', 'SliderController@indexUbicacion')->name('Listar Sliders Por Ubicacion');
Route::get('/documentos/tipo/{tipo}', 'DocumentoController@indexHome')->name('Listar Documentos Por Tipo');
Route::get('/usuario/{id}', 'UsuarioController@especifico')->name('Listar Usuario Especifico');
Route::get('/usuarios/pymes/{tipo}', 'UsuarioController@indexPymes')->name('Listar Usuarios pymes');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/intranet/{ubicacion}', 'PaginaController@index_intranet')->name('index intranet');

//Rutas de sliders
Route::get('/sliders', 'SliderController@index')->name('Listar Sliders');
Route::post('/slider/crear/actualizar', 'SliderController@crearOactualizar')->name('Crear o Actualizar Sliders');
Route::post('/slider/eliminar', 'SliderController@eliminar')->name('Borrar Slider');
Route::post('slider/ubicaciones/actualizar', 'SliderController@ubicaciones')->name('Actualizar Ubicaciones');

//Rutas de avatares
Route::get('/avatares', 'AvatarController@index')->name('Listar avatares');
Route::post('/avatar/crear/actualizar', 'AvatarController@crearOactualizar')->name('Crear o Actualizar avatares');
Route::post('/avatar/eliminar', 'AvatarController@eliminar')->name('Borrar avatar');

//Rutas de páginas
Route::get('/pagina/nosotros', 'PaginaController@indexNosotros')->name('Listar Nosotros');
Route::get('/pagina/comunidad', 'PaginaController@indexComunidad')->name('Listar Comunidad');
Route::get('/pagina/servicios/mensaje', 'PaginaController@indexServicios')->name('Listar Servicios');
Route::get('/pagina/registro', 'PaginaController@indexLogin')->name('Listar Registro');
Route::get('/general', 'GeneralController@indexGeneral')->name('Listar General');
Route::post('/general/actualizar', 'GeneralController@actualizar')->name('Actualizar página general');
Route::post('/pagina/nosotros/actualizar', 'PaginaController@actualizarNosotros')->name('Actualizar página nosotros');
Route::post('/pagina/comunidad/actualizar', 'PaginaController@actualizarComunidad')->name('Actualizar página comunidad');
Route::post('/pagina/servicios/actualizar', 'PaginaController@actualizarServicios')->name('Actualizar página servicios');
Route::post('/pagina/login/actualizar', 'PaginaController@actualizarLogin')->name('Actualizar página login');
Route::post('/pagina/comunidad/alerta', 'PaginaController@alerta')->name('Alertas');
Route::post('/pagina/video/eliminar', 'PaginaController@eliminar_video')->name('Listar Nosotros');
Route::get('/pagina/home/usuario', 'PaginaController@index_home_usuario')->name('Listar Nosotros');
Route::post('pagina/home/usuario/actualizar', 'PaginaController@actualizar_home_usuario')->name('Listar Nosotros');

//Rutas de servicios
Route::get('/pagina/servicios/intranet', 'ServicioController@index')->name('Listar Servicios');
Route::post('/pagina/servicio/crear/actualizar', 'ServicioController@crearOactualizar')->name('Crear o Actualizar Servicio');
Route::post('/pagina/servicio/eliminar', 'ServicioController@eliminar')->name('Borrar Servicio');
Route::get('/pagina/subservicios/{id}', 'ServicioController@index_subservicios')->name('Listar Servicios');
Route::post('/pagina/subservicio/crear/actualizar', 'ServicioController@crear_actualizar_sub_servicio')->name('Crear o Actualizar Servicio');
Route::post('/pagina/subservicio/eliminar', 'ServicioController@eliminar_sub_servicio')->name('Borrar Servicio');


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
Route::get('/documentos/{tipo}', 'DocumentoController@index')->name('Listar Documentos');
Route::post('/documento/crear/actualizar', 'DocumentoController@crearOactualizar')->name('Crear o Actualizar Documentos');
Route::post('/documento/restaurar', 'DocumentoController@restaurar')->name('Resturar Documentos');
Route::post('/documento/eliminar', 'DocumentoController@eliminar')->name('Borrar Documento');
Route::get('/documento/descargar/{id}' , 'DocumentoController@descargar')->name('Descargar Documento');
Route::get('/documentos/busqueda/{busqueda}' , 'DocumentoController@buscar')->name('Buscar Documentos');

//Rutas de categorías de usuario
Route::get('/categorias/usuario', 'CategoriaUsuarioController@index')->name('Listar Categorias Usuario');
Route::post('/categoria/usuario/crear/actualizar', 'CategoriaUsuarioController@crearOactualizar')->name('Crear o Actualizar Categorias Usuario');
Route::post('/categoria/usuario/restaurar', 'CategoriaUsuarioController@restaurar')->name('Resturar Categoria Usuario');
Route::post('/categoria/usuario/eliminar', 'CategoriaUsuarioController@eliminar')->name('Borrar Categoria Usuario');

//Rutas de tips
Route::get('/tips', 'TipController@index')->name('Listar tips');
Route::post('/tip/crear/actualizar', 'TipController@crearOactualizar')->name('Crear o Actualizar tips');
Route::post('/tip/eliminar', 'TipController@eliminar')->name('Eliminar Tip');

//Rutas de usuarios
Route::get('/usuarios/{tipo}', 'UsuarioController@index')->name('Listar usuarios');
Route::get('/usuario/valoraciones/{id}', 'UsuarioController@valoraciones')->name('Listar usuarios');

Route::post('/usuario/crear/actualizar', 'UsuarioController@crearOactualizar')->name('Crear o Actualizar usuarios');
Route::post('/usuario/restaurar', 'UsuarioController@restaurar')->name('Resturar Usuario');
Route::post('/usuario/eliminar', 'UsuarioController@eliminar')->name('Eliminar usuario');
Route::post('usuario/actualizar/imagen', 'UsuarioController@imagen')->name('Actualizar foto de usuario');

Route::post('/usuario/saldo', 'UsuarioController@saldo')->name('Agregar saldo');
Route::get('/usuario/saldo/disponible', 'UsuarioController@saldo_disponible')->name('Obtener saldo disponible');
Route::post('/usuario/blacklist/agregar', 'UsuarioController@blacklistAgregar')->name('Agregar a black list');
Route::post('/usuario/blacklist/quitar', 'UsuarioController@blacklistQuitar')->name('Agregar a black list');
Route::post('/usuario/actualizar/tabla/vip', 'UsuarioController@actualizar_usuario_tabla_vip')->name('Actualizar usuario tabla vip');

Route::post('/usuario/tabla/vip/quitar', 'UsuarioController@quitarTablaVip')->name('Tabla VIP');
Route::post('/usuario/tabla/vip/agregar', 'UsuarioController@agregarTablaVip')->name('Tabla VIP');

Route::post('/usuario/comunidad/quitar', 'UsuarioController@quitarComunidadPyme')->name('Tabla comunidad pyme');
Route::post('/usuario/comunidad/agregar', 'UsuarioController@agregarComunidadPyme')->name('Tabla comunidad pyme');
Route::get('/usuarios/tabla/vip', 'UsuarioController@usuariosTablaVip')->name('Usuario Tabla vip');
Route::get('/usuarios/tabla/comunidad', 'UsuarioController@usuariosTablaComunidad')->name('Usuario Tabla comunidad');
Route::post('/usuario/tabla/comunidad', 'UsuarioController@usuario_tabla_comunidad')->name('Usuario Tabla comunidad');
Route::post('/usuario/tabla/vip', 'UsuarioController@usuario_tabla_vip')->name('Usuario Tabla vip');
Route::post('/usuario/actualizar/avatar', 'UsuarioController@actualizar_avatar')->name('Usuario avatar');
Route::post('usuario/crear/actualizar/archivo', 'UsuarioController@actualizar_archivo_usuario')->name('Usuario archivo');



Route::post('/usuario/recuperar/password', 'UsuarioController@recuperar')->name('Recuperar contraseña');


//Rutas de sliders
Route::get('/sorteos/{tipo}', 'SorteoController@index')->name('Listar Sorteos');
Route::post('/sorteo/crear/actualizar', 'SorteoController@crearOactualizar')->name('Crear o Actualizar Sorteos');
Route::post('/sorteo/eliminar', 'SorteoController@eliminar')->name('Borrar Sorteos');
Route::post('/sorteo/concursar', 'SorteoController@concursar')->name('Concursar Sorteos');

//Rutas de promociones
Route::get('/promociones/{tipo}', 'PromocionController@index')->name('Listar Promociones');
Route::post('/promocion/crear/actualizar', 'PromocionController@crearOactualizar')->name('Crear o Actualizar Promociones');
Route::post('/promocion/eliminar', 'PromocionController@eliminar')->name('Borrar Promociones');

//Rutas de mensajes y notificaciones solicitar documento
Route::post('/solicitar/documento', 'DocumentoController@solicitarDocumento')->name('Solicitar documento');
Route::get('/solicitudes/documento', 'SolicitudDocumentoController@index')->name('Listar solicitudes documento');

//Rtuas de mensajes y notificaciones invitar amigo
Route::post('/invitar', 'UsuarioController@invitar_amigo')->name('Invitar amigo');


Route::get('/asesorias/{tipo}', 'AsesoriaController@index')->name('Listar asesorias');
Route::post('/solicitar/asesoria', 'UsuarioController@solicitarAsesoria')->name('Solicitar Asesoria');
Route::post('/asesoria/estado', 'AsesoriaController@estado_asesoria')->name('Estado Asesoria');

//Rutas de rubros
Route::get('/rubros/{tipo}', 'RubroController@index')->name('Listar Rubros');
Route::post('/rubro/crear/actualizar', 'RubroController@crearOactualizar')->name('Crear o Actualizar Rubros');
Route::post('/rubro/restaurar', 'RubroController@restaurar')->name('Resturar Rubro');
Route::post('/rubro/eliminar', 'RubroController@eliminar')->name('Borrar Rubros');


//Rutas de profesiones u oficios
Route::get('/profesiones/oficios/{tipo}', 'ProfesionController@index')->name('Listar Profesiones u Oficios');
Route::post('/profesion/oficio/crear/actualizar', 'ProfesionController@crearOactualizar')->name('Crear o Actualizar Profesiones u Oficios');
Route::post('/profesion/oficio/restaurar', 'ProfesionController@restaurar')->name('Resturar Profesiones u Oficios');
Route::post('/rubro/eliminar', 'ProfesionController@eliminar')->name('Borrar Profesiones u Oficios');

//Rutas de comunas
Route::get('/comunas', 'ComunaController@index')->name('Listar Comunas');
Route::get('/regiones', 'ComunaController@index_regiones')->name('Listar regiones');

//Rutas de notificaciones
Route::get('/notificaciones/{tipo}', 'NotificacionController@index')->name('Listar notificaciones');
Route::post('/notificacion/leer', 'NotificacionController@leer')->name('Leer notificaciones');

//Rutas de promociones
Route::get('/seminarios/{tipo}', 'SeminarioController@index')->name('Listar Seminarios');
Route::post('/seminario/crear/actualizar', 'SeminarioController@crearOactualizar')->name('Crear o Actualizar Seminarios');
Route::post('/seminario/eliminar', 'SeminarioController@eliminar')->name('Borrar Seminarios');
Route::post('/seminario/participar', 'SeminarioController@participar')->name('Participar Seminario');
Route::get('/seminario/participantes/{id}', 'SeminarioController@indexParticipantes')->name('Ver participantes');

//Rutas de valoracion
Route::post('/valorar/pyme', 'ValoracionController@valorar')->name('Valorar Pyme');
Route::post('/valorar/borrar', 'ValoracionController@borrar')->name('Borrar comentario Pyme');

//Rutas de link de interés
Route::get('/sitios', 'InteresController@index')->name('Listar sitios de interes');
Route::post('/sitio/crear/actualizar', 'InteresController@crearOactualizar')->name('Crear o Actualizar sitios de interes');
Route::post('/sitio/eliminar', 'InteresController@eliminar')->name('Borrar sitios de interes');

//Rutas de sliders
Route::get('/sliders/comunidad', 'SliderComunidadController@index')->name('Listar Sliders comunidad');
Route::post('/slider/comunidad/crear/actualizar', 'SliderComunidadController@crearOactualizar')->name('Crear o Actualizar Sliders comunidad');
Route::post('/slider/comunidad/eliminar', 'SliderComunidadController@eliminar')->name('Borrar Slider comunidad');

//Rutas de informes
Route::get('/informe/venta/contenido', 'InformeController@ventaContenido')->name('Listar informe venta contenido');
Route::get('/informe/clientes/activos', 'InformeController@clientesActivos')->name('Listar informe clientes activos');

//Rutas de ventas
Route::get('/ventas/{tipo}','VentaController@index')->name('Listar recargas');
Route::post('/venta/carga','VentaController@recargar')->name('Realizar carga');

Route::post('/venta/procesar','VentaController@procesar')->name('Procesar carga');
Route::post('/venta/finalizar','VentaController@finalizar')->name('Procesar carga');

Route::get('/cambio/usuario/{tipo}', 'UsuarioController@cambio_tipo_usuario')->name('Cambiar tipo de usuario');







