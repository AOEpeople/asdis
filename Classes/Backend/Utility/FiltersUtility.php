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

class FiltersUtility
{
    /**
     * Registers filters
     *
     * @param $extensionPath string
     *
     * @return void
     */
    public static function registerFilters($extensionPath)
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = [
            'key'   => 'bubblingPath',
            'class' => '\Aoe\Asdis\System\Uri\Filter\BubblingPath',
            'file'  => $extensionPath . 'Classes/System/Uri/Filter/BubblingPath.php'
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = [
            'key'   => 'containsInlineData',
            'class' => '\Aoe\Asdis\System\Uri\Filter\ContainsInlineData',
            'file'  => $extensionPath . 'Classes/System/Uri/Filter/ContainsInlineData.php'
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = [
            'key'   => 'containsProtocol',
            'class' => '\Aoe\Asdis\System\Uri\Filter\ContainsProtocol',
            'file'  => $extensionPath . 'Classes/System/Uri/Filter/ContainsProtocol.php'
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = [
            'key'   => 'tooShort',
            'class' => '\Aoe\Asdis\System\Uri\Filter\TooShort',
            'file'  => $extensionPath . 'Classes/System/Uri/Filter/TooShort.php'
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = [
            'key'   => 'wildcardProtocol',
            'class' => '\Aoe\Asdis\System\Uri\Filter\WildcardProtocol',
            'file'  => $extensionPath . 'Classes/System/Uri/Filter/WildcardProtocol.php'
        ];

        // Register distribution algorithms
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['distributionAlgorithms'][] = [
            'key'   => 'hashBasedGroups',
            'class' => '\Aoe\Asdis\Domain\Model\DistributionAlgorithm_HashBasedGroups',
            'file'  => $extensionPath . 'Classes/Domain/Model/DistributionAlgorithm/HashBasedGroups.php'
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['distributionAlgorithms'][] = [
            'key'   => 'roundRobin',
            'class' => '\Aoe\Asdis\Domain\Model\DistributionAlgorithm_RoundRobin',
            'file'  => $extensionPath . 'Classes/Domain/Model/DistributionAlgorithm/RoundRobin.php'
        ];

    }
}