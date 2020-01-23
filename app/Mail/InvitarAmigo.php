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

    public $user, $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $email)
    {
        //
        $this->user = $user;
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
