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

class ScraperUtility
{
    /**
     * Register Scraper
     *
     * @param string $extensionPath
     */
    public static function registerScrapers($extensionPath)
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'cssUrl',
            'class' => 'Aoe\Asdis\Content\Scraper\Css\Url',
            'file' => $extensionPath . 'Classes/Content/Scraper/Css/Url.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlCssFile',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\CssFile',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/CssFile.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlAppleTouchIcon',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\AppleTouchIcon',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/AppleTouchIcon.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlCssAttribute',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\CssAttribute',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/CssAttribute.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlCssInline',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\CssInline',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/CssInline.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlEmbed',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\Embed',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Embed.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlFavicon',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\Favicon',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Favicon.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlImage',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\Image',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Image.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlInputImage',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\InputImage',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/InputImage.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlOpenGraphImage',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\OpenGraphImage',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/OpenGraphImage.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlScript',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\Script',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Script.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlCss3Image',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\Css3Image',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Css3Image.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlMetaMsApplication',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\MetaMsApplication',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/MetaMsApplication.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlDataSrc',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\DataSrc',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/DataSrc.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlSrcset',
            'class' => 'Aoe\Asdis\Content\Scraper\Html\Srcset',
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Srcset.php',
        ];
    }
}
