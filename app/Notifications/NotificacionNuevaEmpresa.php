<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionNuevaEmpresa extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
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
            ->subject("Validación de usuario para el modulo empresarial - Ibis")
            ->greeting("¡Hola {$notifiable->nombre}!")
            ->line("Le informamos que para poder acceder a la plataforma debe activar su usuario.")
            ->action('Activar usuario', route('notificaciones.activateUserEmpresa', [$notifiable->id]))
            ->line('Gracias por unirse a nosotros.');
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
            "subject"       => "$notifiable->nombre bienvenido (a) al modulo empresarial - Ibis",
            "message"       => "Usted se encuentra activ@ para acceder a toda la información de la plataforma.",
            // "action"        => route('notificaciones.marcarNotificacionLeida', [$this->id]),
            "thanksMessage" => "Gracias por unirse a nosotros."
        ];
    }
}
