<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 09/08/2017
 * Time: 15:41
 */

namespace SD;

/**
 * Base model class with magic setter implementation
 * Used for \PDO class fetch mode mapping entity to object
 *
 * Class AModel
 * @package SD
 */
abstract class AModel extends ACollection
{
	/**
	 * Magic setter used by \PDO whit fetch mode set to class
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return void
	 */
	public function __set(string $name, $value)
	{
		$name = $this->resolveName($name);
		if (property_exists($this, $name)) {
			$this->$name = $value;
		}
	}

	/**
	 * Default implementation for mapping database field names to object properties.
	 * Can be overridden to match specific use-cases.
	 *
	 * @param string $name Database column name
	 * @return string Resolved property name
	 */
	protected function resolveName(string $name): string
	{
		return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $name))));
	}
}