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
 * Class Tx_Asdis_Backend_Utility_FiltersUtility
 */
class Tx_Asdis_Backend_Utility_FiltersUtility {

	/**
	 * Registers filters
	 *
	 * @param $extensionPath string
	 *
	 * @return void
	 */
	public static function registerFilters($extensionPath) {
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = array(
			'key'   => 'bubblingPath',
			'class' => 'Tx_Asdis_System_Uri_Filter_BubblingPath',
			'file'  => $extensionPath . 'Classes/System/Uri/Filter/BubblingPath.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = array(
			'key'   => 'containsInlineData',
			'class' => 'Tx_Asdis_System_Uri_Filter_ContainsInlineData',
			'file'  => $extensionPath . 'Classes/System/Uri/Filter/ContainsInlineData.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = array(
			'key'   => 'containsProtocol',
			'class' => 'Tx_Asdis_System_Uri_Filter_ContainsProtocol',
			'file'  => $extensionPath . 'Classes/System/Uri/Filter/ContainsProtocol.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = array(
			'key'   => 'tooShort',
			'class' => 'Tx_Asdis_System_Uri_Filter_TooShort',
			'file'  => $extensionPath . 'Classes/System/Uri/Filter/TooShort.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'][] = array(
			'key'   => 'wildcardProtocol',
			'class' => 'Tx_Asdis_System_Uri_Filter_WildcardProtocol',
			'file'  => $extensionPath . 'Classes/System/Uri/Filter/WildcardProtocol.php'
		);

		// Register distribution algorithms
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['distributionAlgorithms'][] = array(
			'key'   => 'hashBasedGroups',
			'class' => 'Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups',
			'file'  => $extensionPath . 'Classes/Domain/Model/DistributionAlgorithm/HashBasedGroups.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['distributionAlgorithms'][] = array(
			'key'   => 'roundRobin',
			'class' => 'Tx_Asdis_Domain_Model_DistributionAlgorithm_RoundRobin',
			'file'  => $extensionPath . 'Classes/Domain/Model/DistributionAlgorithm/RoundRobin.php'
		);

	}
}