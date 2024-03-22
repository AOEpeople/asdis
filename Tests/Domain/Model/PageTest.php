<?php

namespace Aoe\Asdis\Tests\Domain\Model;

use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class PageTest extends UnitTestCase
{
    /**
     * Tests Page->scrapeAssets()
     */
    public function testScrapeAssets(): void
    {
        $config = $this->getMockBuilder(Provider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $config
            ->method('isReplacementEnabled')
            ->willReturn(false);

        $page = new Page($config);

        $this->assertNull($page->scrapeAssets());
    }
}
