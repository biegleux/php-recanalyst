<?php
/**
 * Defines TList class.
 *
 * @package recAnalyst
 * @version $Id$
 * @author biegleux <biegleux[at]gmail[dot]com>
 * @copyright copyright (c) 2008-2010 biegleux
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 (GPLv3)
 * @link http://recanalyst.sourceforge.net/
 * @filesource
 */

/**
 * Class TList.
 *
 * TList implements a list.
 * @package recAnalyst
 * @subpackage basics
 */
class TList implements Iterator {

	/**
	 * Internal list of items.
	 * @var array
	 */
	protected $_list;

	/**
	 * Number of items in the list.
	 * @var int
	 */
	protected $_count;

	/**
	 * Class constructor.
	 *
	 * @return void
	 */
	public function __construct() {

		$this->_list = array();
		$this->_count = 0;
	}

	/**
	 * Adds an item to the list.
	 *
	 * @param mixed $item The item we wish to add.
	 * @return void
	 */
	protected function addItem($item) {

		$this->_list[] = $item;
		$this->_count++;
	}

	/**
	 * Adds an item to the list.
	 * @param mixed $item The item we wish to add.
	 * @return void
	 * @see TList::addItem()
	 */
	public function add($item) {

		$this->addItem($item);
	}

	/**
	 * Returns an item at the specified offset.
	 *
	 * @param int $index The index of item.
	 * @return mixed|bool The item or false if index is out of the range.
	 */
	protected function getItem($index) {

		return ($index >= 0 && $index < $this->_count) ? $this->_list[$index] : false;
	}

	/**
	 * Returns an item at the specified offset.
	 * @param int $index The index of item.
	 * @return mixed|bool The item or false if index is out of the range.
	 * @see TList::getItem()
	 */
	public function get($index) {

		return $this->getItem($index);
	}

	/**
	 * Returns the number of items in the list.
	 *
	 * @return int The number of items.
	 */
	public function count() {

		return $this->_count;
	}

	/**
	 * Performs sorting on the list based on the comparison function $compare.
	 * @param callback $compare Comparison function that indicates how the items are to be ordered.
	 * @return void
	 */
	public function sort($compare) {

		if ($this->_count > 0) {
			usort($this->_list, $compare);
		}
	}

	/**
	 * Clears the list.
	 * @return void
	 */
	public function clear() {

		$this->_list = array();
		$this->_count = 0;
	}

	/**
	 * Rewinds internal array pointer.
	 * This method is required by the interface Iterator.
	 *
	 * @return void
	 */
	public function rewind() {

		if (is_array($this->_list) || is_object($this->_list)) {
			reset($this->_list);
		}
	}

	/**
	 * Returns the current array item.
	 * This method is required by the interface Iterator.
	 *
	 * @return mixed The current array item.
	 */
	public function current() {

   		if (!is_array($this->_list) && !is_object($this->_list)) {
   			return false;
   		}

		$var = current($this->_list);
		return $var;
	}

	/**
	 * Returns the key of the current array item.
	 * This method is required by the interface Iterator.
	 *
	 * @return int The key of the current array item.
	 */
	public function key() {

		$var = key($this->_list);
		return $var;
	}

	/**
	 * Moves the internal pointer to the next array item.
	 * This method is required by the interface Iterator.
	 *
	 * @return mixed The next array item.
	 */
	public function next() {

		$var = next($this->_list);
		return $var;
	}

	/**
	 * Returns whether there is an item at current position.
	 * This method is required by the interface Iterator.
	 *
	 * @return bool True if there is a item at current position, false otherwise.
	 */
	public function valid() {

		$var = $this->current() !== false;
		return $var;
	}
}
?>