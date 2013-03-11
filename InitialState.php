<?php
/**
 * Defines InitialState class.
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
 * Class InitialState.
 *
 * InitialState implements initial state of a player.
 * @package recAnalyst
 */
class InitialState {

    /**
     * Initial food.
     * @var int
     */
    public $food;

    /**
     * Initial wood
     * @var int
     */
    public $wood;

    /**
     * Initial stone.
     * @var int
     */
    public $stone;

    /**
     * Initial gold.
     * @var int
     */
    public $gold;

    /**
     * Starting age.
     * @var int
     * @see StartingAge
     */
    public $startingAge;

    /**
     * Initial house capacity.
     * @var int
     */
    public $houseCapacity;

    /**
     * Initial population.
     * @var int
     */
    public $population;

    /**
     * Initial civilian population.
     * @var int
     */
    public $civilianPop;

    /**
     * Initial military population.
     * @var int
     */
    public $militaryPop;

    /**
     * Initial extra population.
     * @var int
     */
    public $extraPop;

    /**
     * Initial position.
     * @var array
     */
    public $position;

    /**
     * Class constructor.
     * @return void
     */
    public function __construct() {
        $this->food = $this->wood = $this->stone = 0;
        $this->startingAge = StartingAge::DARKAGE;
        $this->houseCapacity = 0;
        $this->population = $this->civilianPop = $this->militaryPop = $this->extraPop = 0;
        $this->position = array(0, 0);
    }

    /**
     * Returns starting age string.
     * @return string
     */
    public function getStartingAgeString() {
        return isset(RecAnalystConst::$STARTING_AGES[$this->startingAge]) ?
            RecAnalystConst::$STARTING_AGES[$this->startingAge] : '';
    }
}
?>
