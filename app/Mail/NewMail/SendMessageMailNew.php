<?php
namespace App\Mail\NewMail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Ads;

class SendMessageMailNew extends Mailable
{
    use Queueable, SerializesModels;

    public $ads;
    public $user;
    public $msg;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ads $ads, $msg, $date, $user)
    {
        $this->ads = $ads;
        $this->msg = $msg;
        $this->date = $date;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send_message');
    }
}
