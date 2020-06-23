<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$extensionPath =  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);

// Register post rendering hook
\Aoe\Asdis\Backend\Utility\HookUtility::registerHooks();

// Register scrapers
\Aoe\Asdis\Backend\Utility\ScraperUtility::registerScrapers($extensionPath);

// Register filters
\Aoe\Asdis\Backend\Utility\FiltersUtility::registerFilters($extensionPath);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
	file_get_contents($extensionPath . 'Configuration/TypoScript/setup.txt')
);