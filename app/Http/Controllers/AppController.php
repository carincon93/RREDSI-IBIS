<?php

namespace App\Http\Controllers;

use App\Models\Nodo;
use App\Models\User;
use App\Models\AreaConocimiento;
use App\Models\Proyecto;
use App\Models\Evento;
use App\Models\InformacionLegal;
use App\Models\AmbienteFormacion;
use App\Models\EquipoFormacion;
use App\Models\EventoRredsiDepartamental;
use App\Models\Estudio;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController extends Controller
{
    /**
     * Display the dashboard company view
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboardEmpresa()
    {
        return Inertia::render('DashboardEmpresa/Index', [
            'proyectos' => Proyecto::with('facultad.institucionEducativa')->where('proyectos.privado', false)->filterProyecto(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Display the dashboard company view
     *
     * @return \Illuminate\Http\Response
     */
    public function observatorioEmpresarial(Nodo $nodo)
    {
        return Inertia::render('DashboardEmpresa/ObservatorioEmpresarial', [
            'nodo'      => $nodo,
            'proyectos' => Proyecto::with('facultad.institucionEducativa')->where('proyectos.privado', false)->filterProyecto(request()->only('search'))->paginate(),

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function showEventoAcademico(Evento $evento)
    {
        $evento->institucionEducativa;

        return Inertia::render('DashboardEmpresa/DetallesEvento', [
            'evento' => $evento
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function eventosAcademicos()
    {
        return Inertia::render('DashboardEmpresa/EventosAcademicos', [
            'eventos' => Evento::with('institucionEducativa')->filterEvento(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function explorer(Nodo $nodo)
    {
        $nodo->institucionesEducativas;
        $nodo->proyectosAleatorios         = $nodo->shuffleProyectos();
        $nodo->eventosInstitucionEducativa = $nodo->shuffleEventosInstitucionesEducativas()->shuffle()->take(2);

        return Inertia::render('Explorer/Index', [
            'currentYear'               => date('Y'),
            'nodo'                      => $nodo,
            'areasConocimiento'         => AreaConocimiento::orderBy('nombre')->get(),
            'informacionLegal'          => InformacionLegal::orderBy('titulo')->get(),
            'eventoRredsiDepartamental' => EventoRredsiDepartamental::where('nodo_id', $nodo->id)->where('estado', true)->first()
        ]);
    }

    /**
     * Display roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function roles(Nodo $nodo)
    {
        $nodo->institucionesEducativas;

        return Inertia::render('Explorer/Roles/Index', [
            'nodo'      => $nodo,
            'estudios'  => Estudio::select('estudios.programa_academico')->join('users', 'estudios.user_id', 'users.id')->join('instituciones_educativas', 'users.institucion_educativa_id', 'instituciones_educativas.id')->where('instituciones_educativas.nodo_id', $nodo->id)->get()
        ]);
    }

    /**
     * Display roles by academic program and institución educativa.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchRoles(Nodo $nodo, $programaAcademico)
    {
        return Inertia::render('Explorer/Roles/Resultados', [
            'nodo'              => $nodo,
            'programaAcademico' => $programaAcademico,
            'estudiantes'       => User::whereHas('estudios', function ($query) use ($programaAcademico) {
                $query->where('estudios.programa_academico', 'LIKE', '%' . $programaAcademico . '%');
            })->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUser(Nodo $nodo, User $user)
    {
        $user->proyectos;
        $user->institucionEducativa;
        $user->estudios;
        $user->semillerosInvestigacion;

        return Inertia::render('Explorer/Roles/Show', [
            'nodo'  => $nodo,
            'user'  => $user
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchProyectos(Request $request, Nodo $nodo)
    {
        $search = str_replace("=", "", $request->get('searchInputProyecto'));

        return Inertia::render('Explorer/ResultadosProyectos/Index', [
            'nodo'          => $nodo,
            'proyectos'     => Proyecto::searchProyectos($search, $nodo)->get(),
            'searchWord'    => $search,
            'allKeywords'   => Proyecto::allKeywords($nodo)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProyecto(Nodo $nodo, Proyecto $proyecto)
    {
        $this->authorize('view', [Proyecto::class, $proyecto->facultad->institucionEducativa, $proyecto]);

        $proyecto->facultad->institucionEducativa;
        $proyecto->disciplinasSubareaConocimiento;
        $proyecto->lineasInvestigacion;
        $proyecto->semillerosInvestigacion;
        $proyecto->programasAcademicos;
        $proyecto->tipoProyecto;
        $proyecto->autores;
        $proyecto->proyectosEmpresa;

        return Inertia::render('Explorer/ResultadosProyectos/Show', [
            'nodo'      => $nodo,
            'proyecto'  => $proyecto
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchAmbientesFormacion(Request $request, Nodo $nodo)
    {
        $search = str_replace("=", "", $request->get('searchInputAmbiente'));

        return Inertia::render('Explorer/ResultadosAmbientesFormacion/Index', [
            'nodo'                  => $nodo,
            'ambientesFormacion'    => AmbienteFormacion::searchAmbientesFormacion($search)->get(),
            'search'                => $search
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAmbienteFormacion(Nodo $nodo, AmbienteFormacion $ambienteFormacion)
    {
        $ambienteFormacion->facultad->institucionEducativa;
        $ambienteFormacion->disciplinasSubareaConocimiento;

        return Inertia::render('Explorer/ResultadosAmbientesFormacion/Show', [
            'nodo'              => $nodo,
            'ambienteFormacion' => $ambienteFormacion
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchEquiposFormacion(Request $request, Nodo $nodo)
    {
        $search = str_replace("=", "", $request->get('searchInputEquipo'));

        return Inertia::render('Explorer/ResultadosEquiposFormacion/Index', [
            'nodo'              => $nodo,
            'equiposFormacion'  => EquipoFormacion::searchEquiposFormacion($search)->get(),
            'search'            => $search
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showEquipoFormacion(Nodo $nodo, EquipoFormacion $equipoFormacion)
    {
        $equipoFormacion->facultad;
        $equipoFormacion->disciplinasSubareaConocimiento;
        $equipoFormacion->facultad->institucionEducativa->delegado;

        return Inertia::render('Explorer/ResultadosEquiposFormacion/Show', [
            'nodo'              => $nodo,
            'equipoFormacion'   => $equipoFormacion
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function eventos(Request $request, Nodo $nodo)
    {
        $nodo->load('institucionesEducativas.eventos');

        return Inertia::render('Explorer/Eventos/Index', [
            'nodo'          => $nodo,
            'currentYear'   => date('Y')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function showEvento(Request $request, Nodo $nodo, Evento $evento)
    {
        $evento->institucionEducativa;

        return Inertia::render('Explorer/Eventos/Show', [
            'nodo'      => $nodo,
            'evento'    => $evento
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function showEventoRredsiDepartamental(Request $request, Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental)
    {
        $eventoRredsiDepartamental->institucionEducativa;

        return Inertia::render('Explorer/Eventos/ShowEventoRredsiDepartamental', [
            'nodo'                          => $nodo,
            'eventoRredsiDepartamental'     => $eventoRredsiDepartamental
        ]);
    }
}
