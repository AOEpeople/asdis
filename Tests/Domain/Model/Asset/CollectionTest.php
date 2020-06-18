<?php
namespace Aoe\Asdis\Tests\Domain\Model\Asset;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class CollectionTest extends UnitTestCase
{
    /**
     * @test
     */
    public function append()
    {
        $collection = new Collection();
        $asset = new Asset();

        $collection->append($asset);

        $this->assertEquals(1, $collection->count());
    }

    /**
     * @test
     */
    public function appendWithSameOriginalPath()
    {
        $collection = new Collection();
        $asset1 = new Asset();
        $asset2 = new Asset();
        $path = 'uploads/pics/foo.jpg';

        $asset1->setOriginalPath($path);
        $asset2->setOriginalPath($path);

        $collection->append($asset1);
        $collection->append($asset2);

        $this->assertEquals(1, $collection->count());
    }

    /**
     * @test
     */
    public function merge()
    {
        $collection1 = new Collection();
        $collection2 = new Collection();
        $asset1 = new Asset();
        $asset2 = new Asset();
        $asset3 = new Asset();
        $path1 = 'typo3temp/pics/foo.gif';
        $path2 = 'typo3temp/pics/bar.jpg';
        $path3 = 'typo3temp/pics/hund.png';

        $asset1->setOriginalPath($path1);
        $asset2->setOriginalPath($path2);
        $asset3->setOriginalPath($path3);

        $collection1->append($asset1);
        $collection2->append($asset2);
        $collection2->append($asset3);
        $collection1->merge($collection2);

        $this->assertEquals(3, $collection1->count());
        $this->assertEquals(2, $collection2->count());
    }

    /**
     * @test
     */
    public function getReplacementMap()
    {
        $collection = new Collection();
        $asset1 = new Asset();
        $asset2 = new Asset();
        $path1 = 'typo3temp/pics/foo.gif';
        $path2 = 'typo3temp/pics/bar.jpg';

        $asset1->setOriginalPath($path1);
        $asset1->setNormalizedPath($path1);
        $asset2->setOriginalPath($path2);
        $asset2->setNormalizedPath($path2);

        $collection->append($asset1);
        $collection->append($asset2);

        $map = $collection->getReplacementMap();

        $this->assertEquals(2, sizeof($map->getSources()));
        $this->assertEquals(2, sizeof($map->getTargets()));
    }
}

