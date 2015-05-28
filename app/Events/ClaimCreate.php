<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class ClaimCreate extends Event {

	use SerializesModels;

    public $claim;
    public $destinations;

    /**
     * Create a new event instance.
     * @param $claim
     * @param array $destinations
     * @internal param $destination
     */
	public function __construct($claim,$destinations=array())
	{
	    $this->claim = $claim;
        $this->destinations = $destinations;
	}

}
