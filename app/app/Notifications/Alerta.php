<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Alerta extends Notification
{
    use Queueable;

    protected $mensaje, $usuario, $invitado, $clase, $tipo_notificacion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mensaje, $usuario, $invitado, $clase, $tipo_notificacion)
    {
        //
        $this->mensaje = $mensaje;
        $this->usuario = $usuario;
        $this->invitado = $invitado;
        $this->clase = $clase;
        $this->tipo_notificacion = $tipo_notificacion;
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'mensaje' => $this->mensaje,
            'usuario' => $this->usuario,
            'invitado' => $this->invitado,
            'clase' => $this->clase,
            'tipo_notificacion' => $this->tipo_notificacion
        ];
    }
}
