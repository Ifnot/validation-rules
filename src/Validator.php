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

		if (!preg_match('#^[<>][0-9]*$#', $value)) {
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
	public function validateEach($attribute, $value, $parameters)
	{
		// Transform the each rule
		// For example, `each:exists,users,name` becomes `exists:users,name`
		$ruleName = array_shift($parameters);
		$rule = $ruleName . (count($parameters) > 0 ? ':' . implode(',', $parameters) : '');

		foreach ($value as $arrayKey => $arrayValue) {
			$this->validate($attribute . '.' . $arrayKey, $rule);
		}

		// Always return true, since the errors occur for individual elements.
		return true;
	}

	/**
	 * Get the displayable name of the attribute.
	 *
	 * @param  string $attribute
	 * @return string
	 */
	protected function getAttribute($attribute)
	{
		// Get the second to last segment in singular form for arrays.
		// For example, `group.names.0` becomes `name`.
		if (str_contains($attribute, '.')) {
			$segments = explode('.', $attribute);

			$attribute = str_singular($segments[count($segments) - 2]);
		}

		return parent::getAttribute($attribute);
	}
}