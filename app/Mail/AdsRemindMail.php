<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Ads;

class AdsRemindMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ads;
    public $user;
    public $adsId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ads $ads, User $user, $adsId)
    {
        $this->ads = $ads;
        $this->user = $user;
        $this->adsId = $adsId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.CompleteAdsMail');
    }
}
