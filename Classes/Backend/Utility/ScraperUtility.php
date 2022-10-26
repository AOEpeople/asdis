<?php

namespace Aoe\Asdis\Backend\Utility;

use Aoe\Asdis\Content\Scraper\Css\Url;
use Aoe\Asdis\Content\Scraper\Html\AppleTouchIcon;
use Aoe\Asdis\Content\Scraper\Html\Css3Image;
use Aoe\Asdis\Content\Scraper\Html\CssAttribute;
use Aoe\Asdis\Content\Scraper\Html\CssFile;
use Aoe\Asdis\Content\Scraper\Html\CssInline;
use Aoe\Asdis\Content\Scraper\Html\DataSrc;
use Aoe\Asdis\Content\Scraper\Html\Embed;
use Aoe\Asdis\Content\Scraper\Html\Favicon;
use Aoe\Asdis\Content\Scraper\Html\Image;
use Aoe\Asdis\Content\Scraper\Html\InputImage;
use Aoe\Asdis\Content\Scraper\Html\MetaMsApplication;
use Aoe\Asdis\Content\Scraper\Html\OpenGraphImage;
use Aoe\Asdis\Content\Scraper\Html\Script;
use Aoe\Asdis\Content\Scraper\Html\Srcset;

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
     */
    public static function registerScrapers(string $extensionPath): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'cssUrl',
            'class' => Url::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Css/Url.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlCssFile',
            'class' => CssFile::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/CssFile.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlAppleTouchIcon',
            'class' => AppleTouchIcon::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/AppleTouchIcon.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlCssAttribute',
            'class' => CssAttribute::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/CssAttribute.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlCssInline',
            'class' => CssInline::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/CssInline.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlEmbed',
            'class' => Embed::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Embed.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlFavicon',
            'class' => Favicon::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Favicon.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlImage',
            'class' => Image::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Image.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlInputImage',
            'class' => InputImage::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/InputImage.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlOpenGraphImage',
            'class' => OpenGraphImage::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/OpenGraphImage.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlScript',
            'class' => Script::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Script.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlCss3Image',
            'class' => Css3Image::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Css3Image.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlMetaMsApplication',
            'class' => MetaMsApplication::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/MetaMsApplication.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlDataSrc',
            'class' => DataSrc::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/DataSrc.php',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'][] = [
            'key' => 'htmlSrcset',
            'class' => Srcset::class,
            'file' => $extensionPath . 'Classes/Content/Scraper/Html/Srcset.php',
        ];
    }
}
