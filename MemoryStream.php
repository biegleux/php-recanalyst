<?php
/**
 * Defines MemoryStream class.
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
 * Class MemoryStream.
 *
 * MemoryStream is a stream that stores its data in dynamic memory.
 * @package recAnalyst
 * @subpackage basics
 */
class MemoryStream extends Stream {

    /**
     * Internal data holder.
     * @var string
     */
    protected $_dataString = '';

    /**
     * Data size.
     * @var int
     */
    protected $_size = 0;

    /**
     * Current position.
     * @var int
     */
    protected $_position = 0;

    /**
     * Class constructor.
     * @param string $string Data string
     * @return void
     */
    public function __construct($string = '') {
        $this->_dataString = $string;
        $this->_size = strlen($this->_dataString);
        $this->_position = 0;
    }

    /**
     * Class destructor.
     * @return void
     */
    public function __destruct() {
        $this->_dataString = '';
        $this->_size = $this->_position = 0;
    }

    /**
     * @see Stream::read()
     */
    public function read(&$buffer, $count) {
        if ($count > 0 && ($len = $this->_size - $this->_position) > 0) {
            if ($len > $count) {
                $len = $count;
            }
            $buffer = substr($this->_dataString, $this->_position, $len);
            $this->_position += $len;
            return $len;
        }
        return 0;
    }

    /**
     * @see Stream::write()
     */
    public function write($buffer) {
        if ($this->_position == $this->_size) {
            $this->_dataString .= $buffer;
        } else {
            $this->_dataString = substr_replace($this->_dataString, $buffer, $this->_position, 0);
        }
        $this->_size += ($len = strlen($buffer));
        $this->_position += $len;
        return $len;
    }

    /**
     * @see Stream::seek()
     */
    public function seek($offset, $origin) {
        switch ($origin) {
            case self::soFromBeginning:
                $this->_position = $offset;
                break;
            case self::soFromCurrent:
                $this->_position += $offset;
                break;
            case self::soFromEnd:
                $this->_position = $this->_size - $offset;
                break;
        }
        if ($this->_position > $this->_size) {
            $this->_position = $this->_size;
        } elseif ($this->_position < 0) {
            $this->_position = 0;
        }
        return $this->_position;
    }

    /**
     * Moves the current position within the stream by the indicated offset, relative to the current position.
     * @param int $count Offset
     * @return The current position
     */
    public function skip($count) {
        return $this->seek($count, self::soFromCurrent);
    }

    /**
     * Returns the data string.
     * @return string
     */
    public function getDataString() {
        return $this->_dataString;
    }

    /**
     * Reads the string into the buffer.
     * @param string $buffer
     * @param int $length Indicates number of bytes holding string length information
     * @return void
     * @throws Exception
     */
    public function readString(&$buffer, $length = 4) {
        switch ($length) {
            case 2:
                $this->readWord($len);
                break;
            case 4:
                $this->readUInt($len);
                break;
            default:
                $this->readUInt($len);
                break;
        }
        if ($len) {
            $this->readBuffer($buffer, $len);
        } else {
            $buffer = '';
        }
    }

    /**
     * Reads integer value into the buffer.
     * @param int $buffer
     * @return void
     * @throws Exception
     */
    public function readUInt(&$buffer) {
        $this->readBuffer($bytes, 4);
        $buffer = ord($bytes{0}) | (ord($bytes{1}) << 8) | (ord($bytes{2}) << 16) | (ord($bytes{3}) << 24);
    }

    /**
     * Reads integer value into the buffer.
     * @param int $buffer
     * @return void
     * @throws Exception
     */
    public function readInt(&$buffer) {
        // !note: signed long (always 32 bit, machine byte order)
        $this->readBuffer($bytes, 4);
        $unpacked_data = unpack('l', $bytes);
        $buffer = $unpacked_data[1];
    }

    /**
     * Reads word value into the buffer.
     * @param int $buffer
     * @return void
     * @throws Exception
     */
    public function readWord(&$buffer) {
        $this->readBuffer($bytes, 2);
        $buffer = ord($bytes{0}) | (ord($bytes{1}) << 8);
    }

    /**
     * Reads char value into the buffer.
     * @param int $buffer
     * @return void
     * @throws Exception
     */
    public function readChar(&$buffer) {
        $this->readBuffer($bytes, 1);
        $buffer = ord($bytes{0});
    }

    /**
     * Reads float value into the buffer.
     * @param int $buffer
     * @return void
     * @throws Exception
     */
    public function readFloat(&$buffer) {
        $this->readBuffer($bytes, 4);
        $unpacked_data = unpack('f', $bytes);
        $buffer = $unpacked_data[1];
    }

    /**
     * Reads Bool value into the buffer.
     * @param int $buffer
     * @return void
     * @throws Exception
     */
    public function readBool(&$buffer) {
        $this->readUInt($int);
        $buffer = ($int == 0) ? false : true;
    }

    /**
     * Find position of first occurrence of a string in the stream.
     * @param int $needle The string to find
     * @return int Position in the stream or -1 if needle has not been not found
     */
    public function find($needle) {
        $pos = strpos($this->_dataString, $needle, $this->_position);
        if ($pos === false) {
            $pos = -1;
        } else {
            $this->_position = $pos;
        }
        return $pos;
    }

    /**
     * Find position of last occurrence of a string in the stream.
     * @param int $needle The string to find
     * @return int Position in the stream or -1 if needle has not been not found
     */
    public function rfind($needle, $offset = 0) {
        $pos = strrpos($this->_dataString, $needle, ($offset < 0) ? $offset : $this->_position);
        if ($pos == false) {
            $pos = -1;
        } else {
            $this->_position = $pos;
        }
        return $pos;
    }
}
?>
