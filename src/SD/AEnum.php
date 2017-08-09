<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 09/08/2017
 * Time: 15:54
 */

namespace SD;

/**
 * Base class for entities having property with predefined values
 *
 * Class AEnum
 * @package SD
 */
abstract class AEnum
{
	private static $items = [];

	/**
	 * Check if a constant with given name is defined for object being called
	 *
	 * @param string $name
	 * @param bool $strict
	 * @return bool
	 */
	public static function isValidName(string $name, bool $strict = false): bool
	{
		$constants = self::getConstants();
		if (!$strict) {
			$constants = array_change_key_case($constants);
			$name = strtolower($name);
		}

		return key_exists($name, $constants);
	}

	/**
	 * Check if the given value is defined as one of the constant values
	 *
	 * @param mixed $value
	 * @return bool
	 */
	public static function isValidValue($value): bool
	{
		$values = array_values(self::getConstants());

		return in_array($value, $values, true);
	}

	/**
	 * Get all the constants from called class using reflection
	 *
	 * @return array
	 */
	public static function getConstants(): array
	{
		$calledClass = get_called_class();
		if (!key_exists($calledClass, self::$items)) {
			$reflect = new \ReflectionClass($calledClass);
			self::$items[$calledClass] = $reflect->getConstants();
		}

		return self::$items[$calledClass];
	}
}