<?php
require __dir__.'/vendor/autoload.php';

use WikiChua\FlexValidator\Validator;

if(isset($_POST['submit'])){
	// customize rule
	Validator::extend('strong_password',function($fieldname, $fieldvalue, $attributes){
		if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $fieldvalue)){
		    return true;
		} else {
		    return false;
		}

	},"Your password not strong enough.");


	$Rules = [
		'email' => [
			'required',
			'email',
		],
		'email2' => [
			'required',
			'email',
			'different' => 'email2',
		],
		'password' => [
			'required',
			'confirmed' => 'password_confirmation',
			'strong_password',
		],
		'password_confirmation' => [
			'required',
		],
		'myfile' => [
			'required',
			'mimes' => [
				'pdf','png'
			]
		],
		'checkme' => [
			'accepted',
		],

	];

	$Messages = [
		'email2' => [
			'different' => 'Ok man. :field must be different from ' . $_POST["email"],
		],
	];

	$valid = Validator::make($_POST,$Rules,$Messages);

	if($valid->fail())
	{
		echo '<div class="alert alert-danger"><h3>ERRORS</h3><ul>';
		foreach ($valid->getErrors() as $key => $value) {
			if(is_array($value))
			{
				foreach ($value as $value2) {
					echo '<li>'.$value2.'</li>';
				}
			}else
			{
				echo '<li>'.$value.'</li>';		
			}
		}
		echo '</ul></div>';
	}	
}
