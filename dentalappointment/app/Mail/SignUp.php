<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignUp extends Mailable
{
    use Queueable, SerializesModels;

    public $password;
    public $numExp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($numExp, $password)
    {
        $this->password = $password;
        $this->numExp = $numExp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.signupMail');
    }
}
