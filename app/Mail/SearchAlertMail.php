<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Ads;
use App\User;
use App\SearchCriteria;

class SearchAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $allAds;
    public $users;
    public $searchCriteria;
    public $searchId;
    public $encryptedId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $allAds, User $users, SearchCriteria $searchCriteria, $searchId, $encryptedId)
    {
        $this->allAds = $allAds;
        $this->users = $users;
        $this->searchCriteria = $searchCriteria;
        $this->searchId = $searchId;
        $this->encryptedId = $encryptedId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.SearchAlertMail');
    }
}
