<?php 

namespace WikiChua\FlexValidator
{
	class Rules {

		protected static $callbacks = [];
		protected static $messages = [];
		protected $Inputs = [];

		static public function extend($key, callable $callback, $message = '')
		{
			static::$callbacks[$key] = $callback;
			unset(static::$messages[$key]);
			if(!empty($message))
				static::$messages[$key] = $message;
		}
		
		static public function validate($method, $fieldname, $Inputs, $message = '')
		{
			$self = new self;
			$self->Inputs = $Inputs;
			$fieldvalue = $Inputs[$fieldname];
			$attributes = null;
			if(is_array($method))
			{
				$attributes = array_values($method)[0];
				$method = array_keys($method)[0];
			}

			if(array_key_exists($method, static::$callbacks))
			{
				$valid = call_user_func_array(static::$callbacks[$method], [$fieldname, $fieldvalue, $attributes]);
			}else
			{
				$valid = call_user_func_array([$self,$method], [$fieldname, $fieldvalue, $attributes]);
			}

			if(!$valid)
			{
				if(isset($message[$method]) && array_key_exists($method, $message))
				{
					return Messages::make($method,@$message[$method],$fieldname,$attributes);
				}else{
					return Messages::make($method,@static::$messages[$method],$fieldname,$attributes);
				}
			}
			return true;
		}

		protected function required($fieldname, $fieldvalue, $attributes)
		{
			return !empty($fieldvalue) && !is_null($fieldvalue);
		}

		protected function same($fieldname, $fieldvalue, $attributes)
		{
			return ($fieldvalue == $attributes);
		}

		protected function between($fieldname, $fieldvalue, $attributes)
		{
			return $fieldvalue > $attributes[0] && $fieldvalue <= $attributes[1];
		}

		protected function confirmed($fieldname, $fieldvalue, $attributes)
		{
			if(empty($attributes) || is_null($attributes))
				$attributes = $fieldname . '_confirmation';
			return $fieldvalue == $this->Inputs[$attributes];
		}


	}
}
