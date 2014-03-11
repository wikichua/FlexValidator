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

	    public function testAllFail()
	    {
	    	$Inputs = [
	    		'password' => '1',
	    		'password_confirmation' => '3',
	    		'text1' => 'f',
	    		'text2' => 'f',
	    		'text3' => 'nothing same',
	    		'middletext' => 9,
	    		'tnc' => 0,
	    		'homepage2' => 'http::/nobody.com',
	    		'afterdate' => date('Y-m-d'),
	    		'beforedate' => date('Y-m-d'),
	    		'name' => 'asd312',
	    		'username' => 'asd123_-*/123',
	    		'username2' => 'asd123@#123',
	    		'birthdate' => "2012-02-31",
	    		'birthdate2' => "2012-02-27",
	    		'toto' => 123,
	    		'6d' => 123,
	    		'emailaddress' => 'email#opps.what?',
	    		'gender' => 'trans',
	    		'num' => 'a',
	    		'myip' => '1000.11.22.00.22',
	    		'num1' => '1',
	    		'num2' => '100',
	    		'agerange' => 18,
	    		'regextext' => 'asd',
	    	];

	    	$Rules = [
	    		'password' => [
	    			'required',
	    			'confirmed' => 'password_confirmation',
	    		],
	    		'password_confirmation' => [
	    			'required',
	    		],
	    		'text1' => [
	    			'required',
	    			'different' => 'text2',
	    		],
	    		'text3' => [
	    			'same' => 'something same',
	    		],
	    		'middletext' => [
	    			'between' => [10,20],
	    		],
	    		'tnc' => [
	    			'accepted',
	    		],
	    		'homepage2' => [
	    			'url',
	    		],
	    		'afterdate' => [
	    			'after' => date('Y').'-'.date('m').'-'.(date('d') + 1),
	    		],
	    		'beforedate' => [
	    			'before' => date('Y').'-'.date('m').'-'.(date('d') - 1),
	    		],
	    		'name' => [
	    			'alpha',
	    		],
	    		'username' => [
	    			'alpha_num',
	    		],
	    		'username2' => [
	    			'alpha_dash',
	    		],
	    		'birthdate' => [
	    			'isDate',
	    		],
	    		'birthdate2' => [
	    			'date_format' => 'd/M/Y',
	    		],
	    		'toto' => [
	    			'digits' => 4,
	    		],
	    		'6d' => [
	    			'digits_between' => [4,6],
	    		],
	    		'emailaddress' => [
	    			'email',
	    		],
	    		'gender' => [
	    			'in' => 'male,female',
	    		],
	    		'num' => [
	    			'integer',
	    		],
	    		'myip' => [
	    			'ip',
	    		],
	    		'num1' => [
	    			'min' => 2,
	    		],
	    		'num2' => [
	    			'max' => 99,
	    		],
	    		'agerange' => [
	    			'not_in' => [10,18,20,21],
	    		],
	    		'regextext' => [
	    			'regex' => '/\d+/i',
	    		],
	    	];

	    	$valid = Validator::make($Inputs,$Rules);


	    	$this->assertTrue($valid->fail());
	    }

	    public function testAllPass()
	    {
	    	$Inputs = [
	    		'password' => '3',
	    		'password_confirmation' => '3',
	    		'text1' => '2',
	    		'text2' => 'f',
	    		'text3' => 'something same',
	    		'middletext' => 15,
	    		'tnc' => 1,
	    		'homepage2' => 'http://wikichua.com',
	    		'afterdate' => date('Y').'-'.date('m').'-'.(date('d') + 3),
	    		'beforedate' => date('Y').'-'.date('m').'-'.(date('d') - 1),
	    		'name' => 'wikichua',
	    		'username' => 'asd123',
	    		'username2' => 'asd123-_123',
	    		'birthdate' => "1983-01-07",
	    		'birthdate2' => "07/01/1983",
	    		'toto' => 1234,
	    		'6d' => 123456,
	    		'emailaddress' => 'wikichua@gmail.com',
	    		'gender' => 'male',
	    		'num' => 31,
	    		'myip' => '172.0.0.1',
	    		'num1' => 3,
	    		'num2' => 98,
	    		'agerange' => 31,
	    		'regextext' => 1983,
	    	];

	    	$Rules = [
	    		'password' => [
	    			'required',
	    			'confirmed' => 'password_confirmation',
	    		],
	    		'password_confirmation' => [
	    			'required',
	    		],
	    		'text1' => [
	    			'required',
	    			'different' => 'text2',
	    		],
	    		'text3' => [
	    			'same' => 'something same',
	    		],
	    		'middletext' => [
	    			'between' => [10,20],
	    		],
	    		'tnc' => [
	    			'accepted',
	    		],
	    		'homepage2' => [
	    			'url',
	    		],
	    		'afterdate' => [
	    			'after' => date('Y').'-'.date('m').'-'.(date('d') + 1),
	    		],
	    		'beforedate' => [
	    			'before' => date('Y').'-'.date('m').'-'.(date('d') - 1),
	    		],
	    		'name' => [
	    			'alpha',
	    		],
	    		'username' => [
	    			'alpha_num',
	    		],
	    		'username2' => [
	    			'alpha_dash',
	    		],
	    		'birthdate' => [
	    			'isDate',
	    		],
	    		'birthdate2' => [
	    			'date_format' => 'd/m/Y',
	    		],
	    		'toto' => [
	    			'digits' => 4,
	    		],
	    		'6d' => [
	    			'digits_between' => [4,6],
	    		],
	    		'emailaddress' => [
	    			'email',
	    		],
	    		'gender' => [
	    			'in' => 'male,female',
	    		],
	    		'num' => [
	    			'integer',
	    		],
	    		'myip' => [
	    			'ip',
	    		],
	    		'num1' => [
	    			'min' => 2,
	    		],
	    		'num2' => [
	    			'max' => 99,
	    		],
	    		'agerange' => [
	    			'not_in' => [10,18,20,21],
	    		],
	    		'regextext' => [
	    			'regex' => '/\d+/i',
	    		],
	    	];

	    	$valid = Validator::make($Inputs,$Rules);

	    	$this->assertTrue($valid->fail());
	    }
	}
}
