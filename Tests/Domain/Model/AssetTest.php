<?php

namespace Aoe\Asdis\Tests\Domain\Model;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Server;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class AssetTest extends UnitTestCase
{
    private Asset $asset;

    protected function setUp(): void
    {
        $this->asset = new Asset();
    }

    public function testSetAndGetOriginalPath(): void
    {
        $path = 'typo3temp/pics/foo-gif';
        $this->asset->setOriginalPath($path);
        $this->assertSame($path, $this->asset->getOriginalPath());
    }

    public function testSetAndGetNormalizedPath(): void
    {
        $path = 'uploads/img/bar.png';
        $this->asset->setNormalizedPath($path);
        $this->assertSame($path, $this->asset->getNormalizedPath());
    }

    public function testGetPregQuotedOriginalPath(): void
    {
        $path = 'uploads/images/baz.jpg';
        $this->asset->setOriginalPath($path);
        $this->assertSame('~/?uploads/images/baz\.jpg~is', $this->asset->getPregQuotedOriginalPath());
    }

    public function testGetMaskedPregQuotedOriginalPath(): void
    {
        $path = 'uploads/images/baz.jpg';
        $this->asset->setOriginalPath($path);
        $this->asset->setMask('"');
        $this->assertSame('~/?"uploads/images/baz\.jpg"~is', $this->asset->getMaskedPregQuotedOriginalPath());
    }

    public function testSetAndGetServer(): void
    {
        $server = new Server();
        $server->setIdentifier('media1');

        $this->asset->setServer($server);
        $this->assertSame('media1', $this->asset->getServer()->getIdentifier());
    }

    public function testSetAndGetMask(): void
    {
        $this->asset->setMask('"');
        $this->assertSame('"', $this->asset->getMask());
    }

    public function testGetUri(): void
    {
        $baseUri = 'http://www.foo.com/';
        $path = 'uploads/images/foo.jpg';

        $server = $this->getMockBuilder(Server::class)->onlyMethods(['getUri'])->getMock();
        $server->expects($this->once())
            ->method('getUri')
            ->willReturn($baseUri);

        $this->asset->setNormalizedPath($path);
        $this->asset->setServer($server);

        $this->assertSame($baseUri . $path, $this->asset->getUri());
    }
}
