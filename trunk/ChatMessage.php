<?php
/**
 * Defines ChatMessage class.
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
 * Class ChatMessage.
 *
 * ChatMessage implements chat message.
 * @package recAnalyst
 */
class ChatMessage {

    /**
     * Time.
     * @var int
     */
    public $time;

    /**
     * Player.
     * @var Player
     */
    public $player;

    /**
     * Message text.
     * @var string
     */
    public $msg;

    /**
     * Class constructor.
     * @return void
     */
    public function __construct() {
        $this->time = 0;
        $this->player = null;
        $this->msg = '';
    }
}
?>
