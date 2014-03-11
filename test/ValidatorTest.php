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
	    	$this->assertCount(3,$valid->getErrors());
	    }

	    public function testAbleToSetError()
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
	    	});
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

	    	$Messages = [
	    		'username' => [
	    			'stupid' => ':field must be :attribute',
	    		],
	    	];

	    	$valid = Validator::make($Inputs,$Rules,$Messages);
	    	var_dump($valid->getErrors());
	    }
	}
}
