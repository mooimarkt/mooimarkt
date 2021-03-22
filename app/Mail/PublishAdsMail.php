<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Ads;
use App\User;

class PublishAdsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ads;
    public $users;
    public $adsId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $users, Ads $ads, $adsId)
    {
        $this->ads = $ads;
        $this->users = $users;
        $this->adsId = $adsId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.PlaceAdsMail');
    }
}
