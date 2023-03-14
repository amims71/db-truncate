<?php
namespace Amims71\DbTruncate;

use Illuminate\Support\ServiceProvider;
use Amims71\DbTruncate\Console\DBTruncateCommand;
class DbTruncateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            DBTruncateCommand::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}