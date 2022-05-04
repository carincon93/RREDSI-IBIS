<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nodo;
use App\Models\Proyecto;
use App\Models\InstitucionEducativa;
use App\Models\Solicitud;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

use Illuminate\Support\Facades\Notification;

use App\Notifications\NotificacionInvitacionRol;
use App\Notifications\NotificacionGeneral;
use App\Notifications\NotificationParticipacionProyecto;
use App\Notifications\NotificacionRespuestaSolicitud;
use App\Notifications\NotificacionInteres;
use App\Notifications\NotificacionIdeaEmpresa;

class NotificationController extends Controller
{
    // Envio de invitacion para participar en un proyecto
    //esta la envian los autores invitando a participar a un estudiante */
    public function enviarInvitacionEstudiante(Request $request, Nodo $nodo, User $user)
    {
        $proyecto               = Proyecto::findOrFail($request->get('proyecto_id'));
        $semilleroInvestigacion = $proyecto->semillerosInvestigacion()->where('principal', 1)->first();

        $solicitud = new Solicitud();
        $solicitud->user_id        = auth()->user()->id;
        $solicitud->tipo_solicitud = "Invitación de participación en el proyecto $proyecto->titulo";

        $solicitud->save();

        $file = $this->makeDocInvitation($proyecto, $semilleroInvestigacion, $user);
        Notification::send($user, new NotificacionInvitacionRol($nodo, $proyecto, $semilleroInvestigacion, $user, $file));

        return redirect()->back()->with('success', 'Invitación enviada con éxito');
    }

    // Envio de solicitud para participar en un proyecto
    // esta la envia un estudiante a los autores del proyecto para poder participar */
    public function solicitudParticipacionProyecto(Request $request)
    {
        // usuario que envia solicitud
        $authUser = auth()->user();
        // proyecto en el que desea participar
        $proyecto = Proyecto::findOrFail($request->get('proyecto_id'));

        // creamos la nueva solicitud y la guardamos
        $solicitud = new Solicitud();
        $solicitud->user_id        = $authUser->id;
        $solicitud->tipo_solicitud = "Solicitud de participacion en el proyecto $proyecto->titulo";

        $solicitud->save();

        $adminInstitucionEducativa = null;
        if ($authUser->hasRole(4)) {
            $facultad = $authUser->facultades()->where('principal', 1)->first();

            if ($facultad) {
                $nodo                       = $facultad->institucionEducativa->nodo;
                $adminInstitucionEducativa  = $facultad->institucionEducativa->administrador;
            }
        } elseif ($authUser->hasRole(3)) {
            $nodo = $authUser->esAdminInstitucionEducativa->nodo;
            $adminInstitucionEducativa  = $authUser->esAdminInstitucionEducativa->administrador;
        }

        $semilleroInvestigacion = $proyecto->semillerosInvestigacion()->where('principal', 1)->first();
        $autores    = $proyecto->autores;
        $nodo       = $request->nodo;
        $nodo       = json_decode($nodo);

        // notificamos a los autores de la solicitud de participacion
        Notification::send($autores, new NotificationParticipacionProyecto($nodo, $proyecto, $semilleroInvestigacion, $authUser, $solicitud));
        if ($adminInstitucionEducativa) {
            // notificamos a el delegado de la insitucion de la solicitud de participacion
            Notification::send($adminInstitucionEducativa, new NotificationParticipacionProyecto($nodo, $proyecto, $semilleroInvestigacion, $authUser, $solicitud));
        }

        return redirect()->back()->with('success', 'Solicitud enviada con éxito');
    }

    // metodo de solicitud para un proyecto poder ingresar en un evento
    public function sendProyectoToEvento(Request $request)
    {
        $user       = auth()->user();
        $facultad   = $user->facultades()->where('principal', 1)->first();

        if ($facultad) {
            $nodo = $facultad->institucionEducativa->nodo;
            $institucionEducativa = $facultad->institucionEducativa;
            $adminInstitucionEducativa = $institucionEducativa->administrador;
        }

        $proyecto = Proyecto::findOrFail($request->get('proyecto_id'));
        $autores  = $proyecto->autores;

        $proyecto->eventos()->attach($request->get('evento_id'));
        $evento = $proyecto->eventos->find($request->get('evento_id'));

        $tipo = [
            "type" => "registrar un proyecto a un evento",
            "evento_nombre" => $evento->nombre
        ];

        // notificamos a los autores de la participacion del proyecto en el evento
        #Send autores notification
        Notification::send($autores, new NotificacionGeneral($proyecto, $tipo));
        // notificamos a delegado(a) de la institucion del registro del proyecto al evento
        #Send admin institution notification
        Notification::send($adminInstitucionEducativa, new NotificacionGeneral($proyecto, $tipo));

        if ($evento->link_registro) {
            return redirect($evento->link_registro);
        }

        return redirect()->back()->with('success', 'Solicitud enviada con éxito');
    }

    public function makeDocInvitation($proyecto, $semilleroInvestigacion, $user)
    {
        $templateProcessor = new TemplateProcessor(url('/storage/templates/contact-template.docx'));

        $ciudad                 = $semilleroInvestigacion->grupoInvestigacion->facultad->institucionEducativa->ciudad;
        $dateForHumans          = Carbon::parse(date('Y-m-d'), 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
        $nombreAutor            = auth()->user()->name;
        $numeroDocumentoAutor   = auth()->user()->numero_documento;
        $titulo                 = $proyecto->titulo;
        $institucionEducativa   = $semilleroInvestigacion->grupoInvestigacion->facultad->institucionEducativa->nombre;
        $nombre                 = $user->name;
        $semilleroInvestigacion = $semilleroInvestigacion->nombre;
        $numeroDocumento        = $user->numero_documento;
        $url                    = url('/');

        $templateProcessor->setValue('titulo', $titulo);
        $templateProcessor->setValue('ciudad', $ciudad);
        $templateProcessor->setValue('dateForHumans', $dateForHumans);
        $templateProcessor->setValue('nombreAutor', $nombreAutor);
        $templateProcessor->setValue('semilleroInvestigacion', $semilleroInvestigacion);
        $templateProcessor->setValue('numeroDocumentoAutor', $numeroDocumentoAutor);
        $templateProcessor->setValue('institucionEducativa', $institucionEducativa);
        $templateProcessor->setValue('nombre', $nombre);
        $templateProcessor->setValue('numeroDocumento', $numeroDocumento);
        $templateProcessor->setValue('url', $url);

        $appName        = config('app.name');
        $year           = date('Y');
        $fileName       = "$appName-$proyecto->id-$year-$numeroDocumento.docx";
        $storagePath    = storage_path("app/public/solicitudes-rol/$fileName");

        if (!Storage::disk('public')->exists("/solicitudes-rol/$fileName")) {
            $templateProcessor->saveAs($storagePath);
        }

        return $storagePath;
    }

    // index de notificaciones
    public function index()
    {
        $user = auth()->user();

        return view('MiembrosFacultad.index-notifications', compact('user'));
    }

    public function indexAdminInstitution()
    {
        $user        = auth()->user();
        $solicitudes = Solicitud::where('user_id', $user->id)->get();

        return view('MiembrosFacultad.index-admin-institution', compact('user', 'solicitudes'));
    }

    // index de solicitudes realizadas por cada estudiante
    public function indexSolicitudesEstudiante()
    {
        $user = auth()->user();
        $solicitudes = Solicitud::where('user_id', $user->id)->get();

        return view('MiembrosFacultad.index-solicitudes-participacion', compact('user', 'solicitudes'));
    }

    // este metodo me marca como leidos las notificaciones que llegaron a un correo o se les da clic en el dropdown
    public function marcarNotificacionLeida($id)
    {
        $user           = auth()->user();
        $notification   = $user->notifications->find($id);
        $notification->markAsRead();

        return view('MiembrosFacultad.index-notifications', compact('user'));
    }

    // este metodo activa el usuario tipo empresa no es una ruta protegida para poder tener acceso a ella
    public function activateUserEmpresa($id)
    {
        $user = User::find($id);

        $user->esta_habilitado = true;
        $user->save();

        return redirect('login')->with('success', 'Usuario activado con exito.');
    }


    public function destroy(Request $request, Notification $notification)
    {
        // $notifications = auth()->user()->notifications;

        // return view('MiembrosFacultad.index-notifications', compact('notifications'));

        // return $notification;
    }

    public function show($id)
    {
        $notification = auth()->user()->notifications->find($id);
        $notification->markAsRead();

        if (isset($notification->data['user_id'])) {
            $user           = User::find($notification->data['user_id']);
            $facultad       = $user->facultades()->where('principal', 1)->first();
            $estudios       = $user->estudios;

            return view('MiembrosFacultad.show-notification', compact('notification', 'user', 'facultad', 'estudios'));
        }

        return view('MiembrosFacultad.show-notification', compact('notification'));
    }

    public function showRequest($id)
    {
        $notification       = auth()->user()->notifications->find($id);
        $user               = User::find($notification->data['user_id']);
        $facultad           = $user->facultades()->where('principal', 1)->first();
        $estudios           = $user->estudios;
        $notification->markAsRead();

        $request           = Solicitud::findOrFail($notification->data['request_id']);

        return view('MiembrosFacultad.aceptar-estudiante-proyecto', compact('notification', 'user', 'facultad', 'estudios', 'request'));
    }

    public function aceptarEstudianteProyecto(Request $request)
    {
        $proyecto       = Proyecto::findOrFail($request->get('proyecto_id'));
        $solicitud      = Solicitud::findOrFail($request->get('request_id'));
        $user           = User::find($request->get('user_id'));
        $facultad       = $user->facultades()->where('principal', 1)->first();
        $institucionEducativaUser = null;

        if ($facultad) {
            $institucionEducativaUser = $facultad->institucionEducativa->nombre;
            $nodo = $facultad->institucionEducativa->nodo;
        }

        // En caso de ser rechazado ingresa a esta condicion
        if ($request->get('comentario')) {
            // $comentario es el motivo por el cual es rechazado
            $comentario = $request->get('comentario');
            $respuesta  = "Rechazado(a)";

            // actualizamos el estado de la solicitud
            $solicitud->estado = 0;
            $solicitud->comentario = $request->get('comentario');
            $solicitud->save();

            Notification::send($user, new NotificacionRespuestaSolicitud($comentario, $respuesta, $proyecto));
            return redirect()->back()->with('success', 'Respuesta enviada con éxito');
        }


        // En caso de ser aceptado ingresa a esta condicion
        $respuesta = "Aceptado(a)";
        $semilleroInvestigacion = $proyecto->semillerosInvestigacion()->where('principal', 1)->first();
        $institucionSemillero = $semilleroInvestigacion->grupoInvestigacion->facultad->institucionEducativa->nombre;

        if (!$semilleroInvestigacion) {
            // En caso de no encontrar grupo de investigación sale estado de error y no guarda
            return redirect()->back()->with('success', 'El estudiante no se pudo guardar en el grupo de investigación');
        }

        // validamos si usuario pertenece a una institucion diferente a la del grupo de investigación
        $externo = false;
        if ($institucionEducativaUser != $institucionSemillero) {
            $externo = true;
        }

        // SE actualiza la solicitud
        $solicitud->update(['estado' => 1]);
        // se agrega a autores del proyecto
        $proyecto->autores()->attach($request->get('user_id'));
        // se agrega al semillero de investigación
        $semilleroInvestigacion->miembros()->attach([$request->get('user_id') => ['externo' => $externo, 'aceptado_en' => date("Y-m-d H:i:s")]]);
        // se notifica de su aceptación
        Notification::send($user, new NotificacionRespuestaSolicitud("Fue aceptado en el proyecto.", $respuesta, $proyecto));

        return redirect()->back()->with('success', 'Respuesta enviada con éxito');
    }

    public function interes($id)
    {
        $user     = auth()->user();
        $empresa  = $user->empresa()->first();
        $proyecto = Proyecto::find($id);
        $autores  = $proyecto->autores()->get();

        Notification::send(User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')->where('model_has_roles.role_id', 3)->get(), new NotificacionInteres($user, $empresa, $proyecto, $autores));

        return redirect()->back()->with('success', 'Alerta generada con éxito');
    }

    // este metodo envia la notificación sobre la creación de una nueva idea empresarial
    public function newEmpresaIdea($ideasEmpresa)
    {
        $user           = auth()->user();
        $empresa        = $user->empresa()->first();

        if ($ideasEmpresa) {
            Notification::send(User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')->where('model_has_roles.role_id', 3)->get(), new NotificacionIdeaEmpresa($user, $empresa, $ideasEmpresa));

            return redirect()->back()->with('success', 'Las instituciones de educación han sido notificadas');
        }
    }
}
