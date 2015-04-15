<?php namespace App\Handlers\Events;

use App\Events\ClaimCreate;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendMailToClient {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  ClaimCreate  $event
	 * @return void
	 */
	public function handle(ClaimCreate $event)
	{
        $claim = $event->claim;
        $properties = \App\Property::showPropertyValue($claim);


        \Mail::send('emails.claimcreate',compact('claim','properties'), function($message) use ($event)
        {
            $emails = [];
            $emails[] = $event->claim->project->client->email;
            if(!empty($event->claim->project->client->send_email)){
                $emails[] = $event->claim->project->client->send_email;
            }
            $message->to($emails, 'Callcenter №1')->subject('Круглосуточный call-центр №1');
        });
	}

}
