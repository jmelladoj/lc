<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contacto extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $nombre, String $asunto, String $email, $numero, String $mensaje, $tipo_persona)
    {
        //
        $this->nombre = $nombre;
        $this->email = $email;
        $this->asunto = $asunto;
        $this->numero = $numero;
        $this->mensaje = $mensaje;
        $this->tipo_persona = $tipo_persona;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contacto@prevencionlebenco.cl')
                    ->replyTo('contacto@prevencionlebenco.cl', 'Prueba de mensaje')
                    ->subject('Prueba desde formulario de contácto')
                    ->view('mensajes.contacto');
    }
}
