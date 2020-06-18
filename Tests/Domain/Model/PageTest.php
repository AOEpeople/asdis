<?php
namespace Aoe\Asdis\Tests\Domain\Model;

use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\System\Configuration\Provider;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class PageTest extends UnitTestCase
{
    /**
     * @var Page
     */
    private $page;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->page = new Page();

    }

    /**
     * Tests Page->scrapeAssets()
     * @test
     */
    public function scrapeAssets()
    {
        $config = $this->getMockBuilder(Provider::class)->getMock();
        $config->expects($this->any())->method('isReplacementEnabled')->will($this->returnValue(false));

        $this->page->injectConfigurationProvider($config);

        $this->assertNull($this->page->scrapeAssets());
    }
}

