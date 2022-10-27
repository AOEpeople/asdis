<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\InputImage;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class InputImageTest extends UnitTestCase
{
    public function testScrape()
    {
        $content = '<input type="image" src="uploads/images/foo.gif" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with(['uploads/images/foo.gif']);

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->once())
            ->method('getAttributeFromTag')
            ->with('input', 'src', $content, ['type' => 'image'])
            ->will($this->returnValue(
                [
                    'paths' => ['uploads/images/foo.gif'],
                    'masks' => ['"'],
                ]
            ));

        $scraper = GeneralUtility::makeInstance(InputImage::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
