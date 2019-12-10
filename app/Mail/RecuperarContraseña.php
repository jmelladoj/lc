<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarContraseña extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct(String $nombre, String $email)
     {
         //
         $this->nombre = $nombre;
         $this->email = $email;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('soporte@prevencionlebenco.cl')
                    ->replyTo('soporte@prevencionlebenco.cl', 'Prueba de mensaje')
                    ->subject('Prueba desde formulario de recuperar contraseña')
                    ->view('mensajes.recuperar');
    }
}
