<?php
/**
 * Defines UnitObject class.
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
 * Class UnitObject.
 *
 * UnitObject represents an unit object in the game.
 * @package recAnalyst
 */
class UnitObject {

	/**
	 * Id of the player who owns this unit. Zero if GAIA.
	 * @var int
	 */
	public $owner = 0;

	/**
	 * Unit it.
	 * @var int
	 */
	public $id = 0;

	/**
	 * Unit location.
	 * @var array
	 */
	public $position = array(0, 0);
}
?>