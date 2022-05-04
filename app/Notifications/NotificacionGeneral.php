<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionGeneral extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
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
        //     return (new MailMessage)
        //                 ->line('The introduction to the notification.')
        //                 ->action('Notification Action', url('/'))
        //                 ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->type == "proyecto" || $this->type == "producto de investigación") {
            $name = $this->data->titulo;
            $message = " un nuevo ";
        } else if ($this->type == "institución educativa") {
            $name = $this->data->nombre;
            $message = " una nueva ";
        } else {
            $name = $this->data->nombre;
            $message = " el nuevo ";
        }

        if (isset($this->type['type'])) {
            return [
                "subject"       => "Se acaba de {$this->type['type']}",
                "message"       => "Hola {$notifiable->nombre} se registró el proyecto {$this->data->titulo} al evento {$this->type['evento_nombre']}.",
            ];
        } else if (isset($this->type['annualEventResponse'])) {
            return [
                "subject"       => "{$this->type['case']}",
                "message"       => "¡Hola {$notifiable->nombre}! la participacion del proyecto {$this->data->titulo} al evento anual fue {$this->type['annualEventResponse']} por motivos {$this->type['comentarios']}  .",
            ];
        } else if ($this->type == "Registro nuevo estudiante") {
            return [
                "subject"       => "Se acaba de registrar un nuevo estudiante",
                "message"       => "¡Hola {$notifiable->nombre}! se registro el estudiante {$this->data->nombre} a la institucion por favor habilitelo para que  pueda ingresar a la plataforma.",
            ];
        } else {
            return [
                "subject"       => "Se acaba de crear $message {$this->type}",
                "message"       => "Hola {$notifiable->nombre}. Tenemos un nuevo  $message {$this->type} {$name}.",
            ];
        }
    }
}
