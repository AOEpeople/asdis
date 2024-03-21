<?php

namespace Aoe\Asdis\Tests\Content\Scraper;

use Aoe\Asdis\Content\Scraper\Chain;
use Aoe\Asdis\Content\Scraper\Html\Image;
use Aoe\Asdis\Content\Scraper\Html\Script;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ChainTest extends UnitTestCase
{
    public function testAppend(): void
    {
        $chain = new Chain();
        $scraper1 = $this->getMockBuilder(Image::class)
            ->disableOriginalConstructor()
            ->getMock();
        $scraper2 = $this->getMockBuilder(Script::class)
            ->disableOriginalConstructor()
            ->getMock();

        $chain->append($scraper1);
        $chain->append($scraper2);

        $this->assertSame(2, $chain->count());
    }

    public function testScrape(): void
    {
        $chain = new Chain();
        $scraper1 = $this->getMockBuilder(Image::class)
            ->disableOriginalConstructor()
            ->getMock();
        $scraper2 = $this->getMockBuilder(Script::class)
            ->disableOriginalConstructor()
            ->getMock();

        $scraper1->expects($this->once())
            ->method('scrape')
            ->willReturn(new Collection());
        $scraper2->expects($this->once())
            ->method('scrape')
            ->willReturn(new Collection());

        $chain->append($scraper1);
        $chain->append($scraper2);
        $chain->scrape('FOO');
    }
}
