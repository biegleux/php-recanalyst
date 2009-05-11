<?php
/**
 * Defines PlayerList class.
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
 * Class PlayerList.
 *
 * PlayerList implements list of players in a game.
 *
 * @package recAnalyst
 */
class PlayerList extends TList
{
	/**
	 * Adds a player to the list.
	 *
	 * @param Player $player the player we wish to add
	 */
	public function addPlayer (Player $player)
	{
		parent::addItem ($player);
	}

	/**
	 * Returns a player at the specified offset.
	 *
	 * @param int an index of the player
	 * @return Player|bool the player at the index or false if the index is out of the range
	 */
	public function getPlayer ($index)
	{
		return parent::getItem ($index);
	}

	/**
	 * Returns a player with the index property equal to the one defined.
	 *
	 * @param int $index player's index
	 * @return Player|bool false if no player has been found
	 */
	public function getPlayerByIndex ($index)
	{
		for ($i = 0; $i < $this->count; $i++)
		{
			if ($this->list[$i]->index == $index)
			{
				return $this->list[$i];
			}
		}
		return false;
	}
}
?>