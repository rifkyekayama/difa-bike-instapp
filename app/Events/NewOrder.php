<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Notification\Notif;

class NewOrder implements ShouldBroadcast
{
	use InteractsWithSockets, SerializesModels;

	private $nama;
	private $data;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($nama)
	{
		//
		$this->nama = $nama;
		$notif = new Notif;
		$notif->data = 'Pesanan baru dari '.$this->nama;
		$notif->save();
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn()
	{
		return new Channel('newOrder');
	}

	/**
	 * Get the data to broadcast.
	 *
	 * @return array
	 */
	public function broadcastWith()
	{
		return [
			'data' => 'Pesanan baru dari '.$this->nama
		];
	}
}
