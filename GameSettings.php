<?php
/**
 * Defines GameSettings class.
 *
 * @package recAnalyst
 * @version $Id$
 * @author biegleux <biegleux[at]gmail[dot]com>
 * @copyright copyright (c) 2008-2013 biegleux
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 (GPLv3)
 * @link http://recanalyst.sourceforge.net/
 * @filesource
 */

/**
 * Class GameSettings.
 *
 * GameSettings implements game information holder.
 * @package recAnalyst
 */
class GameSettings {

    /**
     * RecAnalyst owner instance.
     * @var RecAnalyst
     */
    protected $_owner;

    /**
     * Game type.
     * @var int
     * @see GameType
     */
    public $_gameType;

    /**
     * Map style.
     * @var int
     * @see MapStyle
     */
    public $_mapStyle;

    /**
     * Difficulty level.
     * @var int
     * @see DifficultyLevel
     */
    public $_difficultyLevel;

    /**
     * Game speed.
     * @var int
     * @see GameSpeed
     */
    public $_gameSpeed;

    /**
     * Reveal Map setting.
     * @var int
     * @see RevealMap
     */
    public $_revealMap;

    /**
     * Map size.
     * @var int
     * @see MapSize
     */
    public $_mapSize;

    /**
     * Map id.
     * @var int
     * @see Map
     */
    public $_mapId;

    /**
     * Map.
     * @var string
     */
    public $map;

    /**
     * Population limit.
     * @var int
     */
    public $popLimit;

    /**
     * Diplomacy lock status.
     * @var bool
     */
    public $lockDiplomacy;

    /**
     * Victory settings.
     * @var Victory
     */
    public $victory;

    /**
     * Class constructor.
     * @return void
     */
    public function __construct(RecAnalyst $recanalyst) {
        $this->_owner = $recanalyst;
        $this->_gameType = GameType::RANDOMMAP;
        $this->_mapStyle = MapStyle::STANDARD;
        $this->_difficultyLevel = DifficultyLevel::HARDEST;
        $this->_gameSpeed = GameSpeed::NORMAL;
        $this->_revealMap = RevealMap::NORMAL;
        $this->_mapSize = MapSize::TINY;
        $this->map = '';
        $this->_mapId = $this->popLimit = 0;
        $this->lockDiplomacy = false;
        $this->victory = new Victory();
    }

    /**
     * Returns game type string.
     * @return string
     */
    public function getGameTypeString() {
        return isset(RecAnalystConst::$GAME_TYPES[$this->_gameType]) ?
            RecAnalystConst::$GAME_TYPES[$this->_gameType] : '';
    }

    /**
     * Returns map style string.
     * @return string
     */
    public function getMapStyleString() {
        return isset(RecAnalystConst::$MAP_STYLES[$this->_mapStyle]) ?
            RecAnalystConst::$MAP_STYLES[$this->_mapStyle] : '';
    }

    /**
     * Returns difficulty level string.
     * @return string
     */
    public function getDifficultyLevelString() {
        switch ($this->_owner->gameInfo->_gameVersion) {
            case GameVersion::AOC:
            case GameVersion::AOC10:
            case GameVersion::AOC10C:
            case GameVersion::AOCTRIAL:
                return RecAnalystConst::$DIFFICULTY_LEVELS[$this->_difficultyLevel];
                break;
            case GameVersion::AOK:
            case GameVersion::AOK20:
            case GameVersion::AOK20A:
            case GameVersion::AOKTRIAL:
                return RecAnalystConst::$AOK_DIFFICULTY_LEVELS[$this->_difficultyLevel];
                break;
            case GameVersion::UNKNOWN:
            default:
                return '';
                break;
        }
    }

    /**
     * Returns game speed string.
     * @return string
     */
    public function getGameSpeedString() {
        return isset(RecAnalystConst::$GAME_SPEEDS[$this->_gameSpeed]) ?
            RecAnalystConst::$GAME_SPEEDS[$this->_gameSpeed] : sprintf('(%.1f)', $this->_gameSpeed / 10);
    }

    /**
     * Returns reveal map string.
     * @return string
     */
    public function getRevealMapString() {
        return isset(RecAnalystConst::$REVEAL_SETTINGS[$this->_revealMap]) ?
            RecAnalystConst::$REVEAL_SETTINGS[$this->_revealMap] : '';
    }

    /**
     * Returns map size string.
     * @return string
     */
    public function getMapSizeString() {
        return isset(RecAnalystConst::$MAP_SIZES[$this->_mapSize]) ?
            RecAnalystConst::$MAP_SIZES[$this->_mapSize] : '';
    }

    /**
     * Returns true if game type is scenario, false otherwise.
     * @return bool
     */
    public function isScenario() {
        return $this->_gameType == GameType::SCENARIO;
    }
}
?>
