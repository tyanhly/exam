<?php

class SHAHashServiceProvider extends Illuminate\Hashing\HashServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register () {
        $this->app->bindShared('hash', function  ()
        {
            return new SHAHash();
        });
    }

}