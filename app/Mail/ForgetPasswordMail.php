<?php

namespace App\Mail;

use App\Option;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\User;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $token
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = Option::where('name', 'opt_support_email')->first()->value ?? 'mooimarkt@gmail.com';

        return $this->from($email)->subject($this->subject)->view('emails.reset_password');
    }
}
