<?php

namespace App\Providers;

use App\Service\IdentityService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Sven\ArtisanView\ServiceProvider::class);

        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        \Validator::extend('mobile', function ($attribute, $value, $parameters, Validator $validator) {
            return $validator->validateRegex($attribute, $value, ['/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/']);
        });
        \Validator::extend('identity', function ($attribute, $value, $parameters, Validator $validator) {
            return IdentityService::MatchIdentityInformation($value);
        });
    }
}
