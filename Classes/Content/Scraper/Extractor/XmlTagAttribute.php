<?php
namespace Aoe\Asdis\Content\Scraper\Extractor;

/**
 * Service which extracts paths from attributes in HTML tags.
 */
class XmlTagAttribute
{
    /**
     * Finds attributes in HTML tags.
     *
     * @param string $tagName The name of the tag. E.g. 'img'.
     * @param string $attributeName The attribute's name.
     * @param string $content The content to parse.
     * @param array  $requiredOtherAttributes An array of other attributes the
     *										tag must contain. This has to be
     *										an associative array where the key
     *										of an element is the attribute's
     *										name and the element's value is
     *										the attribute's value. This param
     *										is optional.
     * @return array
     */
    public function getAttributeFromTag($tagName, $attributeName, $content, array $requiredOtherAttributes = [])
    {
        $paths = [];
        $masks = [];
        $matches = [];
        $pattern = '';

        $pattern .= '~<';
        $pattern .= $tagName;
        $pattern .= '\b[^>]*\040\b';
        $pattern .= $attributeName;
        $pattern .= '\s?=\s?([\'"])(.*?)([\'"])[^>]*>~is';

        $count = preg_match_all($pattern, $content, $matches, PREG_PATTERN_ORDER);

        if ($count === false || $count === 0 || false === is_array($matches[2]) || sizeof($matches[2]) < 1) {
            return [
                'paths' => [],
                'masks' => []
            ];
        }

        if (sizeof($requiredOtherAttributes) < 1) {
            return [
                'paths' => $matches[2],
                'masks' => $matches[1]
            ];
        }

        foreach ($matches[2] as $mkey => $match) {
            $containsAllRequiredAttributes = true;
            foreach ($requiredOtherAttributes as $key => $attr) {
                $attrMatches = [];
                $attrPattern = '~' . preg_quote($key) . '=["\']' . preg_quote($attr) . '["\']~is';
                if (preg_match_all($attrPattern, $matches[0][$mkey], $attrMatches, PREG_PATTERN_ORDER) === 0) {
                    $containsAllRequiredAttributes = false;
                }
            }
            if ($containsAllRequiredAttributes) {
                $paths[] = $match;
                $masks[] = $matches[1][$mkey];
             }
        }

        return [
            'paths' => $paths,
            'masks' => $masks
        ];
    }
}