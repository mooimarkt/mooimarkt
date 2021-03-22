<?php

return [
    'user_model'            => 'App\User',
	'user_model_primary_key' => null,
    /*
     * This will allow you to broadcast an event when a message is sent
     * Example:
     * Channel: private-mc-chat-conversation.2,
     * Event: Musonza\Chat\Messages\MessageWasSent
     */
    'broadcasts'            => false,
	'sent_message_event'    => 'Musonza\Chat\Eventing\MessageWasSent',
];
