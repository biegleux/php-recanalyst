<?php
/**
 * Defines RecArchive class.
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
 * Class RecArchive.
 * RecArchive implements Zip archive containing recorded games.
 *
 * @package recAnalyst
 */
class RecArchive {

    /**
     * Contains entry details.
     * @var array
     */
    protected $_stats;

    /**
     * Zip file archive.
     * @var ZipArchive
     */
    protected $_zip;

    /**
     * Determines if the archive is open.
     * @var bool
     */
    protected $_open;

    const MGX_EXT = 'mgx';
    const MGL_EXT = 'mgl';
    const MGZ_EXT = 'mgz';

    /**
     * Class constructor.
     * @return void
     */
    public function __construct() {
        $this->_stats = array();
        $this->_zip = new ZipArchive();
        $this->_open = false;
    }

    /**
     * Opens a file archive.
     * @param string $filename The file name of the archive to open.
     * @return void
     * @throws Exception
     */
    public function open($filename) {
        if ($this->_zip->open($filename) !== true) {
            throw new Exception(sprintf('Unable to open zip archive %s.', $filename));
        }
        $this->_open = true;
        $this->getDetails();
    }

    /**
     * Close the active archive.
     * @return void
     */
    public function close() {
        if ($this->_open) {
            $this->_zip->close();
        }
    }

    /**
     * Get a file handler to the entry defined by its name.
     * @param string $name The name of the entry to use
     * @return resource|bool File pointer (resource) on success or false on failure
     * @throws Exception
     */
    public function getFileHandler($name) {
        if (!$this->_open) {
            throw new Exception('No archive has been opened.');
        }
        return $this->_zip->getStream($name);
    }

    /**
     * Returns the entry contents using its name.
     * @param string $name The name of the entry
     * @return mixed The contents of the entry on success or false on failure
     * @throws Exception
     */
    public function getFileContents($name) {
        if (!$this->_open) {
            throw new Exception('No archive has been opened.');
        }
        return $this->_zip->getFromName($name);
    }

    /**
     * Get the details of the entries in the archive.
     * @return void
     * @throws Exception
     */
    protected function getDetails() {
        if (!$this->_open) {
            throw new Exception('No archive has been opened.');
        }
        for ($i = 0; false !== ($stat = $this->_zip->statIndex($i)); $i++) {
            // skip directories and 0-bytes files
            if (!$stat['size']) {
                continue;
            }
            // skip useless files
            $ext = strtolower(pathinfo($stat['name'], PATHINFO_EXTENSION));
            if ($ext != self::MGX_EXT && $ext != self::MGL_EXT && $ext != self::MGZ_EXT) {
                continue;
            }
            $this->_stats[] = $stat;
        }
    }

    /**
     * Returns entry details.
     * @return array
     */
    public function getStats() {
        return $this->_stats;
    }
}
?>
