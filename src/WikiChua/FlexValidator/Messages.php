<?php 

namespace WikiChua\FlexValidator
{
	class Messages {

		protected $Messages = [
			'required' => ':field is required.',
			'same' => ':field must be same as :attribute.',
   			'between' => ':field must be between :attribute_1 and :attribute_2.',
			'confirmed' => ':field must be :attribute.',
			'different' => ':field must be different from :attribute.',
			'accepted' => ':field must be accepted.',
			'active_url' => ':field must be active url.',
			'after' => ':field must be after :attribute.',
			'before' => ':field must be before :attribute.',
			'alpha' => ':field must be alphabet only.',
			'alpha_num' => ':field must be alphabet numeric only.',
			'alpha_dash' => ':field must be alphabet numeric or dash or underscore only.',
			'isDate' => ':field must be valid date.',
			'date_format' => ':field must be valid date format :attribute.',
			'digits' => ':field must be numeric and must have an exact length of :attribute',
			'digits_between' => ':field must have a length between the given :attribute_1 and :attribute_2.',
			'email' => ':field must be formatted as an e-mail address.',
			'in' => ':field must be included in the given list of :attribute.',
			'not_in' => ':field must not be included in the given list of :attribute.',
			'integer' => ':field must have an integer value.',
			'ip' => ':field must be formatted as an IP address.',
			'min' => ':field must have minimum :attribute.',
			'max' => ':field must be less than a maximum :attribute.',
			'url' => ':field must be formatted as an URL.',
			'regex' => ':field must match the given regular expression :attribute.',
			'max_filesize' => ':field must be less than a maximum :attribute KB.',
			'min_filesize' => ':field must have minimum :attribute KB.',
			'mimes' => ':field must have a MIME type corresponding to one of the listed extensions :attribute.',
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
				if(strpos(':attribute_', $message) < 1)
				{
					$message = str_replace([':attribute'],[implode(',',$attributes)],$message);
				} else
				{
					foreach ($attributes as $attribute) {
						$message = str_replace([':attribute_'.$i],[$attribute],$message);
						$i++;
					}
				}
			}

			return $message;
		}
		
	}
}
