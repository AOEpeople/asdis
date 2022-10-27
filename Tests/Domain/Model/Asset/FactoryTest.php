<?php

namespace Aoe\Asdis\Tests\Domain\Model\Asset;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Aoe\Asdis\System\Uri\Filter\Chain;
use Aoe\Asdis\System\Uri\Filter\ChainFactory;
use Aoe\Asdis\System\Uri\Normalizer;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class FactoryTest extends UnitTestCase
{
    public function testCreateAssetsFromPaths()
    {
        $path = 'uploads/images/foo.jpg';
        $mask = '"';

        $assetFactory = $this->getMockBuilder(Factory::class)
            ->setMethods(['createAsset', 'createAssetCollection'])
            ->getMock();

        $assetFactory
            ->expects($this->once())
            ->method('createAssetCollection')
            ->will($this->returnValue(new Collection()));

        $assetFactory
            ->expects($this->once())
            ->method('createAsset')
            ->will($this->returnValue(new Asset()));

        $filterChainFactory = $this->getMockBuilder(ChainFactory::class)->setMethods(['buildChain'])->getMock();
        $filterChainFactory
            ->expects($this->once())
            ->method('buildChain')
            ->will($this->returnValue(new Chain()));

        $assetFactory->injectFilterChainFactory($filterChainFactory);
        $assetFactory->injectUriNormalizer(new Normalizer());

        $assets = $assetFactory->createAssetsFromPaths([$path], [$mask]);

        $this->assertSame(1, $assets->count());
    }

    public function testCreateAssetsFromPathsAndFilter()
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
            ->setMethods(['createAsset', 'createAssetCollection'])
            ->getMock();

        $assetFactory
            ->expects($this->once())
            ->method('createAssetCollection')
            ->will($this->returnValue(new Collection()));

        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAsset')
            ->will($this->returnValue(new Asset()));

        $filterChain = $this->getMockBuilder(Chain::class)->setMethods(['filter'])->getMock();
        $filterChain->expects($this->once())
            ->method('filter')
            ->will($this->returnValue($filteredPaths));

        $filterChainFactory = $this->getMockBuilder(ChainFactory::class)->setMethods(['buildChain'])->getMock();
        $filterChainFactory
            ->expects($this->once())
            ->method('buildChain')
            ->will($this->returnValue($filterChain));

        $assetFactory->injectFilterChainFactory($filterChainFactory);
        $assetFactory->injectUriNormalizer(new Normalizer());

        $assets = $assetFactory->createAssetsFromPaths($paths, $masks);

        $this->assertSame(2, $assets->count());
    }
}
