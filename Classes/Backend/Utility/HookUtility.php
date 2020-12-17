<?php
namespace Aoe\Asdis\Backend\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2020 AOE GmbH <dev@aoe.com>
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

class HookUtility
{
    /**
     * Register hooks
     *
     * @return void
     */
    public static function registerHooks()
    {
        $extConf = self::useCompatibility8() ? unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['asdis']) : self::getConfiguration();
        switch ($extConf['hook']) {
            case 'contentPostProc-all':
                $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = \Aoe\Asdis\Typo3\Hook\ContentPostProcAll::class . '->process';
                break;
            case 'contentPostProc-output':
                $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = \Aoe\Asdis\Typo3\Hook\ContentPostProcAll::class .'->process';
                break;
            case 'contentPostProc-all_and_output':
                $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = \Aoe\Asdis\Typo3\Hook\ContentPostProcAll::class .'->processCache';
                $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = \Aoe\Asdis\Typo3\Hook\ContentPostProcAll::class .'->processNoCache';
                break;
        }
        unset($extConf);
    }

    /**
     * Check if version is < 8.7.99
     * 
     * @return bool
     */
    private static function useCompatibility8()
    {
        return version_compare(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getCurrentTypo3Version(), '9.5.0', '<');
    }

    /**
     * Get asdis extension configuration
     * 
     * @return bool
     */
    private static function getConfiguration()
    {
        return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)
        ->get('asdis');
    }
}