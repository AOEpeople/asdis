<?php
namespace Aoe\Asdis\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\FilterInterface;

/**
 * Filters paths that start with "data:".
 */
class ContainsInlineData implements FilterInterface
{
    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths)
    {
        $filteredPaths = [];
        foreach ($paths as $path) {
            if (0 === strpos($path, 'data:')) {
                continue;
            }
            $filteredPaths[] = $path;
        }
        return $filteredPaths;
    }
}