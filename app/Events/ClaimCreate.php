<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class ClaimCreate extends Event {

	use SerializesModels;

    public $claim;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($claim)
	{
	    $this->claim = $claim;
	}

}
