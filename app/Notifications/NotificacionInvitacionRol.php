<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionInvitacionRol extends Notification
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
    public function __construct($nodo, $proyecto, $semilleroInvestigacion, $user, $file)
    {
        $this->nodo                     = $nodo;
        $this->proyecto                 = $proyecto;
        $this->semilleroInvestigacion   = $semilleroInvestigacion;
        $this->user                     = $user;
        $this->file                     = $file;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
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
        return (new MailMessage)
            ->subject("Invitación de participación en proyecto de {$this->proyecto->tipoProyecto->tipo} - Ibis")
            ->greeting("¡Hola {$this->user->nombre}!")
            ->line("El semillero de investigación {$this->semilleroInvestigacion->nombre} de la institución educativa {$this->semilleroInvestigacion->grupoInvestigacion->facultad->institucionEducativa->nombre} quiere invitarlo para que participe en el desarrollo del proyecto {$this->proyecto->titulo}. Por favor revise el documento adjunto, si esta de acuerdo firme y posteriormente cargue el documento en pdf en la sección 'Enviar respuesta' haciendo clic en 'Más información del proyecto'.")
            ->action('Más información del proyecto', route('nodos.explorer.searchProyectos.showProyecto', [$this->nodo, $this->proyecto]))
            ->line('Gracias y esperamos su pronta respuesta')
            ->attach($this->file);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "subject"       => "Invitación de participación en proyecto de {$this->proyecto->tipoProyecto->tipo} - Ibis",
            "message"       => "El semillero de investigación {$this->semilleroInvestigacion->nombre} de la institución educativa {$this->semilleroInvestigacion->grupoInvestigacion->facultad->institucionEducativa->nombre} quiere invitarlo para que participe en el desarrollo del proyecto {$this->proyecto->titulo}. Por favor revise el documento adjunto, si esta de acuerdo firme y posteriormente cargue el documento en pdf en la sección 'Enviar respuesta' haciendo clic en 'Más información del proyecto'.",
            "action"        => route('nodos.explorer.searchProyectos.showProyecto', [$this->nodo, $this->proyecto]),
            "thanksMessage" => "Gracias y esperamos su pronta respuesta!'"
        ];
    }
}
