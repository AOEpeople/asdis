<?php
namespace Aoe\Asdis\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\FilterInterface;

/**
 * Filters paths which are too short.
 */
class TooShort implements FilterInterface
{
    /**
     * @var integer
     */
    const MIN_LENGTH = 5;

    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths)
    {
        $filteredPaths = array();
        foreach ($paths as $path) {
            if (strlen($path) < self::MIN_LENGTH) {
                continue;
            }
            $filteredPaths[] = $path;
        }
        return $filteredPaths;
    }
}