<?php
/**
 * Defines Player class.
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
 * Class Player.
 *
 * Player implements a player in the game.
 *
 * @package recAnalyst
 */
class Player
{
	/**
	 * Player's name.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Player's index.
	 *
	 * @var int
	 */
	public $index;

	/**
	 * Defines if the player is a human.
	 *
	 * @var bool
	 */
	public $human;

	/**
	 * Defines player's team index (0 = no team has been set).
	 *
	 * @var int
	 */
	public $team;

	/**
	 * Defines if player is an owner of the game.
	 *
	 * @var bool
	 */
	public $owner;

	/**
	 * Player's civilization.
	 *
	 * @var string
	 */
	public $civ;

	/**
	 * Id of player's civilization.
	 *
	 * @var int
	 */
	public $civId;

	/**
	 * Id of player's color.
	 *
	 * @var int
	 */
	public $colorId;

	/**
	 * Indicates if the player is cooping in the game.
	 *
	 * @var bool true if player coops, otherwise false
	 */
	public $isCooping;

	/**
	 * Player's feudal time (in ms, 0 if hasn't been reached).
	 *
	 * @var int
	 */
	public $feudalTime;

	/**
	 * Player's castle time (in ms).
	 *
	 * @var int
	 */
	public $castleTime;

	/**
	 * Player's imperial time (in ms).
	 *
	 * @var int
	 */
	public $imperialTime;

	/**
	 * Player's resign time (in ms) or 0 if player hasn't been resigned.
	 *
	 * @var int
	 */
	public $resignTime;

	/**
	 * An array of player's researches.
	 * An associative array containing "research id - time of research" pairs.
	 *
	 * @var array
	 */
	public $researches;

	/**
	 * Constructor.
	 *
	 */
	public function __construct ()
	{
		 $this->name = '';
		 $this->index = -1;
		 $this->human = false;
		 $this->team = -1;
		 $this->owner = false;
		 $this->civ = '';
		 $this->civId = 0;
		 $this->colorId = -1;
		 $this->isCooping = false;

		 $this->feudalTime = 0;
		 $this->castleTime = 0;
		 $this->imperialTime = 0;
		 $this->resignTime = 0;

		 $this->researches = array ();
	}
}
?>