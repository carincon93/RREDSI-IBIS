<?php

use App\Http\Controllers\ProgramaAcademicoController;
use App\Http\Controllers\FacultdadController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\AmbienteFormacionController;
use App\Http\Controllers\InstitucionEducativaController;
use App\Http\Controllers\GrupoInvestigacionController;
use App\Http\Controllers\EquipoFormacionController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\NodoController;
use App\Http\Controllers\LineaInvestigacionController;
use App\Http\Controllers\SemilleroInvestigacionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductoInvestigacionController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InformacionLegalController;
use App\Http\Controllers\PerfilEmpresaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IdeaEmpresaController;
use App\Http\Controllers\ObservatorioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\BuscarProveedorController;
use App\Http\Controllers\ExperienciaController;
use App\Http\Controllers\ProyectoEmpresaController;
use App\Http\Controllers\ConvocatoriaController;
use App\Http\Controllers\EventoRredsiDepartamentalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\EnteGubernamentalController;
use App\Http\Controllers\DependenciaController;
use App\Models\Proyecto;
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

Route::get('/', function () {
    return redirect('login');
});

// Deshabilitar la ruta de registro
Route::match(['get', 'post'], 'register', function () {
    return redirect('/');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {
        return redirect('home');
    });

    Route::get('home', [HomeController::class, 'index'])->name('home');

    // ruta para acceder al dashboard del usuario tipo empresa //
    Route::get('/dashboard-empresa', [AppController::class, 'dashboardEmpresa'])->name('dashboard-empresa');

    // ruta para acceder al observatorio //
    Route::get('/observatorio-empresarial', [AppController::class, 'observatorioEmpresarial'])->name('observatorio-empresarial');
    // ruta para acceder al observatorio //
    Route::post('/observatorio-resultados-busqueda', [ObservatorioController::class, 'result'])->name('observatorio-resultados-busqueda');

    Route::get('/eventos-academicos/{evento}', [AppController::class, 'showEventoAcademico'])->name('eventos-academicos.show');
    Route::get('/eventos-academicos', [AppController::class, 'eventosAcademicos'])->name('eventos-academicos.index');

    Route::get('/ideas-empresa/ideas-y-retos', [IdeaEmpresaController::class, 'ideasRetos'])->name('ideas-empresa.ideas-retos');

    Route::get('/experiencias/buscar-experiencias', [ExperienciaController::class, 'buscarExperiencias'])->name('experiencias.buscar-experiencias');

    Route::get('/productos/buscar-proveedores', [ProductoController::class, 'buscarProveedores'])->name('productos.buscar-proveedores');

    // ruta para ver cada solicitud de participacion expecifica para aceptar o denegar participacion en proyecto //
    Route::get('/solicitud/{id}', [NotificationController::class, 'showRequest'])->name('solicitudes.show');
    // rutas de solicitudes de participacion en proyectos para el delegado de institucion//
    Route::get('/solicitud-participacion-proyecto', [NotificationController::class, 'indexAdminInstitution'])->name('notificaciones.indexAdminInstitution');
    // rutas de solicitudes de participacion de cada estudiante//
    Route::get('/solicitud-rol', [NotificationController::class, 'indexSolicitudesEstudiante'])->name('notificaciones.indexSolicitudesEstudiante');
    // ruta para cambiar a leida notificaicon de correo//
    Route::get('/notificaciones/marcar-como-leida/{id}', [NotificationController::class, 'marcarNotificacionLeida'])->name('notificaciones.marcarNotificacionLeida');
    // ruta para envio de notificacion de participacion en proyecto //
    Route::post('/notificaciones/enviar-solicitud-participacion', [NotificationController::class, 'solicitudParticipacionProyecto'])->name('notificaciones.participacion-proyecto');
    // ruta para envio de notificacion de participacion de proyecto en un evento//
    Route::post('/notificaciones/enviar-proyecto-evento', [NotificationController::class, 'sendProyectoToEvento'])->name('notificaciones.sendProyectoToEvento');
    // ruta para envio de notificacion de participacion aceptar o denegar estudiante en proyecto //
    Route::post('/notificaciones/to-accept-student', [NotificationController::class, 'aceptarEstudianteProyecto'])->name('notificaciones.aceptar-estudiante-proyecto');
    // ruta para envio de interes de proyecto //
    Route::post('/notificaciones/interes/{id}', [NotificationController::class, 'interes'])->name('notificaciones.interes');
    // ruta para envio de notificaciones sobre la generación de una idea empresarial //
    Route::post('/notificaciones/new-empresa-idea/{id}', [NotificationController::class, 'newEmpresaIdea'])->name('notificaciones.new-empresa-idea');

    // rutas de la información legal de la plataforma//
    Route::resource('informacion-legal', InformacionLegalController::class)->parameters(['informacion-legal' => 'informacion-legal']);
    // rutas para el observatorio de proyectos//
    Route::resource('observatorio', ObservatorioController::class)->parameters(['observatorio' => 'observatorio']);
    // ruta para el perfil empresarial //
    Route::resource('perfil-empresa', PerfilEmpresaController::class)->parameters(['perfil-empresa' => 'empresa']);
    // rutas para acceder a mis ideas empresariales
    Route::resource('ideas-empresa', IdeaEmpresaController::class)->parameters(['ideas-empresa' => 'idea-empresa']);
    // rutas de notificaciones //
    Route::resource('notificaciones', NotificationController::class)->parameters(['notificaciones' => 'notificacion']);

    // ruta para acceder a mis productos y servicios //
    Route::resource('productos', ProductoController::class)->parameters(['productos' => 'producto']);
    // ruta para acceder a mis productos y servicios //
    Route::get('/buscar-proveedores/{producto}', [BuscarProveedorController::class, 'show'])->name('buscar-proveedores.show');
    Route::resource('buscar-proveedores', BuscarProveedorController::class)->parameters(['buscar-proveedores' => 'buscar-proveedor'])->only('index');
    // ruta para acceder a mis experiencias//
    Route::resource('experiencias', ExperienciaController::class)->parameters(['experiencias' => 'experiencia']);
    // rutas para acceder a los intereses de proyectos //
    Route::resource('proyectos-empresa', ProyectoEmpresaController::class)->except(['create', 'edit', 'destroy'])->parameters(['proyectos-empresa' => 'proyecto-empresa']);
    // rutas para acceder a las convocatorias //
    Route::resource('convocatorias', ConvocatoriaController::class)->parameters(['convocatorias' => 'convocatoria']);
    // rutas para acceder a las respuestas //
    Route::resource('respuestas', RespuestaController::class)->parameters(['respuestas' => 'respuesta']);


    Route::get('/web-api/proyectos/{proyecto}/autores', function (Proyecto $proyecto) {
        return response(['autores' => $proyecto->autores()->get()]);
    })->name('web-api.autores');

    /**
     * Explorador del nodo
     *
     */

    Route::get('/nodos/{nodo}/explorer', [AppController::class, 'explorer'])->name('nodos.explorer');

    // ruta para ver los proyectos activos
    Route::get('/nodos/{nodo}/explorer/proyectos', [AppController::class, 'searchProyectos'])->name('nodos.explorer.busqueda-proyectos');
    Route::get('/nodos/{nodo}/explorer/proyectos/{proyecto}', [AppController::class, 'showProyecto'])->name('nodos.explorer.busqueda-proyectos.ver-proyecto');

    // ruta para ver los eventos
    Route::get('/nodos/{nodo}/explorer/evento-rredsi-departamental/{evento_rredsi_departamental}', [AppController::class, 'showEventoRredsiDepartamental'])->name('nodos.explorer.eventos.ver-evento-departamental');

    Route::get('/nodos/{nodo}/explorer/eventos', [AppController::class, 'eventos'])->name('nodos.explorer.eventos');
    Route::get('/nodos/{nodo}/explorer/eventos/{evento}', [AppController::class, 'showEvento'])->name('nodos.explorer.eventos.ver-evento');

    // explorador de roles
    Route::get('/nodos/{nodo}/explorer/roles', [AppController::class, 'roles'])->name('nodos.explorer.roles');
    Route::get('/nodos/{nodo}/explorer/roles/detalles/{programa_academico}', [AppController::class, 'searchRoles'])->name('nodos.explorer.rol-programa');
    Route::get('/nodos/{nodo}/explorer/roles/detalles-rol/{user}', [AppController::class, 'showUser'])->name('nodos.explorer.buscar-roles.detalles');

    // ruta para ver los ambientes de formación
    Route::get('/nodos/{nodo}/explorer/ambientes-formacion', [AppController::class, 'searchambientesFormacion'])->name('nodos.explorer.busqueda-ambientes');
    Route::get('/nodos/{nodo}/explorer/ambientes-formacion/{ambienteFormacion}', [AppController::class, 'showAmbienteFormacion'])->name('nodos.explorer.busqueda-ambientes.ver-ambiente');

    // ruta para ver los equipos de formación
    Route::get('/nodos/{nodo}/explorer/equipos-formacion', [AppController::class, 'searchEquiposFormacion'])->name('nodos.explorer.busqueda-equipos');
    Route::get('/nodos/{nodo}/explorer/equipos-formacion/{equipoFormacion}', [AppController::class, 'showEquipoFormacion'])->name('nodos.explorer.busqueda-equipos.ver-equipo');

    /**
     * Nodos
     *
     */
    Route::resource('nodos', NodoController::class)->parameters(['nodos' => 'nodo']);

    /**
     * Nodos
     *
     */
    Route::get('nodos/{nodo}/eventos-rredsi-departamental/{evento_rredsi_departamental}/inscritos/{inscritoId}/edit', [EventoRredsiDepartamentalController::class, 'editarInscrito'])->name('nodos.eventos-rredsi-departamental.inscritos.editar');
    Route::get('nodos/{nodo}/eventos-rredsi-departamental/{evento_rredsi_departamental}/inscritos/{inscritoId}', [EventoRredsiDepartamentalController::class, 'detallesInscrito'])->name('nodos.eventos-rredsi-departamental.inscritos.detalles');
    Route::get('nodos/{nodo}/eventos-rredsi-departamental/{evento_rredsi_departamental}/inscritos', [EventoRredsiDepartamentalController::class, 'inscritos'])->name('nodos.eventos-rredsi-departamental.inscritos');
    Route::get('nodos/{nodo}/eventos-rredsi-departamental/{evento_rredsi_departamental}/registro', [EventoRredsiDepartamentalController::class, 'showRegistro'])->name('nodos.eventos-rredsi-departamental.registro');
    Route::post('nodos/{nodo}/eventos-rredsi-departamental/{evento_rredsi_departamental}/registro', [EventoRredsiDepartamentalController::class, 'registrarse'])->name('nodos.eventos-rredsi-departamental.registrarse');
    Route::put('nodos/{nodo}/eventos-rredsi-departamental/{evento_rredsi_departamental}/inscritos/{inscritoId}', [EventoRredsiDepartamentalController::class, 'updateInscrito'])->name('nodos.eventos-rredsi-departamental.inscritos.actualizar-registro');

    Route::resource('nodos.eventos-rredsi-departamental', EventoRredsiDepartamentalController::class)->parameters(['nodos' => 'nodo', 'eventos-rredsi-departamental' => 'evento-rredsi-departamental']);

    /**
     * Eventos
     *
     */
    Route::resource('instituciones-educativas.eventos', EventoController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'eventos' => 'evento']);

    /**
     * Proyectos
     *
     */
    Route::resource('instituciones-educativas.proyectos', ProyectoController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'proyectos' => 'proyecto']);

    /**
     * Productos de investigación
     *
     */
    Route::resource('instituciones-educativas.proyectos.productos-investigacion', ProductoInvestigacionController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'productos-investigacion' => 'producto-investigacion']);

    /**
     * Ambientes de formación
     *
     */
    Route::resource('instituciones-educativas.ambientes-formacion', AmbienteFormacionController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'ambientes-formacion' => 'ambiente-formacion']);

    /**
     * Equipos de formación
     *
     */
    Route::resource('instituciones-educativas.equipos-formacion', EquipoFormacionController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'equipos-formacion' => 'equipo-formacion']);

    /**
     * Líneas de investigación
     *
     */
    Route::resource('instituciones-educativas.lineas-investigacion', LineaInvestigacionController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'facultades' => 'facultad', 'lineas-investigacion' => 'linea-investigacion']);

    /**
     * Semilleros de investigación
     *
     */
    Route::get('instituciones-educativas/{institucion_educativa}/semilleros-investigacion/{semillero_investigacion}/integrantes', [SemilleroInvestigacionController::class, 'integrantes'])->name('instituciones-educativas.semilleros-investigacion.integrantes');
    Route::resource('instituciones-educativas.semilleros-investigacion', SemilleroInvestigacionController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'facultades' => 'facultad', 'semilleros-investigacion' => 'semillero-investigacion']);

    /**
     * Grupos de investigación
     *
     */
    Route::resource('instituciones-educativas.grupos-investigacion', GrupoInvestigacionController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'grupos-investigacion' => 'grupo-investigacion']);

    /**
     * Programas académicos
     *
     */
    Route::resource('instituciones-educativas.programas-academicos', ProgramaAcademicoController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'programas-academicos' => 'programa-academico']);

    /**
     * Facultades
     *
     */
    Route::resource('instituciones-educativas.facultades', FacultdadController::class)->parameters(['instituciones-educativas' => 'institucion-educativa', 'facultades' => 'facultad']);

    /**
     * Instituciones educativas
     *
     */
    Route::resource('instituciones-educativas', InstitucionEducativaController::class)->parameters(['instituciones-educativas' => 'institucion-educativa']);

    /**
     * Roles
     *
     */
    Route::resource('roles', RoleController::class);

    /**
     * Graduaciones
     *
     */
    Route::resource('estudios', EstudioController::class)->parameters(['estudios' => 'estudio']);

    /**
     * Usuarios
     *
     */
    Route::get('/users/actualizar-perfil', [UserController::class, 'perfil'])->name('users.perfil');
    Route::put('/users/actualizar-perfil', [UserController::class, 'actualizarPerfil'])->name('users.actualizar-perfil');

    Route::resource('users', UserController::class);


    /**
     * Ente Gubernamental
     *
     */
    Route::resource('ente-gubernamental', EnteGubernamentalController::class)->parameters(['ente-gubernamental' => 'ente-gubernamental']);

    /**
     * Dependencia de las entidades
     *
     */
    Route::resource('dependencia', DependenciaController::class)->parameters(['dependencia' => 'dependencia']);


});

require __DIR__ . '/auth.php';
