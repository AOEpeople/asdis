<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 AOE GmbH <dev@aoe.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class Tx_Asdis_Backend_Utility_HookUtility
 */
class Tx_Asdis_Backend_Utility_HookUtility {

	/**
	 * Register hooks
	 *
	 * @return void
	 */
	public static function registerHooks() {
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['asdis']);
		switch ($extConf['hook']) {
			case 'contentPostProc-all':
				$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = 'EXT:asdis/Classes/Typo3/Hook/ContentPostProcAll.php:&Tx_Asdis_Typo3_Hook_ContentPostProcAll->process';
				break;
			case 'contentPostProc-output':
				$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'EXT:asdis/Classes/Typo3/Hook/ContentPostProcAll.php:&Tx_Asdis_Typo3_Hook_ContentPostProcAll->process';
				break;
			case 'contentPostProc-all_and_output':
				$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = 'EXT:asdis/Classes/Typo3/Hook/ContentPostProcAll.php:&Tx_Asdis_Typo3_Hook_ContentPostProcAll->processCache';
				$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'EXT:asdis/Classes/Typo3/Hook/ContentPostProcAll.php:&Tx_Asdis_Typo3_Hook_ContentPostProcAll->processNoCache';
				break;
		}
		unset($extConf);
	}
}