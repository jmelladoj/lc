<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class RecuperarContrasena extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct(User $usuario, String $clave)
     {
         //
         $this->usuario = $usuario;
         $this->clave = $clave;
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
                    ->view('mensajes.recuperar')
                    ->with([
                        'clave' => $this->clave
                    ]);
    }
}
