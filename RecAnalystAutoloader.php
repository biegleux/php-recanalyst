<?php
/**
 * Defines RecAnalystAutoloader class.
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
 * Class RecAnalystAutoloader.
 *
 * @package recAnalyst
 */
class RecAnalystAutoloader
{
	static protected
		$registered = false,
		$instance = null;
	protected
		$baseDir = '';

	protected function __construct ()
	{
		$this->baseDir = realpath (dirname (__FILE__)) . DIRECTORY_SEPARATOR;
	}

	/**
	 * Retrieves the singleton instance of this class.
	 *
	 * @return RecAnalystAutoloader A RecAnalystAutoloader implementation instance.
	 */
	static public function getInstance ()
	{
		if (!isset (self::$instance))
		{
			self::$instance = new self ();
		}

		return self::$instance;
	}

	/**
	 * Register RecAnalystAutoloader in spl autoloader.
	 *
	 * @return void
	 */
	static public function register ()
	{
		if (self::$registered)
		{
			return;
		}

		ini_set ('unserialize_callback_func', 'spl_autoload_call');

		if (false === spl_autoload_register (array (self::getInstance (), 'autoload')))
		{
			throw new Exception (sprintf ('Unable to register %s::autoload as an autoloading method.',
			get_class (self::getInstance ())));
		}

		self::$registered = true;
	}

	/**
	 * Unregister RecAnalystAutoloader from spl autoloader.
	 *
	 * @return void
	 */
	static public function unregister ()
	{
		if (true === spl_autoload_unregister (array (self::getInstance (), 'autoload')))
		{
			self::$registered = false;
		}
	}

	/**
	 * Handles autoloading of classes.
	 *
	 * @param string $class A class name.
	 *
	 * @return bool Returns true if the class has been loaded
	 */
	public function autoload ($class)
	{
		if (class_exists ($class, false) || interface_exists ($class, false))
		{
			return true;
		}

		$file = $this->baseDir . $class . '.php';

		if (file_exists ($file)) {

			require ($file);

			return true;
		}

		return false;
	}

	/**
	 * Returns the base directory this autoloader is working on.
	 *
	 * @return string base directory
	 */
	public function getBaseDir ()
	{
		return $this->baseDir;
	}
}
?>