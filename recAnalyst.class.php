<?php
/* *************************************************************************
 *                       AOC Recorded Games Analyzer
 *                       ---------------------------
 *    begin            : Monday, December 3, 2007
 *    copyright        : (c) 2007-2008 biegleux
 *    email            : biegleux(at)gmail(dot)com
 *
 *    recAnalyst v0.9.0 2008/11/07
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see http://www.gnu.org/licenses/.
 *
 *    Thanks to bari [aocai-lj(at)infoseek.jp] for sharing mgx file format
 *    description.
 *
 *    Note: Code is not fully optimized, any suggestions appreciated.
 ************************************************************************* */
/**
 * Defines RecAnalyst class.
 *
 * @package recAnalyst
 * @version $Id$
 * @author biegleux <biegleux@gmail.com>
 * @copyright copyright (c) 2008 biegleux
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 (GPLv3)
 * @link http://recanalyst.sourceforge.net/
 * @filesource
 * @todo rar extension support
 * @todo test for server zlib/zip extension support
 * @todo implement method/member for holding analyze time
 */

// uncomment following line if we want to debug
//define ('RA__DEBUG', true);
if (defined ('RA__DEBUG'))
{
	error_reporting (E_ALL | E_STRICT);
}

/**#@+
 *
 * @ignore
 */
// error codes
define ('RA__NO_ERROR',						0x00);
define ('RA__FILE_NOT_SPECIFIED',			0x01);
define ('RA__FORMAT_NOT_SUPPORTED',			0x02);
define ('RA__UNABLE_TO_OPEN_ZIP_ARCHIVE',	0x03);
define ('RA__ZIP_ARCHIVE_EMPTY',			0x04);
define ('RA__OLD_FORMAT_VER',				0x05);
define ('RA__EMPTY_HEADER_STREAM',			0x06);
define ('RA__ERROR_IN_UNCOMPRESSED_STREAM',	0x07);
define ('RA__RAR_EXTENSION_NOT_INSTALLED',	0x08);
define ('RA__RAR_NOT_IMPLEMENTED',			0x09);
define ('RA__MORE_FILES_PER_ARCHIVE',		0x0A);
define ('RA__NO_RECGAME_FOUND',				0x0B);
define ('RA__ERROR_IN_HEADER_STREAM',		0x0C);

require_once ('recAnalyst.config.php');
require_once ('recAnalyst.consts.php');
require_once ('gameSettings.class.php');
require_once ('player.class.php');
require_once ('parentList.class.php');
require_once ('playerList.class.php');
require_once ('team.class.php');
require_once ('teamList.class.php');
/**#@-*/

/**
 * RecAnalyst class
 *
 * RecAnalyst implements analyzing of recorded games.
 *
 * @package recAnalyst
 */
class RecAnalyst
{
	const mgxExt = '.mgx';
	const rarExt = '.rar';
	const zipExt = '.zip';

	/**
	 * Internal storage for new members.
	 *
	 * @var array
	 */
	private $data;

	/**
	 * Input filename we wish to analyze.
	 *
	 * @var string
	 */
	public $fileName;

	/**
	 * Internal stream containing header information.
	 *
	 * @var string
	 */
	private $headerStream;

	/**
	 * Internal stream containing body information.
	 *
	 * @var string
	 */
	private $bodyStream;

	/**
	 * Holds a code of the recent error.
	 *
	 * @var int
	 */
	private $lastError;

	/**
	 * An array containing map data.
	 *
	 * $var array
	 */
	private $mapData;

	/**
	 * Map width.
	 *
	 * @var int
	 */
	private $mapWidth;

	/**
	 * Map height.
	 *
	 * @var int
	 */
	private $mapHeight;

	/**
	 * Game settings information.
	 *
	 * @var GameSettings
	 */
	public $gameSettings;

	/**
	 * List of players in the game.
	 *
	 * @var PlayerList
	 */
	public $playerList;

	/**
	 * List of teams in the game.
	 *
	 * @var TeamList
	 */
	public $teams;

	/**
	 * An array containing pre-game chat.
	 *
	 * @var array
	 */
	public $pregameChat;

	/**
	 * An array containing in-game chat.
	 *
	 * @var array
	 */
	public $ingameChat;

	/**
	 * An associative array containing "unit_type_id - unit_num" pairs.
	 *
	 * @var array
	 */
	public $units;

	/**
	 * An associative multi-dimesional array containing "building_type_id - building_num" pairs for each player.
	 *
	 * @var array
	 */
	public $buildings;

	/**
	 * An associative multi-dimesional array containing information about tributing.
	 *
	 * @var array
	 */
	public $tributing;

	/**
	 * Constructor.
	 *
	 */
	public function __construct ()
	{
		$this->data = array ();
		$this->fileName = '';
		$this->headerStream = '';
		$this->bodyStream = '';
		$this->lastError = RA__NO_ERROR;
		$this->gameSettings = new GameSettings ();
		$this->playerList = new PlayerList ();
		$this->teams = new TeamList ();
		$this->pregameChat = array ();
		$this->ingameChat = array ();
		$this->units = array ();
		$this->buildings = array ();
		$this->mapData = array ();
		$this->mapWidth = $this->mapHeight = 0;
		$this->tributing = array ();
	}

	/**
	 * Destructor.
	 *
	 */
	public function __destruct ()
	{
	}

	/**
	 * Callback method for setting a property.
	 *
	 * @param mixed $nm
	 * @param mixed $val
	 */
	public function __set ($nm, $val)
	{
		$this->data[$nm] = $val;
	}

	/**
	 * Callback method for getting a property.
	 *
	 * @param mixed $nm
	 */
	public function __get ($nm)
	{
		return $this->data[$nm];
	}

	/**
	 * Returns code of the recent error.
	 *
	 * @return int
	 */
	public function getLastError ()
	{
		return $this->lastError;
	}

	/**
 	* Represents the error code as a string information.
 	*
 	* @param int $errCode error code
 	* @static
 	* @return string error string
 	*/
	public static function errorCodeToString ($errCode)
	{
		switch ($errCode)
		{
			case RA__NO_ERROR:
				$errString = 'No error occured.';
				break;
			case RA__FILE_NOT_SPECIFIED:
				$errString = 'No file has been specified for analyzing.';
				break;
			case RA__FORMAT_NOT_SUPPORTED:
				$errString = 'File format is not supported.';
				break;
			case RA__UNABLE_TO_OPEN_ZIP_ARCHIVE:
				$errString = 'Unable to open zip archive.';
				break;
			case RA__ZIP_ARCHIVE_EMPTY:
				$errString = 'Empty zip archive.';
				break;
			case RA__MORE_FILES_PER_ARCHIVE:
				$errString = 'Only one file per archive is supported for analyzing.';
				break;
			case RA__OLD_FORMAT_VER:
				$errString = 'Old mgx file format.';
				break;
			case RA__EMPTY_HEADER_STREAM:
				$errString = 'Empty header stream.';
				break;
			case RA__ERROR_IN_UNCOMPRESSED_STREAM:
				$errString = 'Error in uncompressed stream.';
				break;
			case RA__RAR_EXTENSION_NOT_INSTALLED:
				$errString = 'Rar extension is not installed on server.';
				break;
			case RA__RAR_NOT_IMPLEMENTED:
				$errString = 'Support for rar archives is not implemented.';
				break;
			case RA__NO_RECGAME_FOUND:
				$errString = 'No recorded game has been found in archive.';
				break;
			case RA__ERROR_IN_HEADER_STREAM:
				$errString = 'Error in header stream.';
				break;
			default:
				$errString = '';
				break;
		}
		return ($errString);
	}

	/**
 	* Converts game's time to string representation.
 	*
 	* @param int $time game time
 	* @param string $format desired string format
 	* @static
 	* @return string time in formatted string
 	*/
	public static function gameTimeToString ($time, $format = '%02d:%02d:%02d')
	{
		if ($time == 0)
			return '-';

		$hour   =  (int)($time / 1000 / 3600);
		$minute = ((int)($time / 1000 / 60)) % 60;
		$second = ((int)($time / 1000)) % 60;

		return sprintf ($format, $hour, $minute, $second);
	}

	/**
	 * Extracts header and body streams from an archive.
	 *
	 * @return bool
	 */
	private function extractStreamsFromArchive ()
	{
		if (!$this->fileName)
		{
			$this->lastError = RA__FILE_NOT_SPECIFIED;
			return false;
		}

		$ext = strrchr ($this->fileName, '.');
		if (strcasecmp ($ext, self::rarExt) != 0 && strcasecmp ($ext, self::zipExt) != 0)
		{
			$this->lastError = RA__FORMAT_NOT_SUPPORTED;
			return false;
		}

		if (strcasecmp ($ext, self::rarExt) == 0)
		{
			if (!function_exists ('rar_open'))
			{
				$this->lastError = RA__RAR_EXTENSION_NOT_INSTALLED;
				return false;
			}
			// stub
			$this->lastError = RA__RAR_NOT_IMPLEMENTED;
			return false;
		}

		if (strcasecmp ($ext, self::zipExt) == 0)
		{
			$zip = new ZipArchive ();

			if ($zip->open ($this->fileName) !== true)
			{
				$this->lastError = RA__UNABLE_TO_OPEN_ZIP_ARCHIVE;
				return false;
			}

			if ($zip->numFiles == 0)
			{
				$zip->close ();
				$this->lastError = RA__ZIP_ARCHIVE_EMPTY;
				return false;
			}

			if ($zip->numFiles != 1)
			{
				$zip->close ();
				$this->lastError = RA__MORE_FILES_PER_ARCHIVE;
				return false;
			}

			$mgx_found = false;

			for ($i = 0; false !== ($stat = $zip->statIndex ($i)); $i++)
			{
				// skip directories and 0-bytes files
				if (!$stat['size'])
				{
					continue;
				}

				// skip non-mgx files
				$ext = strrchr ($stat['name'], '.');
				if (strcasecmp ($ext, self::mgxExt) != 0)
				{
					continue;
				}

				// get a file handler to the entry
				if (!($fp = $zip->getStream ($stat['name'])))
				{
					continue;
				}

				$mgx_found = true;

				// read data
				$packed_data = fread ($fp, 4);

				if ($packed_data === false || strlen ($packed_data) < 4)
				{
					$zip->close ();
					$this->lastError = RA__ERROR_IN_HEADER_STREAM;
					return false;
				}

				$unpacked_data = unpack ("V", $packed_data);
				$header_len = $unpacked_data[1];

				if ($header_len == 0)
				{
					$zip->close ();
					$this->lastError = RA__OLD_FORMAT_VER;
					return false;
				}

				// skip next_pos
				$packed_data = fread ($fp, 4);
				$header_len -= 8;

				// TODO: getMemoryLimit ()
				if ($header_len > 1048576) // 1MB
				{
					$zip->close ();
					$this->lastError = RA__ERROR_IN_HEADER_STREAM;
					return false;
				}

				$read = 0;
				while ($read < $header_len && ($buff = fread ($fp, $header_len - $read)))
				{
					$read += strlen ($buff);
					$this->headerStream .= $buff;
				}

				$read = 0;
				while (!feof ($fp))
				{
					$buff = fread ($fp, 1024 * 8);
					$this->bodyStream .= $buff;
				}

				unset ($buff);
				fclose ($fp);
				$zip->close ();

				return true;
			} // endfor

			$zip->close ();

			if (!$mgx_found)
			{
				$this->lastError = RA__NO_RECGAME_FOUND;
				return false;
			}
		} // end zip uncompression
	}

	/**
	 * Uncompresses header stream.
	 *
	 * @return string|bool uncompressed stream or false if an error occured
	 */
	private function uncompressHeaderStream ()
	{
		if (!$this->headerStream)
		{
			$this->lastError = RA__EMPTY_HEADER_STREAM;
			return false;
		}

		//TODO: getMemoryLimit ()
		$this->headerStream = @gzinflate ($this->headerStream, 4194304); // 4MB

		if (!$this->headerStream)
		{
			$this->lastError = RA__ERROR_IN_HEADER_STREAM;
			return false;
		}

		return true;
	}

	/**
	 * Analyzes header stream.
	 *
	 * @return bool true if analyzed successfully, otherwise false
	 */
	private function analyzeHeaderStream ()
	{
		global $RA__MAPS;
		global $RA__GAME_STYLES;
		global $RA__DIFFICULTY_LEVELS;
		global $RA__GAME_TYPES;
		global $RA__GAME_SPEEDS;
		global $RA__CIVS;

		// initialize variables
		$constant2      = pack ('c*', 0x9A, 0x99, 0x99, 0x99, 0x99, 0x99, 0xF9, 0x3F);
		$separator      = pack ('c*', 0x9D, 0xFF, 0xFF, 0xFF);
		$unknown_const2 = pack ('c*', 0x98, 0x9E, 0x00, 0x00, 0x02, 0x0B);
		$trigger_info_pos = $game_setting_pos = 0;

		$string_id = pack ('c*', 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF,
								 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF,
								 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF,
								 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF,
								 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF,
								 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF,
								 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF,
								 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF);

		$pos = 0;
		$m_header_len = strlen ($this->headerStream);

		$len = strlen ($constant2);
		$pos = ($m_header_len - $len);

		$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
		// TODO: use substr_compare
		while ($pos > 0)
		{
			if (strcmp ($buff, $constant2) == 0)
			{
				$trigger_info_pos = $pos;
				break;
			}
			$pos -= $len + 1;
			$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
		}

		if ($trigger_info_pos == 0)
		{
			$this->lastError = RA__ERROR_IN_UNCOMPRESSED_STREAM;
			return false;
		}

		// getting Game_settings position
		$len = strlen ($separator);
		$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
		while ($pos > 0)
		{
			if (strcmp ($buff, $separator) == 0)
			{
				$game_setting_pos = $pos;
				break;
			}

			$pos -= $len + 1;
			$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
		}

		if ($game_setting_pos == 0)
		{
			// not found
			$this->lastError = RA__ERROR_IN_UNCOMPRESSED_STREAM;
			return false;
		}

/***************************************************************************************
note:	Victory & Achievement data not found as described in mgx format description
obtaining Achievement data should be called after knowing num_player as it is required

		// getting Victory position, first is Disables
		$pos -= 8;
		$victory_pos = 0;
		$separator_first_pos = 0;
		$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
		while ($pos > 0)
		{
			if (strcmp ($buff, $separator) == 0)
			break;
			$pos -= $len + 1;
			$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
		}
		if ($pos != 0)
		{
			$pos -= 8;
			$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
			while ($pos > 0)
			{
				if (strcmp ($buff, $separator) == 0)
				{
					$victory_pos = $pos;
					break;
				}
				$pos -= $len + 1;
				$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
			}
		}
		if ($victory_pos != 0)
		{
			$pos -= 8;
			$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
			while ($pos > 0)
			{
				if (strcmp ($buff, $separator) == 0)
				{
					$separator_first_pos = $pos;
				break;
				}
				$pos -= $len + 1;
				$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
			}

			$pos = $victory_pos;

			// here should be victory condition, but isn't
			$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
			$unpacked_data = unpack ("V", $packed_data);
			$conquest = $unpacked_data[1];
			if (conquest == 0)
			{
				$this->gameSettings->victory = 'custom';
				$pos += 4;

				$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
				$unpacked_data = unpack ("V", $packed_data);
				$relics = $unpacked_data[1];
				$pos += 4;
				$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
				$unpacked_data = unpack ("V", $packed_data);
				$explored = $unpacked_data[1];
				$pos += 4;
				$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
				$unpacked_data = unpack ("V", $packed_data);
				$all = $unpacked_data[1];
				$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
				$unpacked_data = unpack ("V", $packed_data);
				$mode = $unpacked_data[1];
				$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
				$unpacked_data = unpack ("V", $packed_data);
				$score = $unpacked_data[1];
				$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
				$unpacked_data = unpack ("V", $packed_data);
				$time = $unpacked_data[1];

				if ($relics != 0)
				{
					$this->gameSettings->victory = sprintf ('Gain %d relics', $relics);
				}
				elseif ($explored != 0)
				{
					$this->gameSettings->victory = sprintf ('Percentage of explored map: %d', $explored);
				}
				else
				{
					switch ($mode)
					{
						case 0:
							$this->gameSettings->victory = 'Normal';
							break;
						case 1:
							$this->gameSettings->victory = 'Conquest';
							break;
						case 2:
							$this->gameSettings->victory = sprintf ('Score Limit: %d', $score);
							break;
						case 3:
							$this->gameSettings->victory = sprintf ('Time Limit: %d', $time);
							break;
					}
				}

			}
			elseif ($condition == 1)
			{
				$this->gameSettings->victory = 'Conquest';
			}
		}
		if ($separator_first_pos != 0)
		{
			$string_id_pos = 0;
			$len = strlen ($string_id);
			$pos = $separator_first_pos - $len;
			$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
			while ($pos > 0)
			{
				if (strcmp ($buff, $string_id) == 0)
				{
					$string_id_pos = $pos;
					break;
				}
				$pos -= $len + 1;
				$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
			}
			if ($string_id_pos != 0)
			{
				$pos = $string_id_pos - $len;
				$pos -= 4096;
				$pos -= 4;
				$pos -= 4;

				// num_player is not known till now, need to be called after obtaining it
				$pos -= 1473 * $num_player;
				// here should start Achievement, but doesn't :-(
				$pos += 13;
				$packed_data = substr ($this->headerStream, $pos, 4);
				$unpacked_data = unpack ("V", $packed_data);
				$total_point = $unpacked_data[1];
				//...
			}
		}
***************************************************************************************/

		// getting Game_Settings data
		// skip negative[2]
		$pos = $game_setting_pos + 8;

		$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
		$unpacked_data = unpack ("V", $packed_data);
		$map_id = $unpacked_data[1];

		$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
		$unpacked_data = unpack ("V", $packed_data);
		$difficulty = $unpacked_data[1];
		// skip unknown
		$pos += 4;

		if (array_key_exists ($map_id, $RA__MAPS))
		{
			$this->gameSettings->map = $RA__MAPS[$map_id][0];
			$this->gameSettings->gameStyle = $RA__GAME_STYLES[0];
		}
		else
		{
			$this->gameSettings->gameStyle = $RA__GAME_STYLES[2];
		}

		if (array_key_exists ($difficulty, $RA__DIFFICULTY_LEVELS))
		{
			$this->gameSettings->difficultyLevel = $RA__DIFFICULTY_LEVELS[$difficulty];
		}

		// getting Player_info data
		for ($i = 0; $i <= 8; $i++)
		{
			$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
			$unpacked_data = unpack ("V", $packed_data);
			$player_data_index = $unpacked_data[1];

			$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
			$unpacked_data = unpack ("V", $packed_data);
			$human = $unpacked_data[1];

			$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
			$unpacked_data = unpack ("V", $packed_data);
			$name_len = $unpacked_data[1];

			$playername = substr ($this->headerStream, $pos, $name_len); $pos += $name_len;

			// 0x00:invalid player, 0x02:human, 0x04:computer
			// index 0 is GAIA player
			if ($human == 0x00)
				continue;
			// sometimes very rarely index is 1
			if ($human == 0x01)
				continue;
			if ($human != 0x00 && $i != 0)
			{
				$player = new Player ();
				$player->name  = $playername;
				$player->index = $player_data_index;
				$player->human = ($human == 0x02);

				$this->playerList->addPlayer ($player);
			}
		} // endfor

		// Trigger_info
		$pos = $trigger_info_pos + 1;

		$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
		$unpacked_data = unpack ("V", $packed_data);
		$num_trigger = $unpacked_data[1];

		if ($num_trigger == 0)
		{
			$this->gameSettings->isScenario = false;

			// Other_data
			for ($i = 0; $i <= 7; $i++)
			{
				$packed_data = substr ($this->headerStream, $pos, 1); $pos += 1;
				$unpacked_data = unpack ("C", $packed_data);
				$team = $unpacked_data[1];

				if (($i + 1) <= $this->playerList->getCount ())
				{
					if ($player = $this->playerList->getPlayer ($i))
					{
						$player->team = $team - 1;
					}
				}
			}

			// skip unknown[13]
			$pos += 13;

			$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
			$unpacked_data = unpack ("V", $packed_data);
			$pop_limit = $unpacked_data[1];

			$packed_data = substr ($this->headerStream, $pos, 1); $pos += 1;
			$unpacked_data = unpack ("C", $packed_data);
			$game_type = $unpacked_data[1];

			$packed_data = substr ($this->headerStream, $pos, 1); $pos += 1;
			$unpacked_data = unpack ("C", $packed_data);
			$lock_diplomacy = $unpacked_data[1];

			$this->gameSettings->popLimit = $pop_limit;
			$this->gameSettings->gameType = $RA__GAME_TYPES[$game_type];
			$this->gameSettings->lockDiplomacy = ($lock_diplomacy == 0x01);

			// here comes pre-game chat
			$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
			$unpacked_data = unpack ("V", $packed_data);
			$num_chat = $unpacked_data[1];
			for ($i = 0; $i < $num_chat; $i++)
			{
				$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
				$unpacked_data = unpack ("V", $packed_data);
				$chat_len = $unpacked_data[1];

				// 0-length chat exists
				if ($chat_len == 0)
				{
					continue;
				}

				$chat = substr ($this->headerStream, $pos, $chat_len); $pos += $chat_len;

				if ($chat[0] == '@' && $chat[1] == '#' && $chat[2] >= '1' && $chat[2] <= '8')
				{
					$chat = rtrim ($chat); // throw null-termination character
					$this->pregameChat[] = $chat;
				}
			}
			unset ($chat);
		}
		else
		{
			$this->gameSettings->isScenario = true;
			$this->gameSettings->map = '';
			$this->gameSettings->gameType = $RA__GAME_TYPES[3];
			$this->gameSettings->gameStyle = $RA__GAME_STYLES[2];
		}

		// skip AI_info if exists
		$pos = 0x0C;
		$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
		$unpacked_data = unpack ("V", $packed_data);
		$include_ai = $unpacked_data[1];

		if ($include_ai == 0x01)
		{
			$pos += 2;
			$packed_data = substr ($this->headerStream, $pos, 2); $pos += 2;
			$unpacked_data = unpack ("v", $packed_data);
			$num_string = $unpacked_data[1];
			$pos += 4;
			for ($i = 0; $i < $num_string; $i++)
			{
				$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
				$unpacked_data = unpack ("V", $packed_data);
				$string_length = $unpacked_data[1];
				$pos += $string_length;
			}
			$pos += 6;
			// AI_data
			for ($i = 0; $i < 8; $i++)
			{
				$pos += 10;
				$packed_data = substr ($this->headerStream, $pos, 2); $pos += 2;
				$unpacked_data = unpack ("v", $packed_data);
				$num_rule = $unpacked_data[1];
				$pos += 4;
				$pos = $pos + (400 * $num_rule);
			}
			$pos += 5544;
		}

		// getting data
		$pos += 4;
		$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
		$unpacked_data = unpack ("V", $packed_data);
		$game_speed = $unpacked_data[1];

		$pos += 37;
		$packed_data = substr ($this->headerStream, $pos, 2); $pos += 2;
		$unpacked_data = unpack ("v", $packed_data);
		$rec_player_ref = $unpacked_data[1];

		$packed_data = substr ($this->headerStream, $pos, 1); $pos += 1;
		$unpacked_data = unpack ("C", $packed_data);
		$num_player = $unpacked_data[1];

		$rec_player_ref--;  // 0 is GAIA, not appears in playerList
		$num_player--;
		$this->gameSettings->speed = $RA__GAME_SPEEDS[$game_speed];
		if ($player = $this->playerList->getPlayer ($rec_player_ref))
		{
			$player->owner = true;
		}

		if ($num_player < $this->playerList->getCount ())
		{
			$this->gameSettings->inGameCoop = true;
		}

		// getting map
		$pos += 62;
		$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
		$unpacked_data = unpack ("V", $packed_data);
		$map_size_x = $unpacked_data[1];
		$this->mapWidth = $map_size_x;

		$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
		$unpacked_data = unpack ("V", $packed_data);
		$map_size_y = $unpacked_data[1];
		$this->mapHeight = $map_size_y;

		$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
		$unpacked_data = unpack ("V", $packed_data);
		$num_unknown_data = $unpacked_data[1];
		// unknown data
		for ($i = 0; $i < $num_unknown_data; $i++)
		{
			$pos += 1275;
			$pos += $map_size_x * $map_size_y;

			$packed_data = substr ($this->headerStream, $pos, 4); $pos += 4;
			$unpacked_data = unpack ("V", $packed_data);
			$num_float = $unpacked_data[1];
			/*
			 if (num_float != 0x29)
			 {
				// error = 1
				break;
				}
			*/
			$pos += 4 * $num_float;
			$pos += 4;
		}
		$pos += 2;

		// map data
		// if error == 0 { do following + set flag map_loaded }
		$x = $y = 1;
		for ($i = 0; $i < $map_size_x * $map_size_y; $i++)
		{
			// terrain_id
			$packed_data = substr ($this->headerStream, $pos, 1); $pos += 1;
			$unpacked_data = unpack ("C", $packed_data);
			$terrain_id = $unpacked_data[1];
			// elevation
			$packed_data = substr ($this->headerStream, $pos, 1); $pos += 1;
			$unpacked_data = unpack ("C", $packed_data);
			$elevation = $unpacked_data[1];
			if ($x == $map_size_x + 1)
			{
				$x = 1;
				$y++;
			}
			$this->mapData[$x][$y][0] = $terrain_id;
			// TODO: elevation
			// we do not get elevation (memory exhaustive)
			// $this->mapData[$x][$y][1] = $elevation;
			$x++;
		}

		$pos += 128;
		$pos += $map_size_x * $map_size_y * 4;
		$pos += 15;
		/*
		// TODO: test for behavior if there is a Computer
		// getting Player_info position
		$len = strlen ($unknown_const2);
		$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
		while ($pos <= ($m_header_len - $len))
		{
			if (strcmp ($buff, $unknown_const2) == 0)
			{
				break;
			}
			$pos -= $len - 1;
			$buff = substr ($this->headerStream, $pos, $len); $pos += $len;
		}
		*/
		$pos += 5138;

		foreach ($this->playerList as $player)
		{
			// skip cooping player, he/she has no data in Player_info
			$player_ = $this->playerList->getPlayerByIndex ($player->index);

			if ($player_ && ($player_ !== $player) && $player_->civId)
			{
				$player->civId = $player_->civId;
				$player->civ = $player_->civ;
				$player->colorId = $player_->colorId;
				$player->isCooping = true;
				continue;
			}
			$playerName = $player->name;

			while ($pos <= ($m_header_len - strlen ($playerName)))
			{
				$buff = substr ($this->headerStream, $pos, strlen ($playerName));

				if (strcmp ($buff, $playerName) == 0)
				{
					break;
				}
				$pos++;
			}
			$pos += strlen ($playerName);

			// skip data (first byte is null char player's name terminator)
			$pos += 817;
			// civilization
			$packed_data = substr ($this->headerStream, $pos, 1); $pos += 1;
			$unpacked_data = unpack ("C", $packed_data);
			$civilization = $unpacked_data[1];

			$player->civId = $civilization;
			$player->civ = $RA__CIVS[$civilization][0];

			// skip unknown9[3]
			$pos += 3;
			// player_color
			$packed_data = substr ($this->headerStream, $pos, 1); $pos += 1;
			$unpacked_data = unpack ("C", $packed_data);
			$player_color = $unpacked_data[1];

			$player->colorId = $player_color;

			$pos += 4299;
		} // endfor

		// initialize variables
		$con1 = pack ('c*', 0x3A, 0x20);
		$con2 = pack ('c*', 0xA1, 0x47);

		$LANGUAGES = array (
			'en'  => pack ('c*', 0x4D, 0x61, 0x70, 0x20, 0x54, 0x79, 0x70, 0x65),
			'cz'  => pack ('c*', 0x54, 0x79, 0x70, 0x20, 0x6D, 0x61, 0x70, 0x79),
			'jp'  => pack ('c*', 0x83, 0x7D, 0x83, 0x62, 0x83, 0x76, 0x82, 0xCC, 0x8E, 0xED, 0x97, 0xDE),
			'cn'  => pack ('c*', 0xB5, 0xD8, 0xCD, 0xBC, 0xC0, 0xE0, 0xD0, 0xCD),
			'sp'  => pack ('c*', 0x54, 0x69, 0x70, 0x6F, 0x20, 0x64, 0x65, 0x20, 0x6D, 0x61, 0x70, 0x61),
			'de'  => pack ('c*', 0x4B, 0x61, 0x72, 0x74, 0x65, 0x6E, 0x74, 0x79, 0x70),
			'cn2' => pack ('c*', 0xA6, 0x61, 0xB9, 0xCF, 0xC3, 0xFE, 0xA7, 0x4F),
			'kr'  => pack ('c*', 0xC7, 0xA5, 0xC1, 0xD8, 0x0A, 0xC0, 0xDA, 0xBF, 0xF8),
			'fr'  => pack ('c*', 0x54, 0x79, 0x70, 0x65, 0x20, 0x64, 0x65, 0x20, 0x63, 0x61, 0x72, 0x74, 0x65, 0xA0),
			'it'  => pack ('c*', 0x54, 0x69, 0x70, 0x6F, 0x20, 0x64, 0x69, 0x20, 0x6D, 0x61, 0x70, 0x70, 0x61),
			'sp2' => pack ('c*', 0x54, 0x69, 0x70, 0x6F, 0x20, 0x64, 0x65, 0x20, 0x4D, 0x61, 0x70, 0x61),
			'ur'  => pack ('c*', 0xD2, 0xE8, 0xEF, 0x20, 0xCA, 0xE0, 0xF0, 0xF2, 0xFB));

		// getting map name (only if map is custom (44) and game type is not scenario (game_type still $00 in scenarios)
		// if map_id = 32 (Random Land Map), it is possible to obtain map if it's written in english
		if (!array_key_exists ($map_id, $RA__MAPS) && $game_type != 0x03 && !$this->gameSettings->isScenario)
		{
			$pos = $game_setting_pos - 11520;

			$mapFound = false;

			$buff = substr ($this->headerStream, $pos, 2); $pos += 2;
			// searching up to -100000 bytes, than stop
			while ($pos > $game_setting_pos - 11520 - 100000 && !$mapFound)
			{
				if (strcmp ($buff, $con1) == 0 || strcmp ($buff, $con2) == 0)
				{
					$pos -= 2;

					foreach ($LANGUAGES as $val)
					{
						$pos -= strlen ($val);
						$map_name = substr ($this->headerStream, $pos, strlen ($val)); $pos += strlen ($val);

						if (strcmp ($map_name, $val) == 0)
						{
							$mapName = '';
							$pos += 2; // skip ': '

							for ($i = 0; $i < 100; $i++)
							{
								$buff = substr ($this->headerStream, $pos, 1); $pos += 1;

								if ($buff != chr (0x0A))
								{
									$mapName .= $buff;
								}
								else
								{
									$mapFound = true;
									break;
								}
							} // endfor
							break;
						} // endif
					} // end foreach
				} // endif

				$pos -= 3;
				$buff = substr ($this->headerStream, $pos, 2); $pos += 2;
			} // endwhile

			$this->gameSettings->map = ($mapFound) ? $mapName : $RA__GAME_STYLES[2];
		} // endif

		// build teams
		foreach ($this->playerList as $player)
		{
			if ($player->team == 0)
			{
				$found = false;
				foreach ($this->teams as $team)
				{
					if ($team->getIndex () != $player->team)
					{
						continue;
					}
					foreach ($team as $player_)
					{
						if ($player_->index == $player->index)
						{
							$team->addPlayer ($player);
							$found = true;
							break;
						}
					}
					if ($found)
					{
						break;
					}
				}
				if (!$found)
				{
					$team = new Team ();
					$team->addPlayer ($player);
					$this->teams->addTeam ($team);
				}
			}
			else
			{
				if ($team = $this->teams->getTeamByIndex ($player->team))
				{
					$team->addPlayer ($player);
				}
				else
				{
					$team = new Team ();
					$team ->addPlayer ($player);
					$this->teams->addTeam ($team);
				}
			}
		}

		return true;
	}

	/**
	 * Analyzes body stream.
	 *
	 * @return bool true if successfully analyzed, otherwise false
	 */
	private function analyzeBodyStream ()
	{
		global $RA__REVEAL_SETTINGS;

		$time_cnt = $pos = $tributing_cnt = 0;
		$m_body_len = strlen ($this->bodyStream);
		$age_flag = array (0, 0, 0, 0, 0, 0, 0, 0);

		if (defined ('RA__DEBUG'))
		{
			global $RA__RESOURCES;
		}

		while ($pos < $m_body_len - 3)
		{
			$packed_data = substr ($this->bodyStream, $pos, 4); $pos += 4;
			$unpacked_data = unpack ("V", $packed_data);
			$type = $unpacked_data[1];
			if (defined ('RA__DEBUG'))
			{
				printf (nl2br ("type: %d\n"), $type);
			}

			// ope_data types: 4(Game_start or Chat), 2(Sync), or 1(Command)
			switch ($type)
			{
				// Game_start or Chat command
				case 4:
					$packed_data = substr ($this->bodyStream, $pos, 4); $pos += 4;
					$unpacked_data = unpack ("V", $packed_data);
					$command = $unpacked_data[1];
					if ($command == 0x01F4)
					{
						// skip unknown
						$pos+=8;

						// 'Map Reveal' data
						$packed_data = substr ($this->bodyStream, $pos, 4); $pos+=4;
						$unpacked_data = unpack ("V", $packed_data);
						$reveal_map = $unpacked_data[1];

						$this->gameSettings->revealMap = $RA__REVEAL_SETTINGS[$reveal_map];

						// skip unknown
						$pos+=8;
					}
					elseif ($command == -1)
					{
						// Chat
						$packed_data = substr ($this->bodyStream, $pos, 4); $pos += 4;
						$unpacked_data = unpack ("V", $packed_data);
						$chat_len = $unpacked_data[1];

						for ($i = 0; $i < $this->playerList->getCount (); $i++)
						{
							if (!($player = $this->playerList->getPlayer ($i)))
							{
								continue;
							}

							if ($player->feudalTime != 0 && $player->feudalTime < $time_cnt && $age_flag[$i] == 0)
							{
								$this->ingameChat[] = sprintf ('%d@#0%s advanced to Feudal Age', $player->feudalTime, $player->name);
								$age_flag[$i] = 1;
							}
							if ($player->castleTime != 0 && $player->castleTime < $time_cnt && $age_flag[$i] == 0)
							{
								$this->ingameChat[] = sprintf ('%d@#0%s advanced to Castle Age', $player->castleTime, $player->name);
								$age_flag[$i] = 1;
							}
							if ($player->imperialTime != 0 && $player->imperialTime < $time_cnt && $age_flag[$i] == 0)
							{
								$this->ingameChat[] = sprintf ('%d@#0%s advanced to Imperial Age', $player->imperialTime, $player->name);
								$age_flag[$i] = 1;
							}
						}

						$chat = substr ($this->bodyStream, $pos, $chat_len); $pos += $chat_len;

						if ($chat[0] == '@' && $chat[1] == '#' && $chat[2] >= '1' && $chat[2] <= '8')
						{
							$chat = rtrim ($chat); // throw null-termination character
							if (substr ($chat, 3, 2) == '--' && substr ($chat, -2) == '--')
							{
							}
							else
							{
								$this->ingameChat[] = sprintf ('%d%s', $time_cnt, $chat);
							}
						}
					}
					break;
				// Sync
				case 2:
					$packed_data = substr ($this->bodyStream, $pos, 4); $pos += 4;
					$unpacked_data = unpack ("V", $packed_data);
					$time_cnt += $unpacked_data[1]; // time_cnt is in miliseconds
					$packed_data = substr ($this->bodyStream, $pos, 4); $pos += 4;
					$unpacked_data = unpack ("V", $packed_data);
					$unknown = $unpacked_data[1];
					if ($unknown == 0)
					{
						$pos += 28;
					}
					$pos += 12;
					break;
				// Command
				case 1:
					$packed_data = substr ($this->bodyStream, $pos, 4); $pos += 4;
					$unpacked_data = unpack ("V", $packed_data);
					$length = $unpacked_data[1];

					$packed_data = substr ($this->bodyStream, $pos, 1);
					$unpacked_data = unpack ("C", $packed_data);
					$command = $unpacked_data[1];

					if (defined ('RA__DEBUG'))
					{
						$packed_data = substr ($this->bodyStream, $pos, 2);
						$unpacked_data = unpack ("v", $packed_data);
						$cmd = $unpacked_data[1];

						$format = nl2br ("(%s): 0x%02x - 0x%02x -> len: %d\n");
						printf ($format, self::gameTimeToString ($time_cnt), $cmd, $command, $length);
					}

					if (defined ('RA__DEBUG'))
					{
						$output = '';
						for ($i = $pos + 1; $i < $pos + 1 + $length - 1; $i++)
						{
							$packed_data = substr ($this->bodyStream, $i, 1);
							$unpacked_data = unpack ("C", $packed_data);
							$c = $unpacked_data[1];
							$output .=  $c . '|';
						}
						print (nl2br ($output . "\n"));
					}

					switch ($command)
					{
						case 0x0B: // player resign
							$pos += 1;
							$packed_data = substr ($this->bodyStream, $pos, 1); $pos += 1;
							$unpacked_data = unpack ("C", $packed_data);
							$player_number = $unpacked_data[1];
							$pos += 2;
							if ($player = $this->playerList->getPlayerByIndex ($player_number))
							{
								$player->resignTime = $time_cnt;
								$this->ingameChat[] = sprintf ('%d@#0%s resigned', $player->resignTime, $player->name);

								if (defined ('RA__DEBUG'))
								{
									$format = nl2br ("(%s) resigned player #%d: %s\n");
									printf ($format, self::gameTimeToString ($time_cnt), $player_number, $player->name);
								}
							}
							$pos += $length - 4;  // different from mgx format description
							break;
						case 0x65: // researches
							$pos += 8;
							// player_id
							$packed_data = substr ($this->bodyStream, $pos, 2); $pos += 2;
							$unpacked_data = unpack ("v", $packed_data);
							$player_id = $unpacked_data[1];
							// research_id
							$packed_data = substr ($this->bodyStream, $pos, 2); $pos += 2;
							$unpacked_data = unpack ("v", $packed_data);
							$research_id = $unpacked_data[1];
							if ($research_id == 101)
							{
								// feudal time
								if ($player = $this->playerList->getPlayerByIndex ($player_id))
								{
									$player->feudalTime = $time_cnt + 130 * 1000; // + research time (2:10)
								}
							}
							if ($research_id == 102)
							{
								// castle time
								if ($player = $this->playerList->getPlayerByIndex ($player_id))
								{
									// persians?
									$player->castleTime = ($player->civId == 0x08) ? $time_cnt + 144 * 1000 : $time_cnt + 160 * 1000;
								}
							}
							if ($research_id == 103)
							{
								// imperial time
								if ($player = $this->playerList->getPlayerByIndex ($player_id))
								{
									// persians?
									$player->imperialTime = ($player->civId == 0x08) ? $time_cnt + 162 * 1000 : $time_cnt + 190 * 1000;
								}
							}
							// else
							{
								if ($player = $this->playerList->getPlayerByIndex ($player_id))
								{
									$player->researches[$research_id] = $time_cnt;
								}
							}
							if (defined ('RA__DEBUG'))
							{
								$format = nl2br ("#%d -> %d\n");
								printf ($format, $player_id, $research_id);
							}
							$pos += ($length - 12);
							break;
						case 0x77:
							/*
							$pos += 1;
							for ($i = 0; $i < $length - 1; $i++)
							{
								$packed_data = substr ($this->bodyStream, $pos, 1); $pos += 1;
								$unpacked_data = unpack ("C", $packed_data);
								$c = $unpacked_data[1];
								printf (nl2br ($c . "|\n"));
							}
							*/
							$pos += 1;
							$pos += 3;

							// object_id (building_id)
							$packed_data = substr ($this->bodyStream, $pos, 4); $pos += 4;
							$unpacked_data = unpack ("V", $packed_data);
							$object_id = $unpacked_data[1];
							// unit_type_id
							$packed_data = substr ($this->bodyStream, $pos, 2); $pos += 2;
							$unpacked_data = unpack ("v", $packed_data);
							$unit_type_id = $unpacked_data[1];
							// unit_num (num_unit)
							$packed_data = substr ($this->bodyStream, $pos, 2); $pos += 2;
							$unpacked_data = unpack ("v", $packed_data);
							$unit_num = $unpacked_data[1];

							if (!isset ($this->units[$unit_type_id]))
							{
								$this->units[$unit_type_id] = $unit_num;
							}
							else
							{
								$this->units[$unit_type_id] += $unit_num;
							}

							$pos += ($length - 12);
							break;
						case 0x66:
							$pos += 1;
							$pos += 1;
							// player_id
							$packed_data = substr ($this->bodyStream, $pos, 2); $pos += 2;
							$unpacked_data = unpack ("v", $packed_data);
							$player_id = $unpacked_data[1];
							$pos += 8;
							// building_type_id unit_type_id
							$packed_data = substr ($this->bodyStream, $pos, 2); $pos += 2;
							$unpacked_data = unpack ("v", $packed_data);
							$building_type_id = $unpacked_data[1];

							if (!isset ($this->buildings[$player_id][$building_type_id]))
							{
								$this->buildings[$player_id][$building_type_id] = 1;
							}
							else
							{
								$this->buildings[$player_id][$building_type_id]++;
							}

							if (defined ('RA__DEBUG'))
							{
								$format = nl2br ("%d: %d\n");
								printf ($format, $player_id, $building_type_id);
							}

							$pos += ($length - 14);
							break;
						case 0x6c: // tributing
							$pos += 1;
							// player_id_from
							$packed_data = substr ($this->bodyStream, $pos, 1); $pos += 1;
							$unpacked_data = unpack ("C", $packed_data);
							$player_id_from = $unpacked_data[1];
							// player_id_to
							$packed_data = substr ($this->bodyStream, $pos, 1); $pos += 1;
							$unpacked_data = unpack ("C", $packed_data);
							$player_id_to = $unpacked_data[1];
							// resource_id
							$packed_data = substr ($this->bodyStream, $pos, 1); $pos += 1;
							$unpacked_data = unpack ("C", $packed_data);
							$resource_id = $unpacked_data[1];
							// amount_tributed
							$packed_data = substr ($this->bodyStream, $pos, 4);// $pos += 4 Throws off commands if you change the position here
							$unpacked_data = unpack ("f", $packed_data);
							$amount_tributed = floor ($unpacked_data[1]);

							$this->tributing[$tributing_cnt++] = array (
																'from'	=>	$player_id_from,
																'to'	=>	$player_id_to,
																'rid'	=>	$resource_id,
																'amount'=>  $amount_tributed,
																'time'	=>	$time_cnt
							);

							if (defined ('RA__DEBUG'))
							{
								$format = nl2br ("(%s) %d -> %d: player %s sent %d %s to %s\n");
								$player1 = $this->playerList->getPlayerByIndex ($player_id_from);
								$player2 = $this->playerList->getPlayerByIndex ($player_id_to);
								if ($player1 && $player2)
								{
									printf ($format, self::gameTimeToString ($time_cnt), $player_id_from, $player_id_to, $player1->name, $amount_tributed, $RA__RESOURCES[$resource_id], $player2->name);
								}
							}

							$pos += $length - 4;
							break;
							/*
							case 0x6a:
							$pos += 2;

							for ($ii = 0; $ii < $length-2; $ii++)
							{
								$packed_data = substr ($this->bodyStream, $pos, 1); $pos += 1;
								$unpacked_data = unpack ("C", $packed_data);
								$c = $unpacked_data[1];
								printf (nl2br ($c . "|\n"));
							}
							break;
							*/
							/*
							case 0x64: // pc trains units
							$pos += 2;

							// player_id
							// $packed_data = substr ($this->bodyStream, $pos, 2); $pos += 2;
							// $unpacked_data = unpack ("v", $packed_data);
							// $player_id = $unpacked_data[1];
							// printf (nl2br ('pId: ' . $player_id));

							for ($ii = 0; $ii < $length-2; $ii++)
							{
								$packed_data = substr ($this->bodyStream, $pos, 1); $pos += 1;
								$unpacked_data = unpack ("C", $packed_data);
								$c = $unpacked_data[1];
								printf (nl2br ($c . "|\n"));
							}
							break;
							*/
						case 0x03:
						case 0x78:
						case 0x00:
							$pos += $length;
							break;
							/*
							case 0x75:
								$pos += 1;
								for ($ii = 0; $ii < $length-1; $ii++)
								{
									$packed_data = substr ($this->bodyStream, $pos, 1); $pos += 1;
									$unpacked_data = unpack ("C", $packed_data);
									$c = $unpacked_data[1];
									printf (nl2br ($c . "|\n"));
								}
							*/
							// $pos += $length;
							// break;
						default:
							/*
							$pos += 1;
							for ($ii = 0; $ii < $length-1; $ii++)
							{
								$packed_data = substr ($this->bodyStream, $pos, 1); $pos += 1;
								$unpacked_data = unpack ("C", $packed_data);
								$c = $unpacked_data[1];
								printf (nl2br ($c . "|\n"));
							}
							*/
							$pos += $length;
							break;
					}
					$pos +=4;
					break;
				default:
					// shouldn't occure, just to prevent unexpected endless cycling
					if (defined ('RA__DEBUG'))
					{
						printf (nl2br ("incorrect type: %d\n"), $type);
					}
					$pos += 1;
					break;
			}
		}
		$this->gameSettings->playTime = $time_cnt;

		// fix: player could click age advance, but game finished before reaching specific age
		foreach ($this->playerList as $player)
		{
			if ($player->feudalTime > $this->gameSettings->playTime)
			{
				$player->feudalTime = 0;
			}

			if ($player->castleTime > $this->gameSettings->playTime)
			{
				$player->castleTime = 0;
			}

			if ($player->imperialTime > $this->gameSettings->playTime)
			{
				$player->imperialTime = 0;
			}
		}

		if (!empty ($this->ingameChat))
		{
			sort ($this->ingameChat, SORT_NUMERIC);
		}

		if (!empty ($this->buildings))
		{
			ksort ($this->buildings);
		}

		return true;
	}

	/**
	 * Analyzes recorded game.
	 *
	 * @return bool true if successfully analyzed, otherwise false
	 */
	public function analyze ()
	{
		if (!$this->extractStreamsFromArchive ())
			return false;

		if (!$this->uncompressHeaderStream ())
			return false;

		if (!$this->analyzeHeaderStream ())
		{
			unset ($this->headerStream);
			return false;
		}

		unset ($this->headerStream);

		if (!$this->analyzeBodyStream ())
		{
			unset ($this->bodyStream);
			return false;
		}

		unset ($this->bodyStream);

		return true;
	}

	/**
	 * Generates a map image.
	 *
	 * Note: We can generate map only once, after that map data will be discarded to save memory.
	 *
	 * @param string $mapFileName map filename
	 * @return bool true if the map is successfully generated, otherwise false
	 */
	public function generateMap ($mapFileName)
	{
		if (!isset ($this->mapData))
			return false;

		//TODO: check width, height
		if (!($gd = imagecreatetruecolor ($this->mapWidth, $this->mapHeight)))
		{
			unset ($this->mapData);
			unset ($this->mapWidth);
			unset ($this->mapHeight);
			// we do not need them anymore
			return false;
		}

		for ($x = 1; $x <= $this->mapWidth; $x++)
		{
			for ($y = 1; $y <= $this->mapHeight; $y++)
			{
				switch ($this->mapData[$x][$y][0])
				{
					case 0: // grass
						$c = imagecolorallocate ($gd, 0x33, 0x97, 0x27);
						break;
					case 1: // water
						$c = imagecolorallocate ($gd, 0x30, 0x5d, 0xb6);
						break;
					case 2: // beach
						$c = imagecolorallocate ($gd, 0xe8, 0xb4, 0x78);
						break;
					case 3: // dirt3
						$c = imagecolorallocate ($gd, 0xe4, 0xa2, 0x52);
						break;
					case 4: // shallow
						$c = imagecolorallocate ($gd, 0x54, 0x92, 0xb0);
						break;
					case 5: // leaves
						$c = imagecolorallocate ($gd, 0x33, 0x97, 0x27);
						break;
					case 6: // dirt
						$c = imagecolorallocate ($gd, 0xe4, 0xa2, 0x52);
						break;
					case 9: // grass3
						$c = imagecolorallocate ($gd, 0x33, 0x97, 0x27);
						break;
					case 10: // forest
						$c = imagecolorallocate ($gd, 0x15, 0x76, 0x15);
						break;
					case 11: // dirt2
						$c = imagecolorallocate ($gd, 0xe4, 0xa2, 0x52);
						break;
					case 12: // grass2
						$c = imagecolorallocate ($gd, 0x33, 0x97, 0x27);
						break;
					case 13: // palm desert
						$c = imagecolorallocate ($gd, 0x15, 0x76, 0x15);
						break;
					case 14: // desert
						$c = imagecolorallocate ($gd, 0xe8, 0xb4, 0x78);
						break;
					case 17: // jungle
						$c = imagecolorallocate ($gd, 0x15, 0x76, 0x15);
						break;
					case 18: // bamboo
						$c = imagecolorallocate ($gd, 0x15, 0x76, 0x15);
						break;
					case 19: // pine forest
						$c = imagecolorallocate ($gd, 0x15, 0x76, 0x15);
						break;
					case 20: // oak forest (looks like grass2)
						$c = imagecolorallocate ($gd, 0x15, 0x76, 0x15);
						break;
					case 21: // snow forest (snow pine forest)
						$c = imagecolorallocate ($gd, 0x15, 0x76, 0x15);
						break;
					case 22: // deep water
						$c = imagecolorallocate ($gd, 0x00, 0x4a, 0xa1);
						break;
					case 23: // med water (water, medium)
						$c = imagecolorallocate ($gd, 0x00, 0x4a, 0xbb);
						break;
					case 24: // road
						$c = imagecolorallocate ($gd, 0xe4, 0xa2, 0x52);
						break;
					case 25: // road2 (road, broken)
						$c = imagecolorallocate ($gd, 0xe4, 0xa2, 0x52);
						break;
					case 27: // dirt2 (same as 11)
						$c = imagecolorallocate ($gd, 0xe4, 0xa2, 0x52);
						break;
					case 32: // snow
						$c = imagecolorallocate ($gd, 0x33, 0x97, 0x27);
						// $c = imagecolorallocate($gd, 0xdf, 0xea, 0xff);
						break;
					case 33: // dirt snow
						$c = imagecolorallocate ($gd, 0xe4, 0xa2, 0x52);
						// $c = imagecolorallocate($gd, 0xdf, 0xea, 0xff);
						break;
					case 34: // grass snow
						$c = imagecolorallocate ($gd, 0x33, 0x97, 0x27);
						// $c = imagecolorallocate($gd, 0xdf, 0xea, 0xff);
						break;
					case 35: // ice
						$c = imagecolorallocate ($gd, 0x98, 0xc0, 0xf0);
						break;
					case 38: // road3 (road, snow)
						$c = imagecolorallocate ($gd, 0xe4, 0xa2, 0x52);
						break;
					case 39: // road4 (road, fungus)
						$c = imagecolorallocate ($gd, 0xe4, 0xa2, 0x52);
						break;
					default:
						$c = imagecolorallocate ($gd, 0xff, 0x00, 0xff);
						break;
				}
				imagesetpixel ($gd, $x, $y, $c);
			}
		}

		unset ($this->mapData);
		unset ($this->mapWidth);
		unset ($this->mapHeight);
		// we do not need them anymore

		$degrees = 45;

		$tc = imagecolortransparent ($gd);
		imagefill ($gd, 0, 0, $tc);

		$gd = imagerotate ($gd, $degrees, -1);
		imagealphablending ($gd, true);
		imagesavealpha ($gd, true);

		$width = imagesx ($gd);
		$height = imagesy ($gd);

		if (!($mapim = imagecreatetruecolor (RA__MAP_WIDTH, RA__MAP_HEIGHT)))
		{
			imagedestroy ($gd);
			return false;
		}

		imageantialias ($mapim, true);
		imagealphablending ($mapim, false);
		imagesavealpha ($mapim, true);
		imagecopyresampled ($mapim, $gd, 0, 0, 0, 0, RA__MAP_WIDTH, RA__MAP_HEIGHT, $width, $height);
		// imagecopyresized ($t_im, $gd, 0, 0, 0, 0, 204, 102, $width, $height);

		return imagepng ($mapim, RA__MAPS_DIR . $mapFileName);
	}

	/**
	 * Generates a research timelines image.
	 *
	 * @param string $researchesFileName image filename
	 * @return bool true if the image is successfully generated, otherwise false
	 * @todo make colors for particular ages as configurable constants
	 * @todo implement use of custom fonts
	 * @todo jpg, gif output support
	 */
	public function generateResearches ($researchesFileName)
	{
		global $RA__RESEARCHES;

		// I rely on researches to be logically time-sorted, but there are recorded games,
		// where it doesn't need to be true, that's why asort() is used
		// to use a better structure to avoid using asort()?
		foreach ($this->playerList as $player)
		{
			asort ($player->researches, SORT_NUMERIC);
		}

		$total_mins = ceil ($this->gameSettings->playTime / 1000 / 60);
		// original width / height of image representing one research
		$orw = $orh = 38;
		// new width / height of image representing one research
		$rw = $rh = RA__RESEARCH_TILE_SIZE;

		// reserve in case player clicked a research, but game finished before researching a technology
		$total_mins += 5;

		// pole mins bude obsahovat maximum zo sumy vynajdenych objavov jednotliveho hraca v danej minute
		// array mins will contain max = (sum(t)_p)...
		$mins = array ();
		$mins = array_fill (0, $total_mins, 0);

		foreach ($this->playerList as $player)
		{
			$prev_min = -1;
			$tmp_mins = array_fill (0, $total_mins, 0);
			foreach ($player->researches as $research_id => $min)
			{
				if (array_key_exists ($research_id, $RA__RESEARCHES))
				{
					$min = floor ($min / 1000 / 60); // in minutes
					$tmp_mins[$min]++;
				}
			}
			foreach ($mins as $min => &$cnt)
			{
				if ($cnt < $tmp_mins[$min])
				{
					$cnt = $tmp_mins[$min];
				}
			}
		}

		// calculate max username width
		$max_username_width = 0; // max width for username
		$font = 3; // font used for usernames
		$real_cnt = 0;
		foreach ($this->playerList as $player)
		{
			if (empty ($player->researches))
			{
				continue;
			}
			if (strlen ($player->name) * imagefontwidth ($font) > $max_username_width)
			$max_username_width = strlen ($player->name) * imagefontwidth ($font);
			$real_cnt++;
		}

		$padding = 8;
		$spacing = RA__RESEARCH_VSPACING;
		$max_username_width += $padding;
		// sirka obrazku bude suma cez min * sirka researchu + padding-left + padding-right
		// image width will be sum over min * reseach width + padding-left + padding-right
		$gd_width = array_sum ($mins) * $rw + 2 * $padding + $max_username_width;
		$gd_height = ($rw + $spacing) * $real_cnt + 50;

		if (!($gd = imagecreatetruecolor ($gd_width, $gd_height)))
		{
			return false;
		}

		// fill gd with background
		if (!($bkgim = imagecreatefromjpeg (RA__RESOURCES_DIR . 'researches' . DIRECTORY_SEPARATOR . 'background.jpg')))
		{
			imagedestroy ($gd);
			return false;
		}

		$bkgim_w = imagesx ($bkgim);
		$bkgim_h = imagesy ($bkgim);

		$dst_x = $dst_y = 0;
		while ($dst_y < $gd_height)
		{
			while ($dst_x < $gd_width)
			{
				imagecopy ($gd, $bkgim, $dst_x, $dst_y, 0, 0, $bkgim_w, $bkgim_h);
				$dst_x += $bkgim_w;
			}
			$dst_x = 0;
			$dst_y += $bkgim_h;
		}
		imagedestroy ($bkgim);

		// fill gd with usernames
		$idx = 0;
		foreach ($this->playerList as $player)
		{
			if (empty ($player->researches))
			{
				continue;
			}

			$dst_y = $idx * ($rh + $spacing) + $padding + round (imagefontheight ($font) / 2); $dst_x = 0 + $padding;
			$idx++;

			switch ($player->colorId)
			{
				case 0x00:
					$color = imagecolorallocate ($gd, 0x6e, 0xa6, 0xeb);
					break;
				case 0x01:
					$color = imagecolorallocate ($gd, 0xff, 0x64, 0x64);
					break;
				case 0x02:
					$color = imagecolorallocate ($gd, 0x00, 0xff, 0x00);
					break;
				case 0x03:
					$color = imagecolorallocate ($gd, 0xff, 0xff, 0x00);
					break;
				case 0x04:
					$color = imagecolorallocate ($gd, 0x00, 0xff, 0xff);
					break;
				case 0x05:
					$color = imagecolorallocate ($gd, 0xf1, 0x6c, 0xe8);
					break;
				case 0x06:
					$color = imagecolorallocate ($gd, 0xdf, 0xdf, 0xdf);
					break;
				case 0x07:
					$color = imagecolorallocate ($gd, 0xff, 0x82, 0x01);
					break;
			}
			imagestring ($gd, $font, $dst_x, $dst_y, $player->name, $color);
		}

		// x_offsets bude obsahovat x-ovy offset prveho researchu v danej minute (variabilna dlzka minuty)
		// x_offsets will contain x-offset of first research in particular minute (variable length of minute)
		$x_offsets = array ();
		$sum = 0 + $padding + $max_username_width;
		foreach ($mins as $min => $cnt)
		{
			$x_offsets[$min] = $sum;
			$sum += $cnt * $rw;
		}

		// fill gd with colors for specific ages
		$darkage_color = imagecolorallocatealpha ($gd, 255, 0, 0, 80);
		$feudalage_color = imagecolorallocatealpha ($gd, 0, 255, 0, 80);
		$castleage_color = imagecolorallocatealpha ($gd, 0, 0, 255, 80);
		$imperialage_color = imagecolorallocatealpha ($gd, 0x99, 0x66, 0x00, 80);

		$idx = 0;
		foreach ($this->playerList as $player)
		{
			if (empty ($player->researches))
			{
				continue;
			}
			$dst_y = $idx * ($rh + $spacing) + $padding; $dst_x = 0; $prev_min = -1; $cnt = 0;
			$idx++;

			$age_flag = array (0, 0, 0);
			$age_x = array (0, 0, 0);
			foreach ($player->researches as $research_id => $min)
			{
				// if (array_key_exists ($research_id, $RA__RESEARCHES))
				{
					$min = floor ($min / 1000 / 60); // in minutes
					if ($prev_min == $min)
					{
						$cnt ++;
						$dst_x = $x_offsets[$min] + ($cnt * $rw);
					}
					else
					{
						$cnt = 0;
						$dst_x = $x_offsets[$min];
					}
					$prev_min = $min;
					if ($research_id == 101)
					{
						$age_flag[0] = 1;
						$x1 = 0 + $padding + $max_username_width;
						$y1 = $dst_y - 2;
						$x2 = $dst_x;
						$y2 = $dst_y + $rh + 2;
						imagefilledrectangle ($gd, $x1, $y1, $x2, $y2, $darkage_color);
						$age_x[0] = $x2;
					}
					elseif ($research_id == 102)
					{
						$age_flag[1] = 1;
						$x1 = $x2;// + $rw;
						$y1 = $dst_y - 2;
						$x2 = $dst_x;
						$y2 = $dst_y + $rh + 2;
						imagefilledrectangle ($gd, $x1, $y1, $x2, $y2, $feudalage_color);
						$age_x[1] = $x2;
					}
					elseif ($research_id == 103)
					{
						$age_flag[2] = 1;
						$x1 = $x2;// + $rw;
						$y1 = $dst_y - 2;
						$x2 = $dst_x;
						$y2 = $dst_y + $rh + 2;
						imagefilledrectangle ($gd, $x1, $y1, $x2, $y2, $castleage_color);
						$age_x[2] = $x2;

						$x1 = $x2;// + $rw;
						$y1 = $dst_y - 2;
						$x2 = $gd_width - $padding;
						$y2 = $dst_y + $rh + 2;
						imagefilledrectangle ($gd, $x1, $y1, $x2, $y2, $imperialage_color);
					}
				}
			}
			if (!$age_flag[0])
			{
				$x1 = 0 + $padding + $max_username_width;
				$y1 = $dst_y - 2;
				$x2 = $gd_width - $padding;
				$y2 = $dst_y + $rh + 2;
				imagefilledrectangle ($gd, $x1, $y1, $x2, $y2, $darkage_color);
			}
			elseif (!$age_flag[1])
			{
				$x1 = $age_x[0];
				$y1 = $dst_y - 2;
				$x2 = $gd_width - $padding;
				$y2 = $dst_y + $rh + 2;
				imagefilledrectangle ($gd, $x1, $y1, $x2, $y2, $feudalage_color);
			}
			elseif (!$age_flag[2])
			{
				$x1 = $age_x[1];
				$y1 = $dst_y - 2;
				$x2 = $gd_width - $padding;
				$y2 = $dst_y + $rh + 2;
				imagefilledrectangle ($gd, $x1, $y1, $x2, $y2, $castleage_color);
			}
		}

		// fill gd with researches
		$idx = 0;
		foreach ($this->playerList as $player)
		{
			// skip cooping player
			if (empty ($player->researches))
			{
				continue;
			}
			$dst_y = $idx * ($rh + $spacing) + $padding; $dst_x = 0; $prev_min = -1; $cnt = 0;
			$idx++;

			foreach ($player->researches as $research_id => $min)
			{
				if (array_key_exists ($research_id, $RA__RESEARCHES))
				{
					$min = floor ($min / 1000 / 60); // in minutes
					if ($prev_min == $min)
					{
						$cnt ++;
						$dst_x = $x_offsets[$min] + ($cnt * $rw);
					}
					else
					{
						$cnt = 0;
						$dst_x = $x_offsets[$min];
					}
					if ($im = imagecreatefromgif (RA__RESOURCES_DIR . 'researches' . DIRECTORY_SEPARATOR . $RA__RESEARCHES[$research_id][1]))
					{
						imagecopyresampled ($gd, $im, $dst_x, $dst_y, 0, 0, $rw, $rh, $orw, $orh);
						imagedestroy ($im);
					}
					$prev_min = $min;
				}
			}
		}

		// fill gd with timeline
		$shift = round (floor ($rw / 2) - imagefontheight (1) / 2);
		foreach ($mins as $min => $cnt)
		{
			if ($cnt == 0)
			{
				continue;
			}
			$x = $x_offsets[$min] + $shift;
			$y = $real_cnt * ($rh + $spacing) + $padding + 30;
			$label = sprintf ('%d min', $min);
			$white = imagecolorallocate ($gd, 255, 255, 255);
			$font = 1;
			imagestringup ($gd, $font, $x, $y, $label, $white);
			$x_offsets[$min] = $sum;
			$sum += $cnt * $rw;
		}

		return imagepng ($gd, RA__RESEARCHES_DIR . $researchesFileName);
	}

	/**
	 * Generates image map for research timelines.
	 *
	 * @return string generated image map
	 */
	public function generateResearchesImageMap ()
	{
		global $RA__RESEARCHES;

		foreach ($this->playerList as $player)
		{
			asort ($player->researches, SORT_NUMERIC);
		}

		$total_mins = ceil ($this->gameSettings->playTime / 1000 / 60);
		// original width / height of image representing one research
		$orw = $orh = 38;
		// new width / height of image representing one research
		$rw = $rh = RA__RESEARCH_TILE_SIZE;

		// reserve in case player clicked a research, but game finished before researching a technology
		$total_mins += 5;

		// pole mins bude obsahovat maximum zo sumy vynajdenych researches jednotliveho hraca v danej minute
		$mins = array ();
		$mins = array_fill (0, $total_mins, 0);

		foreach ($this->playerList as $player)
		{
			$prev_min = -1;
			$tmp_mins = array_fill (0, $total_mins, 0);
			foreach ($player->researches as $research_id => $min)
			{
				if (array_key_exists ($research_id, $RA__RESEARCHES))
				{
					$min = floor ($min / 1000 / 60); // in minutes
					$tmp_mins[$min]++;
				}
			}
			foreach ($mins as $min => &$cnt)
			{
				if ($cnt < $tmp_mins[$min])
				{
					$cnt = $tmp_mins[$min];
				}
			}
		}

		// calculate max username width
		$max_username_width = 0; // max width for username
		$font = 3; // font used for usernames
		$real_cnt = 0;
		foreach ($this->playerList as $player)
		{
			// skip cooping players
			if (empty ($player->researches))
			{
				continue;
			}
			if (strlen ($player->name) * imagefontwidth ($font) > $max_username_width)
			$max_username_width = strlen ($player->name) * imagefontwidth ($font);
			$real_cnt++;
		}

		$padding = 8;
		$spacing = RA__RESEARCH_VSPACING;
		$max_username_width += $padding;
		// sirka obrazku bude suma cez min * sirka researchu + padding-left + padding-right
		// image width will be sum over min * reseach width + padding-left + padding-right
		$gd_width = array_sum ($mins) * $rw + 2 * $padding + $max_username_width;
		$gd_height = ($rw + $spacing) * $real_cnt + 50;

		// x_offsets bude obsahovat x-ovy offset prveho researchu v danej minute (variabilna dlzka minuty)
		// x_offsets will contain x-offset of first research in particular minute (variable length of minute)
		$x_offsets = array ();
		$sum = 0 + $padding + $max_username_width;
		foreach ($mins as $min => $cnt)
		{
			$x_offsets[$min] = $sum;
			$sum += $cnt * $rw;
		}

		$imageMap = array ();
		$idx = 0;
		foreach ($this->playerList as $player)
		{
			if (empty ($player->researches))
			{
				continue;
			}
			$dst_y = $idx * ($rh + $spacing) + $padding; $dst_x = 0; $prev_min = -1; $cnt = 0;
			$idx++;

			foreach ($player->researches as $research_id => $min)
			{
				if (array_key_exists ($research_id, $RA__RESEARCHES))
				{
					$time = $min;
					$min = floor ($min / 1000 / 60); // in minutes

					if ($prev_min == $min)
					{
						$cnt ++;
						$dst_x = $x_offsets[$min] + ($cnt * $rw);
					}
					else
					{
						$cnt = 0;
						$dst_x = $x_offsets[$min];
					}
					$imageMap[] = array (
											0 => sprintf ('%d,%d,%d,%d', $dst_x, $dst_y, $dst_x + $rw, $dst_y + $rh),
											1 => sprintf ('%s %s', $RA__RESEARCHES[$research_id][0], self::gameTimeToString ($time, '(%02d:%02d:%02d)'))
					);
					$prev_min = $min;
				}
			}
		}

		return $imageMap;
	}
}
?>