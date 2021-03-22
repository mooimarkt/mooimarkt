<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeedbackReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $timeStamp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($timeStamp)
    {
        $this->timeStamp = $timeStamp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.FeedbackReplyMail');
    }
}
