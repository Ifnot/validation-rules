<?php namespace Ifnot\ValidationRules;

use Illuminate\Validation\Validator as IlluminateValidator;

/**
 * Class Validator
 * @package Ifnot\ValidationRules
 */
class Validator extends IlluminateValidator
{
	/**
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 *
	 * @return bool
	 */
	public function validateMayIn($attribute, $value, $parameters)
	{
		return true;
	}
	
	/**
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 *
	 * @return bool
	 */
	public function validateHidden($attribute, $value, $parameters)
	{
		return true;
	}
	
	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateNumberInterval($attribute, $value, $parameters)
	{
		return true;
		
		$value = trim($value);
		
		if (! preg_match('#^[<>][0-9]*$#', $value)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 *
	 * @return int
	 */
	public function validatePhone($attribute, $value, $parameters)
	{
		return preg_match('#^0[1-9]([-. ]?[0-9]{2}){4}$#', $value);
	}
	
	/**
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 *
	 * @return bool
	 */
	public function validateDepartment($attribute, $value, $parameters)
	{
		$departments = json_decode(file_get_contents('http://geo.api.web-6.fr/departments?search[id]='.$value), true);
		
		return count($departments) > 0;
	}
	
	/**
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 *
	 * @return bool
	 */
	public function validateCity($attribute, $value, $parameters)
	{
		$cities = json_decode(file_get_contents('http://geo.api.web-6.fr/cities?search[id]='.$value), true);
		
		return count($cities) > 0;
	}
	
	/**
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 *
	 * @return bool
	 */
	public function validateEach($attribute, $value, $parameters)
	{
		// Transform the each rule
		// For example, `each:exists,users,name` becomes `exists:users,name`
		$ruleName = array_shift($parameters);
		$rule = $ruleName.(count($parameters) > 0 ? ':'.implode(',', $parameters) : '');
		
		foreach ($value as $arrayKey => $arrayValue) {
			if(method_exists($this, 'validateAttribute')) {
				$this->validateAttribute($attribute.'.'.$arrayKey, $rule);
			}
			else {
				$this->validate($attribute.'.'.$arrayKey, $rule);
			}
		}
		
		// Always return true, since the errors occur for individual elements.
		return true;
	}
}
