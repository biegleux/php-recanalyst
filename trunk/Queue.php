<?php
/**
 * Defines Queue class.
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
 * Class Queue.
 *
 * Queue implements queue.
 * @package recAnalyst
 * @subpackage basics
 */
class Queue {

	/**
	 * Internal queue representation.
	 * @var array
	 */
	protected $_queue;

	/**
	 * Class constructor.
	 * @return void
	 */
	public function __construct() {

		$this->_queue = array();
	}

	/**
	 * Add an item to the queue.
	 * @param mixed $var Item to add.
	 * @return mixed Item that was just added.
	 */
	public function push($var) {

		$this->_queue[] = $var;
		return $var;
	}

	/**
	 * Removes and returns the next item in the queue.
	 * @return mixed
	 */
	public function pop() {

		return array_shift($this->_queue);
	}

	/**
	 * Checks the size of the queue.
	 * @param int $count
	 * @return bool True if the number of items in the queue is greater than or equal to $count.
	 */
	public function atLeast($count) {

		return count($this->_queue) >= $count;
	}
}