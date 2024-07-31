<?php

use Aoe\Asdis\Backend\Utility\FiltersUtility;
use Aoe\Asdis\Backend\Utility\ScraperUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$extensionPath =  ExtensionManagementUtility::extPath('asdis');

// Register scrapers
ScraperUtility::registerScrapers($extensionPath);

// Register filters
FiltersUtility::registerFilters($extensionPath);

ExtensionManagementUtility::addTypoScriptSetup(
	file_get_contents($extensionPath . 'Configuration/TypoScript/setup.txt')
);
