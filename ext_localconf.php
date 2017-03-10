<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$extensionPath =  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);

// Register post rendering hook
Tx_Asdis_Backend_Utility_HookUtility::registerHooks();

// Register scrapers
Tx_Asdis_Backend_Utility_ScraperUtility::registerScrapers($extensionPath);

// Register filters
Tx_Asdis_Backend_Utility_FiltersUtility::registerFilters($extensionPath);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
	file_get_contents($extensionPath . 'Configuration/TypoScript/setup.txt')
);