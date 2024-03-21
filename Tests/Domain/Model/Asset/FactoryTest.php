<?php

namespace Aoe\Asdis\Tests\Domain\Model\Asset;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Aoe\Asdis\System\Uri\Filter\Chain;
use Aoe\Asdis\System\Uri\Filter\ChainFactory;
use Aoe\Asdis\System\Uri\Normalizer;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class FactoryTest extends UnitTestCase
{
    public function testCreateAssetsFromPaths(): void
    {
        $path = 'uploads/images/foo.jpg';
        $mask = '"';

        $assetFactory = $this->getMockBuilder(Factory::class)
            ->onlyMethods(['createAsset', 'createAssetCollection'])
            ->getMock();

        $assetFactory
            ->expects($this->once())
            ->method('createAssetCollection')
            ->willReturn(new Collection());

        $assetFactory
            ->expects($this->once())
            ->method('createAsset')
            ->willReturn(new Asset());

        $filterChainFactory = $this->getMockBuilder(ChainFactory::class)->onlyMethods(['buildChain'])->getMock();
        $filterChainFactory
            ->expects($this->once())
            ->method('buildChain')
            ->willReturn(new Chain());

        $assetFactory->injectFilterChainFactory($filterChainFactory);
        $assetFactory->injectUriNormalizer(new Normalizer());

        $assets = $assetFactory->createAssetsFromPaths([$path], [$mask]);

        $this->assertSame(1, $assets->count());
    }

    public function testCreateAssetsFromPathsAndFilter(): void
    {
        $paths = [
            'uploads/images/foo.jpg',
            'fileadmin/images/bar.jpg',
            'uploads/images/blub.jpg',
        ];
        $masks = ['"', "'", '"'];
        $filteredPaths = [
            'uploads/images/foo.jpg',
            'uploads/images/blub.jpg',
        ];

        $assetFactory = $this->getMockBuilder(Factory::class)
            ->onlyMethods(['createAsset', 'createAssetCollection'])
            ->getMock();

        $assetFactory
            ->expects($this->once())
            ->method('createAssetCollection')
            ->willReturn(new Collection());

        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAsset')
            ->willReturn(new Asset());

        $filterChain = $this->getMockBuilder(Chain::class)->onlyMethods(['filter'])->getMock();
        $filterChain->expects($this->once())
            ->method('filter')
            ->willReturn($filteredPaths);

        $filterChainFactory = $this->getMockBuilder(ChainFactory::class)->onlyMethods(['buildChain'])->getMock();
        $filterChainFactory
            ->expects($this->once())
            ->method('buildChain')
            ->willReturn($filterChain);

        $assetFactory->injectFilterChainFactory($filterChainFactory);
        $assetFactory->injectUriNormalizer(new Normalizer());

        $assets = $assetFactory->createAssetsFromPaths($paths, $masks);

        $this->assertSame(2, $assets->count());
    }
}
