<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Feedback;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $feedback;
    public $images;
    public $timeStamp;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Feedback $feedback, $images, $timeStamp)
    {
        $this->feedback = $feedback;
        $this->images = $images;
        $this->timeStamp = $timeStamp;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view = $this->view('user.FeedbackMail');

        if($this->images != NULL and count($this->images) > 0){
            foreach($this->images as $index=>$image) {

                $view->attach($image, [
                    'as' => "Image " . $index . "." . $image->extension(),
                    'mime' => $image->getMimeType(),
                ]);
            }
        }
        return $view;
    }
}
