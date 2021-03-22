<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewNotification extends Event implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public $user;

    public $message;

    public $id;

    public $picture;

    /**
     * NewNotification constructor.
     * @param User $user
     * @param $message
     * @param null $id
     * @param null $picture
     */
    public function __construct(User $user, $message, $id = null, $picture = null)
    {
        $this->user    = $user;
        $this->message = $message;
        $this->id      = $id;
        $this->picture = $picture;
    }

    /**
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notifications.' . $this->user->id);
    }
}
