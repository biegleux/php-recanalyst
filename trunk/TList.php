<?php
/**
 * Defines TList class.
 *
 * @package recAnalyst
 * @version $Id$
 * @author biegleux <biegleux[at]gmail[dot]com>
 * @copyright copyright (c) 2008-2009 biegleux
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 (GPLv3)
 * @link http://recanalyst.sourceforge.net/
 * @filesource
 */

/**
 * Class TList.
 *
 * TList implements a list.
 *
 * @package recAnalyst
 */
class TList implements Iterator
{
	/**
	 * Internal list of items.
	 *
	 * @var array
	 */
	protected $list;

	/**
	 * Number of items in the list.
	 *
	 * @var int
	 */
	protected $count;

	/**
	 * Class constructor.
	 *
	 */
	public function __construct ()
	{
		$this->list = array ();
		$this->count = 0;
	}

	/**
	 * Adds an item to the list.
	 *
	 * @param mixed $item the item we wish to add
	 */
	protected function addItem ($item)
	{
		$this->list[] = $item;
		$this->count++;
	}

	/**
	 * Returns an item at the specified offset.
	 *
	 * @param int $index the index of item
	 * @return mixed|bool the item or false if index is out of the range
	 */
	protected function getItem ($index)
	{
		return ($index >= 0 && $index < $this->count) ? $this->list[$index] : false;
	}

	/**
	 * Returns the number of items in the list.
	 *
	 * @return int the number of items
	 */
	public function getCount ()
	{
		return $this->count;
	}

	/**
	 * Clears the list.
	 *
	 * @return void
	 */
	public function clear ()
	{
		$this->list = array ();
		$this->count = 0;
	}

	/**
	 * Rewinds internal array pointer.
	 * This method is required by the interface Iterator.
	 *
	 * @return void
	 */
	public function rewind ()
	{
		if (is_array ($this->list) || is_object ($this->list))
		{
			reset ($this->list);
		}
	}

	/**
	 * Returns the current array item.
	 * This method is required by the interface Iterator.
	 *
	 * @return mixed the current array item
	 */
	public function current ()
   	{
   		if (!is_array ($this->list) && !is_object ($this->list))
   			return false;

		$var = current ($this->list);
		return $var;
	}

	/**
	 * Returns the key of the current array item.
	 * This method is required by the interface Iterator.
	 *
	 * @return int the key of the current array item
	 */
	public function key ()
	{
		$var = key ($this->list);
		return $var;
	}

	/**
	 * Moves the internal pointer to the next array item.
	 * This method is required by the interface Iterator.
	 *
	 * @return mixed the next array item
	 */
	public function next ()
	{
		$var = next ($this->list);
		return $var;
	}

	/**
	 * Returns whether there is an item at current position.
	 * This method is required by the interface Iterator.
	 *
	 * @return bool true if there is a item at current position, false otherwise
	 */
	public function valid ()
	{
		$var = $this->current () !== false;
		return $var;
	}
}
?>