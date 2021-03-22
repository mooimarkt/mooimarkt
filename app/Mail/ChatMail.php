<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class ChatMail extends Mailable
{
    use Queueable, SerializesModels;

    public $receive;
    public $sender;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $receive)
    {
        $this->sender = $sender;
        $this->receive = $receive;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.ChatMail');
    }
}
