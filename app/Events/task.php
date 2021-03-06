<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class task implements ShouldBroadcast
{ 
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $Data;
    public function __construct($data)
    {
        $this->Data=$data;
    }

    public function broadcastWith(){
        return[
            "task"=>$this->Data
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('task');
    }
}
