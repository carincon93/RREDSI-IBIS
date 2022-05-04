<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionRespuestaSolicitud extends Notification
{
    use Queueable;

    private $proyecto;
    private $comentario;
    private $respuesta;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comentario, $respuesta, $proyecto)
    {
        $this->comentario   = "Motivos : " . $comentario;
        $this->respuesta    = $respuesta;
        $this->proyecto     = $proyecto;
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
            ->subject("Respuesta a la solicitud de participación en proyecto de {$this->proyecto->tipoProyecto->tipo} - Ibis")
            ->greeting("¡Hola {$notifiable->nombre} !")
            ->line("Le informamos que su solicitud de participacion realizada al proyecto {$this->proyecto->titulo} fue {$this->respuesta}. $this->comentario.")
            ->action('Más información de la respuesta', route('notificaciones.marcarNotificacionLeida', [$this->id]))
            ->line('Gracias por enviarnos la solicitud.');
    }

    /**
     * Get the arrayrepresentation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "subject"       => "Respuesta a solicutud de participación en proyecto de {$this->proyecto->tipoProyecto->tipo} - Ibis",
            "message"       => "Le informamos que su solicitud de participacion realizada al proyecto {$this->proyecto->titulo} fue {$this->respuesta}. $this->comentario.",
            "action"        => route('notificaciones.marcarNotificacionLeida', [$this->id]),
            "thanksMessage" => "Gracias por enviarnos la solicitud."
        ];
    }
}
