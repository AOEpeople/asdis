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
 * Class Tx_Asdis_Backend_Utility_ScraperUtility
 */
class Tx_Asdis_Backend_Utility_ScraperUtility {

	/**
	 * Register Scraper
	 *
	 * @param $extensionPath string
	 *
	 * @return void
	 */
	public static function registerScrapers($extensionPath) {
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'cssUrl',
			'class' => 'Tx_Asdis_Content_Scraper_Css_Url',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Css/Url.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlCssFile',
			'class' => 'Tx_Asdis_Content_Scraper_Html_CssFile',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/CssFile.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlAppleTouchIcon',
			'class' => 'Tx_Asdis_Content_Scraper_Html_AppleTouchIcon',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/AppleTouchIcon.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlCssAttribute',
			'class' => 'Tx_Asdis_Content_Scraper_Html_CssAttribute',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/CssAttribute.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlCssInline',
			'class' => 'Tx_Asdis_Content_Scraper_Html_CssInline',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/CssInline.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlEmbed',
			'class' => 'Tx_Asdis_Content_Scraper_Html_Embed',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/Embed.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlFavicon',
			'class' => 'Tx_Asdis_Content_Scraper_Html_Favicon',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/Favicon.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlImage',
			'class' => 'Tx_Asdis_Content_Scraper_Html_Image',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/Image.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlInputImage',
			'class' => 'Tx_Asdis_Content_Scraper_Html_InputImage',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/InputImage.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlOpenGraphImage',
			'class' => 'Tx_Asdis_Content_Scraper_Html_OpenGraphImage',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/OpenGraphImage.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlScript',
			'class' => 'Tx_Asdis_Content_Scraper_Html_Script',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/Script.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlCss3Image',
			'class' => 'Tx_Asdis_Content_Scraper_Html_Css3Image',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/Css3Image.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlMetaMsApplication',
			'class' => 'Tx_Asdis_Content_Scraper_Html_MetaMsApplication',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/MetaMsApplication.php'
		);
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = array(
			'key'   => 'htmlDataSrc',
			'class' => 'Tx_Asdis_Content_Scraper_Html_DataSrc',
			'file'  => $extensionPath . 'Classes/Content/Scraper/Html/DataSrc.php'
		);
	}
}