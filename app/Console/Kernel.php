<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
        'App\Console\Commands\Reports',
        'App\Console\Commands\OlgaReport',
        'App\Console\Commands\monthReport',
		'App\Console\Commands\dailyReport',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
        //$schedule->command('callcenter:reports daily')->hourly();
		$schedule->command('callcenter:dailyReport')->dailyAt('8:00');
        $schedule->command('callcenter:reports weekly')->weeklyOn(6,"23:30");
        $schedule->command('callcenter:reports monthly')->monthly();
	}

}
