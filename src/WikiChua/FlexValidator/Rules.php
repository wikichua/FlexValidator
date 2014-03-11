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
			if(isset($_FILES[$fieldname]))
			{
				return !empty($_FILES[$fieldname]['name']) && !is_null($_FILES[$fieldname]['name']);			
			}
			return !empty($fieldvalue) && !is_null($fieldvalue);
		}

		protected function same($fieldname, $fieldvalue, $attributes)
		{
			return ($fieldvalue == $attributes);
		}

		protected function between($fieldname, $fieldvalue, $attributes)
		{
			return $fieldvalue >= $attributes[0] && $fieldvalue <= $attributes[1];
		}

		protected function min($fieldname, $fieldvalue, $attributes)
		{
			return $fieldvalue >= $attributes;
		}

		protected function max($fieldname, $fieldvalue, $attributes)
		{
			return $fieldvalue <= $attributes;
		}

		protected function digits_between($fieldname, $fieldvalue, $attributes)
		{
			return strlen($fieldvalue) >= $attributes[0] && strlen($fieldvalue) <= $attributes[1];
		}

		protected function confirmed($fieldname, $fieldvalue, $attributes)
		{
			if(empty($attributes) || is_null($attributes))
				$attributes = $fieldname . '_confirmation';
			return $fieldvalue == $this->Inputs[$attributes];
		}

		protected function different($fieldname, $fieldvalue, $attributes)
		{
			return $fieldvalue != $this->Inputs[$attributes];
		}

		protected function accepted($fieldname, $fieldvalue, $attributes)
		{
			return !empty($fieldvalue) && !is_null($fieldvalue) && in_array(strtolower($fieldvalue), ['yes','on',1]);
		}

		protected function active_url($fieldname, $fieldvalue, $attributes)
		{
			return checkdnsrr($fieldvalue,'ANY');
		}

		protected function after($fieldname, $fieldvalue, $attributes)
		{
			if(isset($this->Inputs[$attributes]))
				$attributes = $this->Inputs[$attributes];
			return strtotime($fieldvalue) > strtotime($attributes);
		}

		protected function before($fieldname, $fieldvalue, $attributes)
		{
			if(isset($this->Inputs[$attributes]))
				$attributes = $this->Inputs[$attributes];
			return strtotime($fieldvalue) <= strtotime($attributes);
		}

		protected function alpha($fieldname, $fieldvalue, $attributes)
		{
			return ctype_alpha($fieldvalue);
		}

		protected function alpha_num($fieldname, $fieldvalue, $attributes)
		{
			return ctype_alnum($fieldvalue);
		}

		protected function alpha_dash($fieldname, $fieldvalue, $attributes)
		{
			return preg_match("/^[a-zA-Z0-9_\-]+$/", $fieldvalue);
		}

		protected function isDate($fieldname, $fieldvalue, $attributes)
		{
			$format = 'Y-m-d';
			$d = \DateTime::createFromFormat($format, $fieldvalue);
		    return $d && $d->format($format) == $fieldvalue;
		}

		protected function date_format($fieldname, $fieldvalue, $attributes)
		{
		    return date_parse_from_format($attributes,$fieldvalue)["error_count"] == 0? true:false;
		}

		protected function digits($fieldname, $fieldvalue, $attributes)
		{
		    return is_numeric($fieldvalue) && strlen($fieldvalue) == $attributes;
		}

		protected function email($fieldname, $fieldvalue, $attributes)
		{
		    return filter_var($fieldvalue, FILTER_VALIDATE_EMAIL);
		}

		protected function ip($fieldname, $fieldvalue, $attributes)
		{
		    return filter_var($fieldvalue, FILTER_VALIDATE_IP);
		}

		protected function url($fieldname, $fieldvalue, $attributes)
		{
		    return filter_var($fieldvalue, FILTER_VALIDATE_URL);
		}

		protected function integer($fieldname, $fieldvalue, $attributes)
		{
		    return is_integer($fieldvalue);
		}

		protected function regex($fieldname, $fieldvalue, $attributes)
		{
		    return preg_match($attributes,$fieldvalue);
		}

		protected function in($fieldname, $fieldvalue, $attributes)
		{
			$attr = [];
			if(is_array($attributes))
			{
				$attr = $attributes;
				$attributes = implode(',',$attributes);
			}else{
				foreach (explode(',',$attributes) as $value) {
					array_push($attr,trim($value));
				}
			}
		    return in_array($fieldvalue, $attr);
		}

		protected function not_in($fieldname, $fieldvalue, $attributes)
		{
			$attr = [];
			if(is_array($attributes))
			{
				$attr = $attributes;
				$attributes = implode(',',$attributes);
			}else{
				foreach (explode(',',$attributes) as $value) {
					array_push($attr,trim($value));
				}
			}
		    return !in_array($fieldvalue, $attr);
		}

		protected function max_filesize($fieldname, $fieldvalue, $attributes)
		{
			$fieldvalue = $_FILES[$fieldname]['size'];
			return $fieldvalue <= $attributes;
		}

		protected function min_filesize($fieldname, $fieldvalue, $attributes)
		{
			$fieldvalue = $_FILES[$fieldname]['size'];
			return $fieldvalue >= $attributes;
		}

		protected function mimes($fieldname, $fieldvalue, $attributes)
		{
			$attr = [];
			if(is_array($attributes))
			{
				$attr = $attributes;
				$attributes = implode(',',$attributes);
			}else{
				foreach (explode(',',$attributes) as $value) {
					array_push($attr,trim($value));
				}
			}
			$fieldvalue = end(explode('.',$_FILES[$fieldname]['name']));
			return in_array($fieldvalue,$attr);
		}

	}
}
