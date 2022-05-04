<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NotificacionInteres extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $empresa, $proyecto, $autores)
    {
        $this->user = $user;
        $this->empresa = $empresa;
        $this->proyecto = $proyecto;
        $this->autores = $autores;
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
        $investigadores = "";
        $contador = 1;
        foreach ($this->autores as $author) {
            $investigadores .= "<h3>Investigador " . $contador . ":</h3><br>";
            $investigadores .= "<li>nombre: " . $author->name . "</li>";
            $investigadores .= "<li>Teléfono: " . $author->numero_celular . "</li>";
            $investigadores .= "<li>Correo: " . $author->email . "</li><br>";
            $contador += 1;
        }
        return (new MailMessage)
            ->subject("Se ha generado un nuevo interes en un proyecto de la institución")
            ->greeting("¡Hola {$notifiable->nombre} !")
            ->line("A una empresa le interesa un proyecto de tu institución, a continuación, observarás más información: ")
            ->line(new HtmlString("<h2>Datos de la empresa: </h2>"))
            ->line(new HtmlString("<li>nombre de la empresa: {$this->empresa->nombre}.</li>"))
            ->line(new HtmlString("<li>nombre del encargado: {$this->user->nombre}.</li>"))
            ->line(new HtmlString("<li>Correo electronico del responsable: {$this->user->email}</li>"))
            ->line(new HtmlString("<li>Numero del responsable: {$this->user->numero_celular}</li><br>"))
            ->line(new HtmlString("<h2>Datos del proyecto:</h2>"))
            ->line(new HtmlString("<li>nombre del proyecto de interes: {$this->proyecto->titulo}</li><br>"))
            ->line(new HtmlString("<h2>Datos de los investigadores:</h2>"))
            ->line(new HtmlString("$investigadores"))
            ->line('Gracias, esperamos pronta respuesta.');
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
            "subject"       => "Se ha generado un nuevo interes {$this->proyecto->titulo}",
            "message"       => "El estudiante {$this->user->nombre} de la institución educativa  quiere solicitar la participación en el desarrollo del proyecto {$this->proyecto->titulo}'.",
            "thanksMessage" => "Gracias y espero su pronta respuesta!'"
        ];
    }
}
