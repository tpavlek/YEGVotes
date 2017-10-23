<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use socrata\soda\Client;

class SocrataServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(Client::class, function() {
            $app_token = env("SOCRATA_APP_TOKEN", null);
            if ($app_token === null) {
                throw new \InvalidArgumentException("Did not provide a socrata app token");
            }

            return new Client("https://data.edmonton.ca", $app_token);
        });
    }
}
