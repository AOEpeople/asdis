<?php

namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\Chain;
use Aoe\Asdis\System\Uri\Filter\ContainsProtocol;
use Aoe\Asdis\System\Uri\Filter\WildcardProtocol;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ChainTest extends UnitTestCase
{
    private Chain $chain;

    protected function setUp(): void
    {
        parent::setUp();

        $this->chain = new Chain();
    }

    public function testFilter(): void
    {
        $filter1 = $this->getMockBuilder(ContainsProtocol::class)->getMock();
        $filter2 = $this->getMockBuilder(WildcardProtocol::class)->getMock();

        $filter1->expects($this->once())
            ->method('filter')
            ->willReturn(['/foo']);
        $filter2->expects($this->once())
            ->method('filter');

        $this->chain->append($filter1);
        $this->chain->append($filter2);
        $this->chain->filter(['/foo']);
    }
}
