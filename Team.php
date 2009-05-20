<?php
/**
 * Defines Team class.
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
 * Class Team.
 *
 * Team implements a team in the game.
 *
 * @package recAnalyst
 */
class Team extends PlayerList
{
	/**
	 * Team's index.
	 *
	 * @var int
	 */
	private $index;

	/**
	 * Class constructor.
	 *
	 */
	public function __construct ()
	{
		parent::__construct();
		$this->index = -1;
	}

	/**
	 * Adds a player to the team.
	 *
	 * @param Player $player the player we wish to add
	 */
	public function addPlayer (Player $player)
	{
		parent::addPlayer ($player);

		if ($this->index == -1)
		{
			$this->index = $player->team;
		}
	}

	/**
	 * Returns an index of the team.
	 *
	 * @return int team's index
	 */
	public function getIndex ()
	{
		return $this->index;
	}
}
?>