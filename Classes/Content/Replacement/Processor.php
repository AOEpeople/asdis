<?php

namespace Aoe\Asdis\Content\Replacement;

/**
 * Replaces content.
 */
class Processor
{
    public function replace(Map $replacementMap, string $content): string
    {
        $result = preg_replace(
            $replacementMap->getSources(),
            $replacementMap->getTargets(),
            $content
        );
        if ($result === null) {
            return $content;
        }
        return $result;
    }
}
