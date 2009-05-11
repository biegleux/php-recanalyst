<?php
/**
 * Defines RecAnalystConfig class.
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
 * Class RecAnalystConfig.
 *
 * Configuration singleton class.
 * RecAnalystConfig implements configuration constants used for RecAnalyst.
 *
 * @package recAnalyst
 */
class RecAnalystConfig
{
	/**
	 * Instance holder of this class.
	 *
	 * @var RecAnalystConfig
	 * @static
	 */
	private static $instance = null;

	/**
	 * Defines a path (absolute or relative) to directory where we wish to save generated maps.
	 * Write permission is required.
	 *
	 * @var string
	 */
	public $mapsDir;

	/**
	 * Defines a path (absolute or relative) to directory where we wish to save generated research timelines.
	 * Write permission is required.
	 *
	 * @var string
	 */
	public $researchesDir;

	/**
	 * Defines a path (absolute or relative) to directory where we store resources required for generating research timelines.
	 *
	 * @var string
	 */
	public $resourcesDir;

	/**
	 * Defines a width of the map image we wish to generate.
	 *
	 * @var int
	 */
	public $mapWidth;

	/**
	 * Defines a height of the map image we wish to generate.
	 *
	 * @var int
	 */
	public $mapHeight;

	/* following two configuration constants are applied for research timelines image */

	/**
	 * Defines width and height of one research tile in research timelines image.
	 *
	 * @var int
	 */
	public $researchTileSize;

	/**
	 * Defines vertical spacing between players in research timelines image.
	 *
	 * @var int
	 */
	public $researchVSpacing;

	/**
	 * Defines background image for research timelines image.
	 *
	 * @var string
	 */
	public $researchBackgroundImage;

	/**
	 * Defines color for Dark Age in the research timelines image.
	 * Array consist of red, green, blue color and alpha.
	 *
	 * @var array
	 */
	public $researchDAColor;

	/**
	 * Defines color for Dark Age in the research timelines image.
	 *
	 * @var array
	 * @see $researchDAColor
	 */
	public $researchFAColor;

	/**
	 * Defines color for Dark Age in the research timelines image.
	 *
	 * @var array
	 * @see $researchDAColor
	 */
	public $researchCAColor;

	/**
	 * Defines color for Dark Age in the research timelines image.
	 *
	 * @var array
	 * @see $researchDAColor
	 */
	public $researchIAColor;

	/**
	 * Determines if to show players positions on the map.
	 *
	 * @var bool true if it is desirable to show players positions, false otherwise
	 */
	public $showPositions;

	/**
	 * Determines if to use snow colors for terrain instead of game's default ones.
	 *
	 * @var bool true if it is desirable to use snow colors, false otherwise
	 */
	public $useSnowColors;

	/**
	 * Private class constructor.
	 *
	 */
	private function __construct ()
	{
		$this->mapsDir = '/www/htdocs/.../';
		$this->researchesDir = '/www/htdocs/.../';
		$this->resourcesDir = '/www/htdocs/.../';
		$this->mapWidth = 204;
		$this->mapHeight = 102;
		$this->researchTileSize = 19;
		$this->researchVSpacing = 8;
		$this->researchBackgroundImage = $this->resourcesDir . 'researches' . DIRECTORY_SEPARATOR . 'background.jpg';
		$this->researchDAColor = array (0xff, 0x00, 0x00, 0x50);
		$this->researchFAColor = array (0x00, 0xff, 0x00, 0x50);
		$this->researchCAColor = array (0x00, 0x00, 0xff, 0x50);
		$this->researchIAColor = array (0x99, 0x66, 0x00, 0x50);
		$this->showPositions = true;
		$this->useSnowColors = true;
	}

	/**
	 * Disallow cloning.
	 *
	 */
	private function __clone ()
	{
	}

	/**
	 * Retrieves the singleton instance of this class.
	 *
	 * @return RecAnalystConfig A RecAnalystConfig implementation instance.
	 */
	public static function getInstance ()
	{
		if (!isset (self::$instance))
		{
			self::$instance = new self ();
		}

		return self::$instance;
	}
}
?>