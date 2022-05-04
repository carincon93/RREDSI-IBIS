<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NotificacionIdeaEmpresa extends Notification
{
    use Queueable;

    private $user;
    private $empresa;
    private $ideasEmpresa;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $empresa, $ideasEmpresa)
    {
        $this->user = $user;
        $this->empresa = $empresa;
        $this->ideasEmpresa = $ideasEmpresa;
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

        if ($this->ideasEmpresa->tiene_recursos == 0) {
            $this->ideasEmpresa->tiene_recursos = "No";
        } else {
            $this->ideasEmpresa->tiene_recursos = "Si";
        }
        if ($this->ideasEmpresa->tiene_equipos == 0) {
            $this->ideasEmpresa->tiene_equipos = "No";
        } else {
            $this->ideasEmpresa->tiene_equipos = "Si";
        }

        return (new MailMessage)
            ->subject("Nueva {$this->ideasEmpresa->tipo} de la empresa {$this->empresa->nombre}")
            ->greeting("¡Hola {$notifiable->nombre} !")
            ->line("Le informamos que la empresa  {$this->empresa->nombre}  ha generado una nueva  {$this->ideasEmpresa->tipo} valida con tus investigadores una posible opoetunidad.")
            ->line(new HtmlString("<h2>A continuación podras encontrar mas información:</h2><ul>"))
            ->line(new HtmlString("<li>nombre de la {$this->ideasEmpresa->tipo}: {$this->ideasEmpresa->nombre}</li>"))
            ->line(new HtmlString("<li>¿La {$this->ideasEmpresa->tipo} cuenta con recursos? : {$this->ideasEmpresa->tiene_recursos}</li>"))
            ->line(new HtmlString("<li>¿La {$this->ideasEmpresa->tipo} cuenta con herramientas? : {$this->ideasEmpresa->tiene_equipos}</li>"))
            ->line(new HtmlString("<li>Responsable de la empresa: {$this->user->nombre}</li>"))
            ->line(new HtmlString("<li>Correo: {$this->user->email}</li>"))
            ->line(new HtmlString("<li>Teléfono: {$this->user->numero_celular}</li></ul>"));
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
            "subject"       => "¡Bienvenido al modulo empresarial - Ibis!",
            "message"       => "Usted se encuentra activo (a) para acceder a toda la información de la plataforma.",
            "thanksMessage" => "Gracias por unirse a nosotros."
        ];
    }
}
