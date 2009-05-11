<?php
/**
 * Defines TeamList class.
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
 * Class TeamList.
 *
 * TeamList implements a list of teams in the game.
 *
 * @package recAnalyst
 */
class TeamList extends TList
{
	/**
	 * Adds a team to the list
	 *
	 * @param Team $team the team we wish to add
	 */
	public function addTeam (Team $team)
	{
		parent::addItem ($team);
	}

	/**
	 * Returns a team at the specified offset.
	 *
	 * @param int $index an index of the team
	 * @return Team|bool the team or false if the index is out of the range
	 */
	public function getTeam ($index)
	{
		return parent::getItem ($index);
	}

	/**
	 * Returns a team with its index equal as the one required.
	 *
	 * @param int $index team's index
	 * @return Team|bool the team or false if no team has been found
	 */
	public function getTeamByIndex ($index)
	{
		for ($i = 0; $i < $this->count; $i++)
		{
			if ($this->list[$i]->getIndex () == $index)
			{
				return $this->list[$i];
			}
		}
		return false;
	}
}
?>