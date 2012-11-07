<?php
/**
 * Defines RecAnalystConst class.
 *
 * @package recAnalyst
 * @version $Id$
 * @author biegleux <biegleux[at]gmail[dot]com>
 * @copyright copyright (c) 2008-2012 biegleux
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 (GPLv3)
 * @link http://recanalyst.sourceforge.net/
 * @filesource
 */

/**
 * Class RecAnalystConst.
 *
 * RecAnalystConst implements constants used for RecAnalyst.
 *
 * @package recAnalyst
 */
final class RecAnalystConst {

	const IMG_EXT = '.gif';

	/**
	 * Map strings. Can be localized.
	 * @var array
	 */
	public static $MAPS = array(
		Map::ARABIA			=> array('Arabia',					'arabia'),
		Map::ARCHIPELAGO	=> array('Archipelago',				'archipelago'),
		Map::BALTIC			=> array('Baltic',					'baltic'),
		Map::BLACKFOREST	=> array('Black Forest',			'black_forest'),
		Map::COASTAL		=> array('Coastal',					'coastal'),
		Map::CONTINENTAL	=> array('Continental',				'continental'),
		Map::CRATERLAKE		=> array('Crater Lake',				'crater_lake'),
		Map::FORTRESS		=> array('Fortress',				'fortress'),
		Map::GOLDRUSH		=> array('Gold Rush',				'gold_rush'),
		Map::HIGHLAND		=> array('Highland',				'highland'),
		Map::ISLANDS		=> array('Islands',					'islands'),
		Map::MEDITERRANEAN	=> array('Mediterranean',			'mediterranean'),
		Map::MIGRATION		=> array('Migration',				'migration'),
		Map::RIVERS			=> array('Rivers',					'rivers'),
		Map::TEAMISLANDS	=> array('Team Islands',			'team_islands'),
		Map::RANDOM			=> array('Random',					'random'),
		Map::SCANDINAVIA	=> array('Scandinavia',				'scandinavia'),
		Map::MONGOLIA		=> array('Mongolia',				'mongolia'),
		Map::YUCATAN		=> array('Yucatan',					'yucatan'),
		Map::SALTMARSH		=> array('Salt Marsh',				'salt_marsh'),
		Map::ARENA			=> array('Arena',					'arena'),
		Map::KINGOFTHEHILL	=> array('King of the Hill',		''),
		Map::OASIS			=> array('Oasis',					'oasis'),
		Map::GHOSTLAKE		=> array('Ghost Lake',				'ghost_lake'),
		Map::NOMAD			=> array('Nomad',					'nomad.png'),
		Map::IBERIA			=> array('Iberia',					'iberia.png'),
		Map::BRITAIN		=> array('Britain',					'britain.png'),
		Map::MIDEAST		=> array('Mideast',					'mideast.png'),
		Map::TEXAS			=> array('Texas',					'texas.png'),
		Map::ITALY			=> array('Italy',					'italy.png'),
		Map::CENTRALAMERICA	=> array('Central America',			'central_america.png'),
		Map::FRANCE			=> array('France',					'france.png'),
		Map::NORSELANDS		=> array('Norse Lands',				'norse_lands.png'),
		Map::SEAOFJAPAN		=> array('Sea of Japan (East Sea)',	'sea_of_japan.png'),
		Map::BYZANTINUM		=> array('Byzantinum',				'byzantinum.png'),
		Map::CUSTOM			=> array('Custom',					''),
		Map::BLINDRANDOM	=> array('Blind Random',			'blind_random'),
	);

	/**
	 * Game version strings. Can be localized.
	 * @var array
	 */
	public static $GAME_VERSIONS = array(
		'Unknown',
		'AOK',
		'AOK Trial',
		'AOK 2.0',
		'AOK 2.0a',
		'AOC',
		'AOC Trial',
		'AOC 1.0',
		'AOC 1.0c',
		'AOC 1.1'
	);

	/**
	 * Map style strings. Can be localized
	 * @var array
	 */
	public static $MAP_STYLES = array(
    	'Standard',
    	'Real World',
    	'Custom'
	);

	/**
	 * Difficulty level strings. Can be localized.
	 * @var array
	 */
	public static $DIFFICULTY_LEVELS = array(
    	'Hardest',
    	'Hard',
    	'Moderate',
    	'Standard',
    	'Easiest'
	);

	/**
	 * Difficulty level strings for AOK. Can be localized.
	 * @var array
	 */
	public static $AOK_DIFFICULTY_LEVELS = array(
    	'Hardest',
    	'Hard',
    	'Moderate',
    	'Easy',
    	'Easiest'
	);

	/**
	 * Game type strings. Can be localized.
	 * @var array
	 */
	public static $GAME_TYPES = array(
    	'Random map',
	    'Regicide',
    	'Death match',
	    'Scenario',
    	'Campaign',
	    'King of the Hill',
    	'Wonder race',
	    'Defend Wonder',
    	'Turbo Random map'
	);

	/**
	 * Game speed strings. Can be localized.
	 * @var array
	 */
	public static $GAME_SPEEDS = array(
    	100 => 'Slow',
    	150 => 'Normal',
    	200 => 'Fast'
	);

	/**
	 * Reveal setting strings. Can be localized.
	 * @var array
	 */
	public static $REVEAL_SETTINGS = array(
		'Normal',
		'Explored',
		'All Visible'
	);

	/**
	 * Map size strings. Can be localized.
	 * @var array
	 */
	public static $MAP_SIZES = array(
		'Tiny (2 players)',
		'Small (3 players)',
		'Medium (4 players)',
		'Normal (6 players)',
		'Large (8 players)',
		'Giant'
	);

	/**
	 * Starting age strings. Can be localized.
	 * @var array
	 */
	public static $STARTING_AGES = array(
		'Dark Age',
		'Feudal Age',
		'Castle Age',
		'Imperial Age',
		'Post-Imperial Age'
	);

	/**
	 * Victory condition strings. Can be localized.
	 * @var array
	 */
	public static $VICTORY_CONDITIONS = array(
    	'Standard',
    	'Conquest',
    	'Time Limit',
    	'Score Limit',
    	'Custom'
	);

	/**
	 * Civilization strings. Can be localized.
	 * @var array
	 */
	public static $CIVS = array(
		array('', 			''),
		array('Britons',	'britons'),
		array('Franks',		'franks'),
		array('Goths',		'goths'),
		array('Teutons',	'teutons'),
		array('Japanese',	'japanese'),
		array('Chinese',	'chinese'),
		array('Byzantines',	'byzantines'),
		array('Persians',	'persians'),
		array('Saracens',	'saracens'),
		array('Turks',		'turks'),
		array('Vikings',	'vikings'),
		array('Mongols',	'mongols'),
		array('Celts',		'celts'),
		array('Spanish',	'spanish'),
		array('Aztecs',		'aztecs'),
		array('Mayans',		'mayans'),
		array('Huns',		'huns'),
		array('Koreans',	'koreans')
	);

	public static $COLORS = array(
		0x00 => '#0000ff',
		0x01 => '#ff0000',
		0x02 => '#00ff00',
		0x03 => '#ffff00',
		0x04 => '#00ffff',
		0x05 => '#ff00ff',
		0x06 => '#b9b9b9',
		0x07 => '#ff8201'
	);

	/**
	 * Resource strings. Can be localized.
	 * @var array
	 */
	public static $RESOURCES = array(
		0x00 => 'food',
		0x01 => 'wood',
		0x02 => 'stone',
		0x03 => 'gold'
	);

	/**
	 * Research strings. Can be localized.
	 * @var array
	 */
	public static $RESEARCHES = array(
		101 => array('Feudal Age',				'feudal_age'),
		102 => array('Castle Age',				'castle_age'),
		103 => array('Imperial Age',			'imperial_age'),
		 22 => array('Loom',					'loom'),
		213 => array('Wheel Barrow',			'wheel-barrow'),
		249 => array('Hand Cart',				'hand_cart'),
		  8 => array('Town Watch',				'town_watch'),
		280 => array('Town Patrol',				'town_patrol'),
		 14 => array('Horse Collar',			'horse_collar'),
		 13 => array('Heavy Plow',				'heavy_plow'),
		 12 => array('Crop Rotation',			'crop_rotation'),
		202 => array('Double Bit Axe',			'double_bit_axe'),
		203 => array('Bow Saw',					'bow_saw'),
		221 => array('Two Man Saw',				'two_man_saw'),
		 55 => array('Gold Mining',				'gold_mining'),
		278 => array('Stone Mining',			'stone_mining'),
		182 => array('Gold Shaft Mining',		'gold_shaft_mining'),
		279 => array('Stone Shaft Mining',		'stone_shaft_mining'),
		 19 => array('Cartography',				'cartography'),
		 23 => array('Coinage',					'coinage'),
		 48 => array('Caravan',					'caravan'),
		 17 => array('Banking',					'banking'),
		 15 => array('Guilds',					'guilds'),
		211 => array('Padded Archer Armor',		'padded_archer_armor'),
		212 => array('Leather Archer Armor',	'leather_archer_armor'),
		219 => array('Ring Archer Armor',		'ring_archer_armor'),
		199 => array('Fletching',				'fletching'),
		200 => array('Bodkin Arrow',			'bodkin_arrow'),
		201 => array('Bracer',					'bracer'),
		 67 => array('Forging',					'forging'),
		 68 => array('Iron Casting',			'iron_casting'),
		 75 => array('Blast Furnace',			'blast_furnace'),
		 81 => array('Scale Barding',			'scale_barding'),
		 82 => array('Chain Barding',			'chain_barding'),
		 80 => array('Plate Barding',			'plate_barding'),
		 74 => array('Scale Mail',				'scale_mail'),
		 76 => array('Chain Mail',				'chain_mail'),
		 77 => array('Plate Mail',				'plate_mail'),
		 50 => array('Masonry',					'masonry'),
		194 => array('Fortified Wall',			'fortified_wall'),
		 93 => array('Ballistics',				'ballistics'),
		380 => array('Heated Shot',				'heated_shot'),
		322 => array('Murder Holes',			'murder_holes'),
		 54 => array('Stonecutting',			'stonecutting'),
		 51 => array('Architecture',			'architecture'),
		 47 => array('Chemistry',				'chemistry'),
		377 => array('Siege Engineers',			'siege_engineers'),
		140 => array('Guard Tower',				'guard_tower'),
		 63 => array('Keep',					'keep'),
		 64 => array('Bombard Tower',			'bombard_tower'),
		222 => array('Man At Arms',				'man_at_arms'),
		207 => array('Long Swordsman',			'long_swordsman'),
		217 => array('Two Handed Swordsman',	'two_handed_swordsman'),
		264 => array('Champion',				'champion'),
		197 => array('Pikeman',					'pikeman'),
		429 => array('Halberdier',				'halberdier'),
		434 => array('Elite Eagle Warrior',		'eagle_warrior'),
		 90 => array('Tracking',				'tracking'),
		215 => array('Squires',					'squires'),
		100 => array('Crossbow',				'crossbow'),
		237 => array('Arbalest',				'arbalest'),
		 98 => array('Elite Skirmisher',		'elite_skirmisher'),
		218 => array('Heavy Cavalry Archer',	'heavy_cavalry_archer'),
		437 => array('Thumb Ring',				'thumb_ring'),
		436 => array('Parthian Tactics',		'parthian_tactics'),
		254 => array('Light Cavalry',			'light_cavalry'),
		428 => array('Hussar',					'hussar'),
		209 => array('Cavalier',				'cavalier'),
		265 => array('Paladin',					'paladin'),
		236 => array('Heavy Camel',				'heavy_camel'),
		435 => array('Bloodlines',				'bloodlines'),
		 39 => array('Husbandry',				'husbandry'),
		257 => array('Onager',					'onager'),
		320 => array('Siege Onager',			'siege_onager'),
		 96 => array('Capped Ram',				'capped_ram'),
		255 => array('Siege Ram',				'siege_ram'),
		239 => array('Heavy Scorpion',			'heavy_scorpion'),
		316 => array('Redemption',				'redemption'),
		252 => array('Fervor',					'fervor'),
		231 => array('Sanctity',				'sanctity'),
		319 => array('Atonement',				'atonement'),
		441 => array('Herbal Medicine',			'herbal_medicine'),
		439 => array('Heresy',					'heresy'),
		230 => array('Block Printing',			'block_printing'),
		233 => array('Illumination',			'illumination'),
		 45 => array('Faith',					'faith'),
		438 => array('Theocracy',				'theocracy'),
		 34 => array('War Galley',				'war_galley'),
		 35 => array('Galleon',					'galleon'),
		246 => array('Fast Fire Ship',			'fast_fire_ship'),
		244 => array('Heavy Demolition Ship',	'heavy_demolition_ship'),
		 37 => array('Cannon Galleon',			'cannon_galleon'),
		376 => array('Elite Cannon Galleon',	'cannon_galleon'),
		373 => array('Shipwright',				'shipwright'),
		374 => array('Careening',				'careening'),
		375 => array('Dry Dock',				'dry_dock'),
		379 => array('Hoardings',				'hoardings'),
		321 => array('Sappers',					'sappers'),
		315 => array('Conscription',			'conscription'),
		408 => array('Spies / Treason',			'spy'),
		// unique-unit-upgrade
		432 => array('Elite Jaguar Man',		'jaguar_man'),
		361 => array('Elite Cataphract',		'cataphract'),
		370 => array('Elite Woad Raider',		'woad_raider'),
		362 => array('Elite Chu-Ko-Nu',			'chu_ko_nu'),
		360 => array('Elite Longbowman',		'longbowman'),
		363 => array('Elite Throwing Axeman',	'throwing_axeman'),
		365 => array('Elite Huskarl',			'huskarl'),
		  2 => array('Elite Tarkan',			'tarkan'),
		366 => array('Elite Samurai',			'samurai'),
		450 => array('Elite War Wagon',			'war_wagon'),
		448 => array('Elite Turtle Ship',		'turtle_ship'),
		//348 => array('Elite Turtle Ship',		'turtle_ship'),
		 27 => array('Elite Plumed Archer',		'plumed_archer'),
		371 => array('Elite Mangudai',			'mangudai'),
		367 => array('Elite War Elephant',		'war_elephant'),
		368 => array('Elite Mameluke',			'mameluke'),
		//378 => array('Elite Mameluke',		'mameluke'),
		 60 => array('Elite Conquistador',		'conquistador'),
		364 => array('Elite Teutonic Knight',	'teutonic_knight'),
		369 => array('Elite Janissary',			'janissary'),
		398 => array('Elite Berserk',			'berserk'),
		372 => array('Elite Longboat',			'longboat'),
		// unique-research
		 24 => array('Garland Wars',			'unique_tech'),
		 61 => array('Logistica',				'unique_tech'),
		  5 => array('Furor Celtica',			'unique_tech'),
		 52 => array('Rocketry',				'unique_tech'),
		  3 => array('Yeomen',					'unique_tech'),
		 83 => array('Bearded Axe',				'unique_tech'),
		 16 => array('Anarchy',					'unique_tech'),
		457 => array('Perfusion',				'unique_tech'),
		 21 => array('Atheism',					'unique_tech'),
		 59 => array('Kataparuto',				'unique_tech'),
		445 => array('Shinkichon',				'unique_tech'),
		  4 => array('El Dorado',				'unique_tech'),
		  6 => array('Drill',					'unique_tech'),
		  7 => array('Mahouts',					'unique_tech'),
		  9 => array('Zealotry',				'unique_tech'),
		440 => array('Supremacy',				'unique_tech'),
		 11 => array('Crenellations',			'unique_tech'),
		 10 => array('Artillery',				'unique_tech'),
		 49 => array('Berserkergang',			'unique_tech')
	);

	/**
	 * Unit strings. Can be localized.
	 * @var array
	 */
	public static $UNITS = array(
		  4 => array('Archer',					'archer'),
		  5 => array('Hand Cannoneer',			'hand_cannoneer'),
		  6 => array('Elite Skirmisher',		'elite_skirmisher'),
		  7 => array('Skirmisher',				'skirmisher'),
		  8 => array('Longbowman',				'longbowman'),
		 11 => array('Mangudai',				'mangudai'),
		 13 => array('Fishing Ship',			'fishing_ship'),
		 17	=> array('Trade Cog',				'trade_cog'),
		 21	=> array('War Galley',				'war_galley'),
		 24	=> array('Crossbowman',				'crossbowman'),
		 25	=> array('Teutonic Knight',			'teutonic_knight'),
		 35	=> array('Battering Ram',			'battering_ram'),
		 36	=> array('Bombard Cannon',			'bombard_cannon'),
		 38	=> array('Knight',					'knight'),
		 39	=> array('Cavalry Archer',			'cavalry_archer'),
		 40	=> array('Cataphract',				'cataphract'),
		 41	=> array('Huskarl',					'huskarl'),
	//	 42	=> array('Trebuchet (Unpacked)',	'trebuchet'),
		 46	=> array('Janissary',				'janissary'),
		 73	=> array('Chu Ko Nu',				'chu_ko_nu'),
		 74	=> array('Militia',					'militiaman'),
		 75	=> array('Man At Arms',				'man_at_arms'),
		 76	=> array('Heavy Swordsman',			'heavy_swordsman'),
		 77	=> array('Long Swordsman',			'long_swordsman'),
		 83	=> array('Villager',				'villager'),
		 93	=> array('Spearman',				'spearman'),
		125	=> array('Monk',					'monk'),
	//	128	=> array('Trade Cart, Empty',		''),
		128	=> array('Trade Cart',				'trade_cart'),
	//	204	=> array('Trade Cart, Full',		''),
		232	=> array('Woad Raider',				'woad_raider'),
		239	=> array('War Elephant',			'war_elephant'),
		250	=> array('Longboat',				'longboat'),
		279	=> array('Scorpion',				'scorpion'),
		280	=> array('Mangonel',				'mangonel'),
		281	=> array('Throwing Axeman',			'throwing_axeman'),
		282	=> array('Mameluke',				'mameluke'),
		283	=> array('Cavalier',				'cavalier'),
	//	286	=> array('Monk With Relic',			''),
		291	=> array('Samurai',					'samurai'),
		329	=> array('Camel',					'camel'),
		330	=> array('Heavy Camel',				'heavy_camel'),
	//	331	=> array('Trebuchet, P',			'trebuchet'),
		331	=> array('Trebuchet',				'trebuchet'),
		358	=> array('Pikeman',					'pikeman'),
		359	=> array('Halberdier',				'halberdier'),
		420	=> array('Cannon Galleon',			'cannon_galleon'),
		422	=> array('Capped Ram',				'capped_ram'),
		434	=> array('King',					'king'),
		440	=> array('Petard',					'petard'),
		441	=> array('Hussar',					'hussar'),
		442	=> array('Galleon',					'galleon'),
		448	=> array('Scout Cavalry',			'scout_cavalry'),
		473	=> array('Two Handed Swordsman',	'two_handed_swordsman'),
		474	=> array('Heavy Cavalry Archer',	'heavy_cavalry_archer'),
		492	=> array('Arbalest',				'arbalest'),
	//	493	=> array('Adv Heavy Crossbowman',	''),
		527	=> array('Demolition Ship',			'demolition_ship'),
		528	=> array('Heavy Demolition Ship',	'heavy_demolition_ship'),
		529	=> array('Fire Ship',				'fire_ship'),
		530	=> array('Elite Longbowman',		'longbowman'),
		531	=> array('Elite Throwing Axeman',	'throwing_axeman'),
		532	=> array('Fast Fire Ship',			'fast_fire_ship'),
		533	=> array('Elite Longboat',			'longboat'),
		534	=> array('Elite Woad Raider',		'woad_raider'),
		539	=> array('Galley',					'galley'),
		542	=> array('Heavy Scorpion',			'heavy_scorpion'),
		545	=> array('Transport Ship',			'transport_ship'),
		546	=> array('Light Cavalry',			'light_cavalry'),
		548	=> array('Siege Ram',				'siege_ram'),
		550	=> array('Onager',					'onager'),
		553	=> array('Elite Cataphract',		'cataphract'),
		554	=> array('Elite Teutonic Knight',	'teutonic_knight'),
		555	=> array('Elite Huskarl',			'huskarl'),
		556	=> array('Elite Mameluke',			'mameluke'),
		557	=> array('Elite Janissary',			'janissary'),
		558	=> array('Elite War Elephant',		'war_elephant'),
		559	=> array('Elite Chu Ko Nu',			'chu_ko_nu'),
		560	=> array('Elite Samurai',			'samurai'),
		561	=> array('Elite Mangudai',			'mangudai'),
		567	=> array('Champion',				'champion'),
		569	=> array('Paladin',					'paladin'),
		588	=> array('Siege Onager',			'siege_onager'),
		692	=> array('Berserk',					'berserk'),
		694	=> array('Elite Berserk',			'berserk'),
		725	=> array('Jaguar Warrior',			'jaguar_man'),
		726	=> array('Elite Jaguar Warrior',	'jaguar_man'),
	//	748	=> array('Cobra Car',				''),
		751	=> array('Eagle Warrior',			'eagle_warrior'),
		752	=> array('Elite Eagle Warrior',		'eagle_warrior'),
		755	=> array('Tarkan',					'tarkan'),
		757	=> array('Elite Tarkan',			'tarkan'),
		759	=> array('Huskarl',					'huskarl'),
		761	=> array('Elite Huskarl',			'huskarl'),
		763	=> array('Plumed Archer',			'plumed_archer'),
		765	=> array('Elite Plumed Archer',		'plumed_archer'),
		771	=> array('Conquistador',			'conquistador'),
		773	=> array('Elite Conquistador',		'conquistador'),
		775	=> array('Missionary',				'missionary'),
	//	812	=> array('Jaguar',					''),
		827	=> array('War Wagon',				'war_wagon'),
		829	=> array('Elite War Wagon',			'war_wagon'),
		831	=> array('Turtle Ship',				'turtle_ship'),
		832	=> array('Elite Turtle Ship',		'turtle_ship'),
	);

	/**
	 * Building strings. Can be localized.
	 * @var array
	 */
	public static $BUILDINGS = array(
		 12 => array('Barracks',		'barracks'),
		 45 => array('Dock',			'dock'),
		 49 => array('Siege Workshop',	'siege_workshop'),
		 50 => array('Farm',			'farm'),
		 68 => array('Mill',			'mill'),
		 70 => array('House',			'house'),
		 72 => array('Wall, Palisade',	'palisade_wall'),
		 79 => array('Watch Tower',		'watch_tower'),
		 82 => array('Castle',			'castle'),
		 84 => array('Market',			'market'),
		 87 => array('Archery Range',	'archery_range'),
		101	=> array('Stable',			'stable'),
		103	=> array('Blacksmith',		'blacksmith'),
		104	=> array('Monastery',		'monastery'),
		109	=> array('Town Center',		'town_center'),
		117	=> array('Wall, Stone',		'stone_wall'),
		155	=> array('Wall, Fortified',	'fortified_wall'),
		199 => array('Fish Trap',		'fish_trap'),
		209	=> array('University',		'university'),
		234	=> array('Guard Tower',		'guard_tower'),
		235	=> array('Keep',			'keep'),
		236	=> array('Bombard Tower',	'bombard_tower'),
		276	=> array('Wonder',			'wonder'),
		487	=> array('Gate',			'gate'),
		490	=> array('Gate',			'gate'),
		562	=> array('Lumber Camp',		'lumber_camp'),
		584	=> array('Mining Camp',		'mining_camp'),
		598	=> array('Outpost',			'outpost'),
		621	=> array('Town Center',		'town_center'),
		665 => array('Gate',			'gate'),
		673	=> array('Gate',			'gate')
	);

	/**
	 * Terrain colors.
	 * @var array
	 */
	public static $TERRAIN_COLORS = array(
		array(0x33, 0x97, 0x27),
		array(0x30, 0x5d, 0xb6),
		array(0xe8, 0xb4, 0x78),
		array(0xe4, 0xa2, 0x52),
		array(0x54, 0x92, 0xb0),
		array(0x33, 0x97, 0x27),
		array(0xe4, 0xa2, 0x52),
		array(0x82, 0x88, 0x4d),//
		array(0x82, 0x88, 0x4d),//
		array(0x33, 0x97, 0x27),
		array(0x15, 0x76, 0x15),
		array(0xe4, 0xa2, 0x52),
		array(0x33, 0x97, 0x27),
		array(0x15, 0x76, 0x15),
		array(0xe8, 0xb4, 0x78),
		array(0x30, 0x5d, 0xb6),//
		array(0x33, 0x97, 0x27),//
		array(0x15, 0x76, 0x15),
		array(0x15, 0x76, 0x15),
		array(0x15, 0x76, 0x15),
		array(0x15, 0x76, 0x15),
		array(0x15, 0x76, 0x15),
		array(0x00, 0x4a, 0xa1),
		array(0x00, 0x4a, 0xbb),
		array(0xe4, 0xa2, 0x52),
		array(0xe4, 0xa2, 0x52),
		array(0xff, 0xec, 0x49),//
		array(0xe4, 0xa2, 0x52),
		array(0x30, 0x5d, 0xb6),//
		array(0x82, 0x88, 0x4d),//
		array(0x82, 0x88, 0x4d),//
		array(0x82, 0x88, 0x4d),//
		array(0xc8, 0xd8, 0xff),
		array(0xc8, 0xd8, 0xff),
		array(0xc8, 0xd8, 0xff),
		array(0x98, 0xc0, 0xf0),
		array(0xc8, 0xd8, 0xff),//
		array(0x98, 0xc0, 0xf0),
		array(0xc8, 0xd8, 0xff),
		array(0xc8, 0xd8, 0xff),
		array(0xe4, 0xa2, 0x52)
	);

	/**
	 * Object colors.
	 * @var array
	 */
	public static $OBJECT_COLORS = array(
		Unit::GOLDMINE   => array(0xff, 0xc7, 0x00),
		Unit::STONEMINE  => array(0x91, 0x91, 0x91),
		Unit::CLIFF1     => array(0x71, 0x4b, 0x33),
		Unit::CLIFF2     => array(0x71, 0x4b, 0x33),
		Unit::CLIFF3     => array(0x71, 0x4b, 0x33),
		Unit::CLIFF4     => array(0x71, 0x4b, 0x33),
		Unit::CLIFF5     => array(0x71, 0x4b, 0x33),
		Unit::CLIFF6     => array(0x71, 0x4b, 0x33),
		Unit::CLIFF7     => array(0x71, 0x4b, 0x33),
		Unit::CLIFF8     => array(0x71, 0x4b, 0x33),
		Unit::CLIFF9     => array(0x71, 0x4b, 0x33),
		Unit::CLIFF10    => array(0x71, 0x4b, 0x33),
		Unit::RELIC      => array(0xff, 0xff, 0xff),
		Unit::TURKEY     => array(0xa5, 0xc4, 0x6c),
		Unit::SHEEP      => array(0xa5, 0xc4, 0x6c),
		Unit::DEER       => array(0xa5, 0xc4, 0x6c),
		Unit::BOAR       => array(0xa5, 0xc4, 0x6c),
		Unit::JAVELINA   => array(0xa5, 0xc4, 0x6c),
		Unit::FORAGEBUSH => array(0xa5, 0xc4, 0x6c)
	);

	/**
	 * Player colors.
	 * @var array
	 */
	public static $PLAYER_COLORS = array(
		0x00 => array(0x00, 0x00, 0xff),
		0x01 => array(0xff, 0x00, 0x00),
		0x02 => array(0x00, 0xff, 0x00),
		0x03 => array(0xff, 0xff, 0x00),
		0x04 => array(0x00, 0xff, 0xff),
		0x05 => array(0xff, 0x00, 0xff),
		0x06 => array(0xb9, 0xb9, 0xb9),
		0x07 => array(0xff, 0x82, 0x01)
	);

	/**
	 * Real world maps.
	 * @var array
	 */
	public static $REAL_WORLD_MAPS = array(
		Map::IBERIA,
		Map::BRITAIN,
		Map::MIDEAST,
		Map::TEXAS,
		Map::ITALY,
		Map::CENTRALAMERICA,
		Map::FRANCE,
		Map::NORSELANDS,
		Map::SEAOFJAPAN,
		Map::BYZANTINUM
	);

	/**
	 * Cliff units.
	 * @var array
	 */
	public static $CLIFF_UNITS = array(
		Unit::CLIFF1,
		Unit::CLIFF2,
		Unit::CLIFF3,
		Unit::CLIFF4,
		Unit::CLIFF5,
		Unit::CLIFF6,
		Unit::CLIFF7,
		Unit::CLIFF8,
		Unit::CLIFF9,
		Unit::CLIFF10
	);

	/**
	 * Gate units.
	 * @var array
	 */
	public static $GATE_UNITS = array(
		Unit::GATE,
		Unit::GATE2,
		Unit::GATE3,
		Unit::GATE4
	);

	const VER_94 = 'VER 9.4';
	const VER_93 = 'VER 9.3';
	const TRL_93 = 'TRL 9.3';
}

final class GameVersion {

	const UNKNOWN	= 0;
	const AOK		= 1;
	const AOKTRIAL	= 2;
	const AOK20		= 3;
	const AOK20A	= 4;
	const AOC		= 5;
	const AOCTRIAL	= 6;
	const AOC10		= 7;
	const AOC10C	= 8;
	const AOC11		= 9;

	private function __construct(){}
}

final class MapStyle {

	const STANDARD  = 0;
	const REALWORLD = 1;
	const CUSTOM    = 2;

	private function __construct(){}
}

final class DifficultyLevel {

	const HARDEST  = 0;
	const HARD     = 1;
	const MODERATE = 2;
	const STANDARD = 3;
	const EASIEST  = 4;

	private function __construct(){}
}

final class GameType {

	const RANDOMMAP  = 0;
	const REGICIDE   = 1;
	const DEATHMATCH = 2;
	const SCENARIO   = 3;
	const CAMPAIGN   = 4;

	private function __construct(){}
}

final class GameSpeed {

	const SLOW   = 100;
	const NORMAL = 150;
	const FAST   = 200;

	private function __construct(){}
}

final class RevealMap {

	const NORMAL     = 0;
	const EXPLORED   = 1;
	const ALLVISIBLE = 2;

	private function __construct(){}
}

final class MapSize {

	const TINY   = 0;
	const SMALL  = 1;
	const MEDIUM = 2;
	const NORMAL = 3;
	const LARGE  = 4;
	const GIANT  = 5;

	private function __construct(){}
}

final class Civilization {

	const NONE       = 0;
	const BRITONS    = 1;
	const FRANKS     = 2;
	const GOTHS      = 3;
	const TEUTONS    = 4;
	const JAPANESE   = 5;
	const CHINESE    = 6;
	const BYZANTINES = 7;
	const PERSIANS   = 8;
	const SARACENS   = 9;
	const TURKS      = 10;
	const VIKINGS    = 11;
	const MONGOLS    = 12;
	const CELTS      = 13;
	const SPANISH    = 14;
	const AZTECS     = 15;
	const MAYANS     = 16;
	const HUNS       = 17;
	const KOREANS    = 18;

	private function __construct(){}
}

final class Resource {

	const FOOD  = 0;
	const WOOD  = 1;
	const STONE = 2;
	const GOLD  = 3;

	private function __construct(){}
}

final class StartingAge {

	const DARKAGE         = 0;
	const FEUDALAGE       = 1;
	const CASTLEAGE       = 2;
	const IMPERIALAGE     = 3;
	const POSTIMPERIALAGE = 4;

	private function __construct(){}
}

final class VictoryCondition {

	const STANDARD   = 0;
	const CONQUEST   = 1;
	const TIMELIMIT  = 2;
	const SCORELIMIT = 3;
	const CUSTOM     = 4;

	private function __construct(){}
}

final class Map {

	const ARABIA         = 9;
	const ARCHIPELAGO    = 10;
	const BALTIC         = 11;
	const BLACKFOREST    = 12;
	const COASTAL        = 13;
	const CONTINENTAL    = 14;
	const CRATERLAKE     = 15;
	const FORTRESS       = 16;
	const GOLDRUSH       = 17;
	const HIGHLAND       = 18;
	const ISLANDS        = 19;
	const MEDITERRANEAN  = 20;
	const MIGRATION      = 21;
	const RIVERS         = 22;
	const TEAMISLANDS    = 23;
	const RANDOM         = 24;
	const SCANDINAVIA    = 25;
	const MONGOLIA       = 26;
	const YUCATAN        = 27;
	const SALTMARSH      = 28;
	const ARENA          = 29;
	const KINGOFTHEHILL  = 30;
	const OASIS          = 31;
	const GHOSTLAKE      = 32;
	const NOMAD          = 33;
	const IBERIA         = 34;
	const BRITAIN        = 35;
	const MIDEAST        = 36;
	const TEXAS          = 37;
	const ITALY          = 38;
	const CENTRALAMERICA = 39;
	const FRANCE         = 40;
	const NORSELANDS     = 41;
	const SEAOFJAPAN     = 42;
	const BYZANTINUM     = 43;
	const CUSTOM         = 44;
	const BLINDRANDOM    = 48;

	private function __construct(){}
}

final class Unit {

	const GOLDMINE   = 66;
	const STONEMINE  = 102;
	const CLIFF1     = 264;
	const CLIFF2     = 265;
	const CLIFF3     = 266;
	const CLIFF4     = 267;
	const CLIFF5     = 268;
	const CLIFF6     = 269;
	const CLIFF7     = 270;
	const CLIFF8     = 271;
	const CLIFF9     = 272;
	const CLIFF10    = 273;
	const RELIC      = 285;
	const TURKEY     = 833;
	const SHEEP      = 594;
	const DEER       = 65;
	const BOAR       = 48;
	const JAVELINA   = 822;
	const FORAGEBUSH = 59;

	const GATE	= 487;
	const GATE2	= 490;
	const GATE3	= 665;
	const GATE4	= 673;
}
?>