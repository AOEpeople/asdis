<?php

namespace Aoe\Asdis\Tests\Content\Scraper;

use Aoe\Asdis\Content\Scraper\Chain;
use Aoe\Asdis\Content\Scraper\Html\Image;
use Aoe\Asdis\Content\Scraper\Html\Script;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ChainTest extends UnitTestCase
{
    public function testAppend()
    {
        $chain = new Chain();
        $scraper1 = new Image();
        $scraper2 = new Script();

        $chain->append($scraper1);
        $chain->append($scraper2);

        $this->assertSame(2, $chain->count());
    }

    public function testScrape()
    {
        $chain = new Chain();
        $scraper1 = $this->getMockBuilder(Image::class)->getMock();
        $scraper2 = $this->getMockBuilder(Script::class)->getMock();

        $scraper1->expects($this->once())
            ->method('scrape')
            ->will($this->returnValue(new Collection()));
        $scraper2->expects($this->once())
            ->method('scrape')
            ->will($this->returnValue(new Collection()));

        $chain->append($scraper1);
        $chain->append($scraper2);
        $chain->scrape('FOO');
    }
}
