<?php
/**
 * Defines Tribute class.
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
 * Class Tribute.
 *
 * Tribute represents a tribute.
 * @package recAnalyst
 */
class Tribute {

	/**
	 * Time this tribute was sent.
	 * @var int
	 */
	public $time;

	/**
	 * Player this tribute was sent from.
	 * @var Player
	 */
	public $playerFrom;

	/**
	 * Player this tribute was sent to.
	 * @var Player
	 */
	public $playerTo;

	/**
	 * Id of the resource this tribute was sent.
	 * @var int
	 * @see Resource
	 */
	public $resourceId;

	/**
	 * Amount of the resource.
	 * @var int
	 */
	public $amount;

	/**
	 * Market fee.
	 * @var float
	 */
	public $fee;

	/**
	 * Class constructor.
	 * @return void
	 */
	public function __construct() {

		$this->time = $this->amount = 0;
		$this->playerFrom = $this->playerTo = null;
		$this->resourceId = Resource::FOOD;
		$this->free = 0.0;
	}
}
?>