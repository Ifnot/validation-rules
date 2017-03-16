<?php namespace Ifnot\ValidationRules;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator as IlluminateValidator;

/**
 * Class ValidationRulesServiceProvider
 * @package Ifnot\ValidationRules
 */
class ValidationRulesServiceProvider extends ServiceProvider
{
	public function register()
	{

	}

	public function boot()
	{
		IlluminateValidator::resolver(function ($translator, $data, $rules, $messages) {
			return new Validator($translator, $data, $rules, $messages);
		});
	}
}
