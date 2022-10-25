<?php

namespace Aoe\Asdis\System\Uri\Filter;

/**
 * Filters paths that contain "http:" or "https:".
 */
class ContainsProtocol implements FilterInterface
{
    /**
     * @param array $paths Array of paths.
     * @return array Valid paths.
     */
    public function filter(array $paths): array
    {
        $filteredPaths = [];
        foreach ($paths as $path) {
            if ($this->containsProtocol($path) || $this->containsProtocolMarker($path)) {
                continue;
            }
            $filteredPaths[] = $path;
        }
        return $filteredPaths;
    }

    private function containsProtocol(string $path): bool
    {
        return preg_match('/^(http|https)\:/', $path) === 1;
    }

    private function containsProtocolMarker(string $path): bool
    {
        return preg_match('/^(###HTTP###|###HTTP_S###)/', $path) === 1;
    }
}
