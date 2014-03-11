<?php 

namespace WikiChua\FlexValidator
{
	class Rules {

		protected static $callbacks = [];

		static public function extend($key, callable $callback)
		{
			static::$callbacks[$key] = $callback;
		}
		
		static public function validate($method, $fieldname, $fieldvalue = '', $message = '')
		{
			$self = new self;
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
				return Messages::make($method,@$message[$method],$fieldname,$attributes);
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


	}
}
