<?php
namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\Chain;
use Aoe\Asdis\System\Uri\Filter\ContainsProtocol;
use Aoe\Asdis\System\Uri\Filter\WildcardProtocol;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ChainTest extends UnitTestCase
{
    /**
     * @var Chain
     */
    private $chain;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->chain = new Chain();
    }

    /**
     * @test
     */
    public function filter()
    {
        $filter1 = $this->getMockBuilder(ContainsProtocol::class)->getMock();
        $filter2 = $this->getMockBuilder(WildcardProtocol::class)->getMock();

        $filter1->expects($this->once())->method('filter')->will($this->returnValue(['/foo']));
        $filter2->expects($this->once())->method('filter');

        $this->chain->append($filter1);
        $this->chain->append($filter2);
        $this->chain->filter(['/foo']);
    }
}