<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SimpleSaveAdsCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $ads;
    public $simpleSave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($simpleSave, $ads)
    {
        $this->ads = $ads;
        $this->simpleSave = $simpleSave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.SimpleSaveAdsCreated')
                    ->with([
                        'ads' => $this->ads,
                        'simpleSave' => $this->simpleSave,
                    ]);
    }
}
