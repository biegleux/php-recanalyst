<?php
/**
 * Defines GameInfo class.
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
 * Class GameInfo.
 *
 * GameInfo holds information about analyzed game.
 * @package recAnalyst
 */
class GameInfo {

	/**
	 * RecAnalyst owner instance.
	 * @var RecAnalyst
	 */
	protected $_owner;

	/**
	 * Game version.
	 * @var int
	 * @see GameVersion
	 */
	public $_gameVersion;

	/**
	 * Game duration.
	 * @var int
	 */
	public $playTime;

	/**
	 * Objectives string.
	 * @var string
	 */
	public $objectivesString;

	/**
	 * Original Scenario filename.
	 * @var string
	 */
	public $scFileName;

	/**
	 * Class constructor.
	 * @param RecAnalyst $recanalyst Owner.
	 * @return void
	 */
	public function __construct(RecAnalyst $recanalyst) {

		$this->_owner = $recanalyst;
		$this->_gameVersion = GameVersion::UNKNOWN;
		$this->playTime = 0;
		$this->objectivesString = $this->scFileName = '';
	}

	/**
	 * Returns game versions string.
	 * @return string
	 */
	public function getGameVersionString() {

		return isset(RecAnalystConst::$GAME_VERSIONS[$this->_gameVersion]) ?
			RecAnalystConst::$GAME_VERSIONS[$this->_gameVersion] : '';
	}

	/**
	 * Returns the players string (1v1, FFA, etc.)
	 * @return string
	 */
	public function getPlayersString() {

		// players
		$idx = 0;
		$team_ary = array(0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($this->_owner->teams as $team) {

			foreach ($team as $player) {
				if (!$player->isCooping) {
					$team_ary[$idx]++;
				}
			}
			$idx++;
		}
		$team_ary = array_diff($team_ary, array(0));
		if (array_sum($team_ary) == $this->_owner->teams->count() && $this->_owner->teams->count() > 2) {
			return 'FFA';
		}
		else {
			return implode($team_ary, 'v');
		}
	}

	/**
	 * Returns the point of view.
	 * @return string
	 */
	public function getPOV() {

		foreach ($this->_owner->players as $player) {
			if ($player->owner) {
				return $player->name;
			}
		}

		return '';
	}

	/**
	 * Returns extended point of view (including coop players).
	 * @var string
	 */
	public function getPOVEx() {

		$owner = null;
		foreach ($this->_owner->players as $player) {

			if ($this->_owner->player->owner) {

				$owner = $this->_owner->player;
				break;
			}
		}
		if (!$owner) {
			return '';
		}

		$names = array();
		foreach ($this->_owner->players as $player) {

			if ($player === $owner) {
				continue;
			}
			if ($player->index == $owner->index) {
				$names[] = $player->name;
			}
		}
		if (empty($names)) {
			return $owner->name;
		}

		return sprintf('%s (%s)', $owner->name, implode($names, ', '));
	}

	/**
	 * Determines if there is a cooping player in the game.
	 * @return bool True, if there is a cooping player in the game, false otherwise.
	 */
	public function ingameCoop() {

		foreach ($this->_owner->players as $player) {
			if ($player->isCooping) {
				return true;
			}
		}

		return false;
	}
}