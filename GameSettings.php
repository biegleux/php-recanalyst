<?php
/**
 * Defines GameSettings class.
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
 * GameSettings class
 *
 * GameSettings implements game information holder.
 *
 * @package recAnalyst
 */
class GameSettings
{
	/**
	 * Game type.
	 *
	 * @var string
	 */
	public $gameType;

	/**
	 * Game style.
	 *
	 * @var string
	 */
	public $gameStyle;

	/**
	 * Map.
	 *
	 * @var string
	 */
	public $map;

	/**
	 * Game duration.
	 *
	 * @var int
	 */
	public $playTime;

	/**
	 * Difficulty level.
	 *
	 * @var string
	 */
	public $difficultyLevel;

	/**
	 * Population limit.
	 *
	 * @var int
	 */
	public $popLimit;

	/**
	 * Game speed.
	 *
	 * @var string
	 */
	public $speed;

	/**
	 * Diplomacy lock status.
	 *
	 * @var bool
	 */
	public $lockDiplomacy;

	/**
	 * Specifies if the game is a scenario.
	 *
	 * @var bool
	 */
	public $isScenario;

	/**
	 * Specifies if there is a cooping player in the game.
	 *
	 * @var bool
	 */
	public $inGameCoop;

	/**
	 * Reveal Map setting.
	 *
	 * @var string
	 */
	public $revealMap;

	/**
	 * Map size.
	 *
	 * @var string
	 */
	public $mapSize;

	/**
	 * Constructor.
	 *
	 */
	public function __construct ()
	{
		$this->popLimit = 0;
		$this->lockDiplomacy = false;
		$this->speed = '';
		$this->map = '';
		$this->difficultyLevel = '';
		$this->gameType = '';
		$this->gameStyle = '';
		$this->isScenario = false;
		$this->inGameCoop = false;
		$this->playTime = 0;
		$this->revealMap = '';
		$this->mapSize = '';
	}
}
?>