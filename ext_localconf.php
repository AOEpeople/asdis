<?php

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
	'key'   => 'htmlImage',
	'class' => 'Tx_Asdis_Content_Scraper_Html_Image',
	'file'  => t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Content/Scraper/Html/Image.php'
);

//t3lib_extMgm::addPageTSConfig();

t3lib_extMgm::addTypoScriptSetup(
	file_get_contents(t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TypoScript/setup.txt')
);