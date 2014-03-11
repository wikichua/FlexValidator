<?php 

namespace WikiChua\FlexValidator
{
	class Messages {

		protected $Messages = [
			'required' => ':field is required.',
			'same' => ':field must be same as :attribute.',
   			'between' => ':field must be between :attribute_1 and :attribute_2.',
		];
		
		static public function make($method, $message, $fieldname, $attributes = [])
		{
			$self = new self;
			if(!isset($message) || empty($message))
			{
				$message = $self->Messages[$method];
			}

			if(( !is_array($attributes) && !empty($attributes) ) || is_null($attributes))
			{
				$message = str_replace([':field',':attribute'],[$fieldname,$attributes],$message);
			}else{
				$message = str_replace([':field'],[$fieldname],$message);
				$i = 1;
				foreach ($attributes as $attribute) {
					$message = str_replace([':attribute_'.$i],[$attribute],$message);
					$i++;
				}
			}

			return $message;
		}
		
	}
}
