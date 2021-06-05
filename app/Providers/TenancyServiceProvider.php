<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class TenancyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        $url_parts = explode('.', request()->getHttpHost());

        if (count($url_parts) > 2) {
            $subdomain = $url_parts[0];

            $customer = DB::connection('mysql')->table('customers')
                ->where('subdomain', $subdomain)
                ->first();
            if (! $customer) {
                Config::set('database.default', 'mysql');

                return;
            }

            Config::set('database.connections.subdomain.database', Crypt::decrypt($customer->db_name));
            Config::set('database.connections.subdomain.username', Crypt::decrypt($customer->db_username));
            Config::set('database.connections.subdomain.password', Crypt::decrypt($customer->db_password));

            Config::set('database.default', 'subdomain');
        } else {
            Config::set('database.default', 'mysql');
        }
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
