<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 09/08/2017
 * Time: 16:13
 */

namespace SD;

use Zend\Http\Response;

/**
 * Base class for generic relationships which don't originally belong to an entity
 *
 * Class ACollection
 * @package SD
 */
abstract class ACollection
{
	private $items = array();

	/**
	 * Add item that relates to this entity
	 * If no key value is present, the value will be auto-generated
	 *
	 * @param mixed $item
	 * @param null $key
	 */
	public function addItem($item, $key = null)
	{
		if (null === $key) {
			$this->items[] = $item;
		} else {
			if (isset($this->items[$key])) {
				$this->addToExisting($item, $key);
			} else {
				$this->items[$key] = $item;
			}
		}
	}

	/**
	 * Remove item with given key
	 *
	 * @param mixed $key
	 * @throws \InvalidArgumentException
	 */
	public function deleteItem($key)
	{
		if (!isset($this->items[$key])) {
			$message = sprintf('Invalid key provided. Trying to delete an item with non existing key[%s]', Stringer::asString($key));
			throw new \InvalidArgumentException(
				$message,
				Response::STATUS_CODE_400
			);
		}
		unset($this->items[$key]);
	}

	/**
	 * @param mixed $key
	 * @return AModel
	 */
	public function getItem($key)
	{
		if (!isset($this->items[$key])) {
			$message = sprintf('Invalid key provided. Trying to retrieve an item with non existing key[%s]', Stringer::asString($key));
			throw new \InvalidArgumentException(
				$message,
				Response::STATUS_CODE_400
			);
		}

		return $this->items[$key];
	}

	/**
	 * Returns array of keys for stored items
	 *
	 * @return array
	 */
	public function keys()
	{
		return array_keys($this->items);
	}

	/**
	 * Returns number of items currently being stored
	 *
	 * @return int
	 */
	public function length()
	{
		return count($this->items);
	}

	/**
	 * Check if the record with given key existing within items
	 *
	 * @param mixed $key
	 * @return bool
	 */
	public function keyExists($key)
	{
		return isset($this->items[$key]);
	}

	/**
	 * Method was made as a part of solution for nested collections,
	 * but it can be used in general if there is a need to keep track of collection's keys
	 * If there is no such need, this method should throw duplicate key exception
	 * @param mixed $item
	 * @param mixed $key
	 * @return void
	 */
	abstract protected function addToExisting($item, $key);
}