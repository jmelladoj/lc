<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitarAmigo extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario, $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $usuario, String $email)
    {
        //
        $this->usuario = $usuario;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contacto@prevencionlebenco.cl')
                    ->subject('Ven a conocer nuestro sitio web')
                    ->view('mensajes.invitarAmigo');
    }
}
