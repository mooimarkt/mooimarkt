<?php

namespace App\Mail\NewMail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Ads;

class CreatedAdMailNew extends Mailable
{
    use Queueable, SerializesModels;

    public $ads;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ads $ads, User $user)
    {
        $this->ads = $ads;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.created_ad_public');
    }
}
