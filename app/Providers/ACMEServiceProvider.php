<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ACME\Helpers\CallbackHelper;

class ACMEServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $callbackHelper = new CallbackHelper();
        $this->app->instance('CallbackHelper',$callbackHelper);
    }
}