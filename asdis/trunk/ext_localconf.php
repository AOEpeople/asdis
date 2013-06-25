<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

define('PATH_tx_asdis', t3lib_extMgm::extPath($_EXTKEY));

// Register Hooks
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][]    = 'EXT:asdis/Classes/Typo3/Hook/ContentPostProcAll.php:&Tx_Asdis_Typo3_Hook_ContentPostProcAll->process';
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-cached'][] = 'EXT:asdis/Classes/Typo3/Hook/ContentPostProcCached.php:&Tx_Asdis_Typo3_Hook_ContentPostProcCached->process';
if (TYPO3_MODE == 'FE') {
	$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['headerNoCache']['tx_asdis'] = 'EXT:asdis/Classes/Typo3/Hook/HeaderNoCache.php:&Tx_Asdis_Typo3_Hook_HeaderNoCache->process';
}

// Register "Processing Instruction" key and label with "crawler" extension:
$TYPO3_CONF_VARS['EXTCONF']['crawler']['procInstructions']['tx_asdis_publish'] = 'Asdis publish';

// Register scrapers
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'] = array();
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'cssUrl',
	'class' => 'Tx_Asdis_Content_Scraper_Css_Url',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Css/Url.php'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'htmlCssFile',
	'class' => 'Tx_Asdis_Content_Scraper_Html_CssFile',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Html/CssFile.php'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'htmlCssInline',
	'class' => 'Tx_Asdis_Content_Scraper_Html_CssInline',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Html/CssInline.php'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'htmlEmbed',
	'class' => 'Tx_Asdis_Content_Scraper_Html_Embed',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Html/Embed.php'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'htmlFavicon',
	'class' => 'Tx_Asdis_Content_Scraper_Html_Favicon',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Html/Favicon.php'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'htmlImage',
	'class' => 'Tx_Asdis_Content_Scraper_Html_Image',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Html/Image.php'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'htmlInputImage',
	'class' => 'Tx_Asdis_Content_Scraper_Html_InputImage',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Html/InputImage.php'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'htmlOpenGraphImage',
	'class' => 'Tx_Asdis_Content_Scraper_Html_OpenGraphImage',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Html/OpenGraphImage.php'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'htmlScript',
	'class' => 'Tx_Asdis_Content_Scraper_Html_Script',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Html/Script.php'
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
	'key'   => 'htmlSwfObject',
	'class' => 'Tx_Asdis_Content_Scraper_Html_SwfObject',
	'file'  => PATH_tx_asdis . 'Classes/Content/Scraper/Html/SwfObject.php'
);

t3lib_extMgm::addTypoScriptSetup(
	file_get_contents(PATH_tx_asdis . 'Configuration/TypoScript/setup.txt')
);

// defualt extbase dependency injection class mapping setup
t3lib_extMgm::addTypoScriptSetup(
	file_get_contents(PATH_tx_asdis . 'Configuration/TypoScript/defaultDiMappingSetup.txt')
);