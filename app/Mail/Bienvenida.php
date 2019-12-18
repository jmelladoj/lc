<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Bienvenida extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $nombre)
    {
        //
        $this->nombre = $nombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contacto@prevencionlebenco.cl')
                    //->replyTo('contacto@prevencionlebenco.cl', 'Prueba de mensaje')
                    ->subject('Bienvenido')
                    ->view('mensajes.bienvenida');
    }
}
