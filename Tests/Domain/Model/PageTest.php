<?php

namespace Aoe\Asdis\Tests\Domain\Model;

use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class PageTest extends UnitTestCase
{
    private Page $page;

    protected function setUp(): void
    {
        $this->page = new Page();
    }

    /**
     * Tests Page->scrapeAssets()
     */
    public function testScrapeAssets()
    {
        $config = $this->getMockBuilder(Provider::class)->getMock();
        $config
            ->method('isReplacementEnabled')
            ->will($this->returnValue(false));

        $this->page->injectConfigurationProvider($config);

        $this->assertNull($this->page->scrapeAssets());
    }
}
