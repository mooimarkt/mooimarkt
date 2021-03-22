<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Feedback;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $encryptedUserId;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $encryptedUserId)
    {
        $this->user = $user;
        $this->encryptedUserId = $encryptedUserId;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('site.mail.newVerifyMail');
    }
}
