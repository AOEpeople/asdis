<?php

namespace Aoe\Asdis\Tests\Domain\Model;

use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class PageTest extends UnitTestCase
{
    /**
     * Tests Page->scrapeAssets()
     */
    public function testScrapeAssets()
    {
        $config = $this->getMockBuilder(Provider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $config
            ->method('isReplacementEnabled')
            ->will($this->returnValue(false));

        $page = new Page($config);

        $this->assertNull($page->scrapeAssets());
    }
}
