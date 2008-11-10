d<?php
/**
 * Defines configuration constants used for RecAnalyst.
 *
 * @package recAnalyst
 * @version $Id$
 * @author biegleux <biegleux@gmail.com>
 * @copyright copyright (c) 2008 biegleux
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 (GPLv3)
 * @link http://recanalyst.sourceforge.net/
 * @since v0.9.0
 * @filesource
 */

/**
 * Defines a path (absolute or relative) to directory where we wish to save generated maps.
 * Write permission is required.
 */
define ('RA__MAPS_DIR',				'/www/htdocs/.../');

/**
 * Defines a path (absolute or relative) to directory where we wish to save generated research timelines.
 * Write permission is required.
 */
define ('RA__RESEARCHES_DIR',		'/www/htdocs/.../');

/**
 * Defines a path (absolute or relative) to directory where we store resources required for generating research timelines.
 */
define ('RA__RESOURCES_DIR',		'/www/htdocs/.../');

/**
 * Defines a width of the map image we wish to generate.
 *
 */
define ('RA__MAP_WIDTH',			204);

/**
 * Defines a height of the map image we wish to generate.
 *
 */
define ('RA__MAP_HEIGHT',			102);

// following configuration constants are applied for research timelines image
/**
 * Defines width and height of one research tile in research timelines image.
 */
define ('RA__RESEARCH_TILE_SIZE',	19);

/**
 * Defines vertical spacing between players in research timelines image.
 */
define ('RA__RESEARCH_VSPACING',	8);
?>