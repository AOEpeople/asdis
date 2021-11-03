<?php
namespace Aoe\Asdis\Tests\Domain\Model;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Server;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class AssetTest extends UnitTestCase
{
    /**
     * @var Asset
     */
    private $asset;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->asset = new Asset();
    }

    /**
     * @test
     */
    public function setAndGetOriginalPath()
    {
        $path = 'typo3temp/pics/foo-gif';
        $this->asset->setOriginalPath($path);
        $this->assertEquals($path, $this->asset->getOriginalPath());
    }

    /**
     * @test
     */
    public function setAndGetNormalizedPath()
    {
        $path = 'uploads/img/bar.png';
        $this->asset->setNormalizedPath($path);
        $this->assertEquals($path, $this->asset->getNormalizedPath());
    }

    /**
     * @test
     */
    public function getPregQuotedOriginalPath()
    {
        $path = 'uploads/images/baz.jpg';
        $this->asset->setOriginalPath($path);
        $this->assertEquals('~/?uploads/images/baz\.jpg~is', $this->asset->getPregQuotedOriginalPath());
    }

    /**
     * @test
     */
    public function getMaskedPregQuotedOriginalPath()
    {
        $path = 'uploads/images/baz.jpg';
        $this->asset->setOriginalPath($path);
        $this->asset->setMask('"');
        $this->assertEquals('~/?"uploads/images/baz\.jpg"~is', $this->asset->getMaskedPregQuotedOriginalPath());
    }

    /**
     * @test
     */
    public function setAndGetServer()
    {
        $server = new Server();
        $server->setIdentifier('media1');
        $this->asset->setServer($server);
        $this->assertEquals('media1', $this->asset->getServer()->getIdentifier());
    }

    /**
     * @test
     */
    public function setAndGetMask()
    {
        $this->asset->setMask('"');
        $this->assertEquals('"', $this->asset->getMask());
    }

    /**
     * @test
     */
    public function getUri()
    {
        $baseUri = 'http://www.foo.com/';
        $path = 'uploads/images/foo.jpg';

        $server = $this->getMockBuilder(Server::class)->setMethods(['getUri'])->getMock();
        $server->expects($this->once())->method('getUri')->will($this->returnValue($baseUri));

        $this->asset->setNormalizedPath($path);
        $this->asset->setServer($server);
        
        $this->assertEquals($baseUri . $path, $this->asset->getUri());
    }
}