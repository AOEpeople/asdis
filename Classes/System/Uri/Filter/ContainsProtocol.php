<?php
namespace Aoe\Asdis\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\FilterInterface;

/**
 * Filters paths that contain "http:" or "https:".
 */
class ContainsProtocol implements FilterInterface
{
    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths)
    {
        $filteredPaths = [];
        foreach($paths as $path) {
            if ($this->containsProtocol($path) || $this->containsProtocolMarker($path)) {
                continue;
            }
            $filteredPaths[] = $path;
        }
        return $filteredPaths;
    }

    /**
     * @param string $path
     * @return boolean
     */
    private function containsProtocol($path)
    {
        return (1 === preg_match('/^(http|https)\:/', $path));
    }

    /**
     * @param string $path
     * @return boolean
     */
    private function containsProtocolMarker($path)
    {
        return (1 === preg_match('/^(###HTTP###|###HTTP_S###)/', $path));
    }
}