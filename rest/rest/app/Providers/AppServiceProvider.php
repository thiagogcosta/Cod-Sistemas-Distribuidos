<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    	# Validator USERNAME
		Validator::extend('username', function ($attribute, $value, $parameters, $validator) {
			/** @var \Illuminate\Validation\Validator $validateValidator */
			$validateValidator = Validator::make(
				[$attribute => $value],
				[$attribute => ['regex:/^[a-zA-Z0-9]+([_-]?[a-zA-Z0-9])*$/']]
			);
			return $validateValidator->passes();
		});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
