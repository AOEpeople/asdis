<?php

class Tx_Asdis_Content_Scraper_Service_MarkupExtractor {

	/**
	 * Finds attributes in HTML tags.
	 *
	 * @param string $tagName The name of the tag. E.g. 'img'.
	 * @param string $attributeName The attribute's name.
	 * @param string $content The content to parse.
	 * @param array  $requiredOtherAttributes An array of other attributes the
	 *                                        tag must contain. This has to be
	 *                                        an associative array where the key
	 *                                        of an element is the attribute's
	 *                                        name and the element's value is
	 *                                        the attribute's value. This param
	 *                                        is optional.
	 * @return array
	 */
	public function getAttributeFromTag($tagName, $attributeName, $content, array $requiredOtherAttributes = array()) {

		$paths   = array();
		$matches = array();
		$count   = 0;
		$pattern = '';

		$pattern .= '~<';
		$pattern .= $tagName;
		$pattern .= '\b[^>]+\b';
		$pattern .= $attributeName;
		$pattern .= '\s?=\s?[\'"](.*?)[\'"][^>]*>~is';

		$count = preg_match_all($pattern, $content, $matches, PREG_PATTERN_ORDER);

		if ($count > 0 && is_array($matches[1]) && sizeof($matches[1]) > 0) {
			if (sizeof($requiredOtherAttributes) > 0) {
				foreach ($matches[1] as $mkey => $match) {
					$containsAllRequiredAttributes = TRUE;
					foreach ($requiredOtherAttributes as $key => $attr) {
						$attrMatches = array();
						$attrPattern = '~' . preg_quote($key) . '=["\']' . preg_quote($attr) . '["\']~is';
						if (preg_match_all($attrPattern, $matches[0][$mkey], $attrMatches, PREG_PATTERN_ORDER) === 0) {
							$containsAllRequiredAttributes = FALSE;
						}
					}
					if ($containsAllRequiredAttributes) {
						$paths[] = $match;
					}
				}
			} else {
				$paths = $matches[1];
			}
		}

		return $paths;
	}
}