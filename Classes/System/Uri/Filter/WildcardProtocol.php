<?php
namespace Aoe\Asdis\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\FilterInterface;

/**
 * Filters paths that start with "//".
 */
class WildcardProtocol implements FilterInterface
{
    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths)
    {
        $filteredPaths = array();
        foreach ($paths as $path) {
            if (strpos($path, '//') === 0) {
                continue;
            }
            $filteredPaths[] = $path;
        }
        return $filteredPaths;
    }
}