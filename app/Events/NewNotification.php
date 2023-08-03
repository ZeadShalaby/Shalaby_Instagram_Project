<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $comment;
    public $post_id;
    public $user_name;
    public $data;
    public $time;
    /**
     * Create a new event instance.
     */
    public function __construct($data=[])
    {
        $this->user_id=$data['user_id'];
        $this->user_name=$data['user_name'];
        $this->comment=$data['comment'];
        $this->post_id=$data['post_id'];
        $this->data= date("Y-m-d", strtotime(Carbon::now()));
        $this->time= date("h:i A", strtotime(Carbon::now()));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['new-notification'];
    }
}
