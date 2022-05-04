<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationParticipacionProyecto extends Notification
{
    use Queueable;

    private $nodo;
    private $proyecto;
    private $semilleroInvestigacion;
    private $user;
    private $file;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($nodo, $proyecto, $semilleroInvestigacion, $user, $solicitudes)
    {
        $this->nodo                     = $nodo;
        $this->proyecto                 = $proyecto;
        $this->semilleroInvestigacion   = $semilleroInvestigacion;
        $this->user                     = $user;
        $this->solicitudes              = $solicitudes;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Quemado Falta mail
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->user->hasRole(4)) {
            $facultad  = $this->user->facultades()->where('principal', 1)->first();
            $institucionEducativa = $facultad->institucionEducativa->nombre;
        } elseif ($this->user->hasRole(3)) {
            $institucionEducativa = $this->user->esAdminInstitucionEducativa->nombre;
        }

        return (new MailMessage)
            ->subject("Solicitud de participación en proyecto de {$this->proyecto->tipoProyecto->tipo} - Ibis")
            ->greeting("¡Hola {$notifiable->nombre} !")
            ->line("El estudiante {$this->user->nombre} de la institución educativa {$institucionEducativa} desea participar en el desarrollo del proyecto {$this->proyecto->titulo}'.")
            ->action('Más información del estudiante', route('notificaciones.marcarNotificacionLeida', [$this->id]))
            ->line('Gracias y espero su pronta respuesta');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->user->hasRole(4)) {
            $facultad  = $this->user->facultades()->where('principal', 1)->first();
            $institucionEducativa         = $facultad->institucionEducativa->nombre;
        } elseif ($this->user->hasRole(3)) {
            $institucionEducativa = $this->user->esAdminInstitucionEducativa->nombre;
        }

        return [
            "subject"       => "Solicutud de participación en el proyecto {$this->proyecto->titulo}",
            "message"       => "El estudiante {$this->user->nombre} de la institución educativa {$institucionEducativa} quiere participar en el desarrollo del proyecto {$this->proyecto->titulo}'.",
            "action"        => route('notificaciones.marcarNotificacionLeida', [$this->id]),
            "request_id"    => $this->solicitudes->id,
            "user_id"       => $this->user->id,
            "proyecto_id"   => $this->proyecto->id,
            "thanksMessage" => "Importante: Por favor consulte con su institución educativa sobre como incluir esta persona en el desarrollo del proyecto."
        ];
    }
}
