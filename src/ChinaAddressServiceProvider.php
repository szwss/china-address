<?php
namespace Szwss\ChinaAddress;

use Illuminate\Support\ServiceProvider;
use Szwss\ChinaAddress\Commands\ImportAddress;

class ChinaAddressServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $timestamp = date('Y_m_d_His');
        
        $this->publishes([
            __DIR__.'/../migrations/create_addresses_table.php' => $this->app->databasePath()."/migrations/{$timestamp}_create_addresses_table.php",
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ImportAddress::class,
            ]);
        }
    }

    public function register()
    {
        # code
    }
}