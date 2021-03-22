<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Ads;

class ExpireMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ads;
    public $user;
    public $expireDays;
    public $adsId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ads $ads, User $user, $expireDays, $adsId)
    {
        $this->ads = $ads;
        $this->user = $user;
        $this->expireDays = $expireDays;
        $this->adsId = $adsId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.ExpiredMail');
    }
}
