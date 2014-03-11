<?php

namespace WikiChua\FlexValidator
{
	require __dir__.'/../vendor/autoload.php';
	
	class ValidatorTest extends \PHPUnit_Framework_TestCase
	{
	    public function testCanMakeValidation()
	    {
	    	$Inputs = [
	    		'username' => '',
	    	];

	    	$Rules = [
	    		'username' => [
	    			'required',
	    			'same' => '3',
	    			'between' => [1,5],
	    			],
	    	];

	    	$Messages = [
	    		'username' => [
	    			'same' => ':field must be same as :attribute',
	    			'between' => ':field must be between :attribute_1 and :attribute_2',
	    		],
	    	];

	    	$valid = Validator::make($Inputs,$Rules,$Messages);
	    	$this->assertCount(1,$valid->getErrors());
	    }

	    public function testAbleToSetAndGetError()
	    {
	    	$valid = Validator::make([],[],[]);
	    	$valid->setError('test','Testing is done');
	    	$errors = $valid->getErrors();
	    	$this->assertCount(1, $errors);
	    	$this->assertSame('Testing is done', $errors['test']);
	    	$errors = $valid->getErrors('test');
	    	$this->assertSame('Testing is done', $errors);
	    }

	    public function testAbleToExtendsNewRule()
	    {
	    	Validator::extend('stupid',function($fieldname, $fieldvalue, $attributes){
	    		return $fieldvalue == $attributes;
	    	},":field must be :attribute ok?");
	    }

	    public function testCanUseExtendedRule()
	    {
	    	$Inputs = [
	    		'username' => '',
	    	];

	    	$Rules = [
	    		'username' => [
	    			'required',
	    			'same' => '3',
	    			'between' => [1,5],
	    			'stupid' => 'STUPID',
	    			],
	    	];

	    	$valid = Validator::make($Inputs,$Rules);
	    	$this->assertCount(1, $valid->getErrors());
	    }

	    public function testCanUseExtendedRuleMessage()
	    {
	    	$Inputs = [
	    		'username' => '',
	    	];

	    	$Rules = [
	    		'username' => [
	    			'required',
	    			'same' => '3',
	    			'between' => [1,5],
	    			'stupid' => 'STUPID',
	    			],
	    	];

	    	$Messages = [
	    		'username' => [
	    			'stupid' => ':field must be :attribute',
	    		],
	    	];

	    	$valid = Validator::make($Inputs,$Rules,$Messages);
	    	$this->assertCount(1, $valid->getErrors());
	    }

	    public function testConfirmInput()
	    {
	    	$Inputs = [
	    		'password' => '3',
	    		'password_confirmation' => 'e',
	    		'text1' => '',
	    		'text2' => 'f',
	    	];

	    	$Rules = [
	    		'password' => [
	    			'required',
	    			'confirmed',
	    		],
	    		'password_confirmation' => [
	    			'required',
	    		],
	    		'text1' => [
	    			'required',
	    			'confirmed' => 'text2',
	    		],
	    	];

	    	$Messages = [
	    		'password' => [
	    			'confirmed' => ':field must be confirmed ok??',
	    		],
	    	];

	    	$valid = Validator::make($Inputs,$Rules,$Messages);
	    	$this->assertCount(2, $valid->getErrors());
	    }
	}
}
