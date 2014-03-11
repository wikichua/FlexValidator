<?php 

namespace WikiChua\FlexValidator
{
	class Validator {
		
		protected $errors = [];

		static public function make(array $Inputs, array $Rules, array $Messages = [])
		{
			$self = new self;

			foreach ($Rules as $fieldname => $rules) {
				foreach ($rules as $rule_key => $rule_value) {
					if(is_integer($rule_key))
						$rule = $rule_value;
					else
						$rule = [$rule_key => $rule_value];

					$valid = Rules::validate($rule, $fieldname, $Inputs[$fieldname],@$Messages[$fieldname]);
					if($valid !== true)
						$self->setError($fieldname,$valid);
				}
			}	

			return $self;
		}

		public function setError($key, $value = '')
		{
			if( !is_array($key) && !empty($value))
			{
				if(array_key_exists($key, $this->errors))
				{
					$temp_errors = $this->errors[$key];
					$this->errors[$key] = [];
					if(is_array($temp_errors))
					{
						$this->errors = array_merge($temp_errors,[$value]);
					} else {
						$this->errors = array_merge([$temp_errors],[$value]);
					}
				}else{
					$this->errors[$key] = $value;
				}
			} elseif(is_array($key)) {
				$this->errors = array_merge($this->errors,$key);
			}
		}

		public function getErrors($key = "")
		{
			if(!empty($key))
				return $this->errors[$key];
			return $this->errors;
		}

		static public function extend($key, callable $callback)
		{
			Rules::extend($key,$callback);
		}
	}
}
