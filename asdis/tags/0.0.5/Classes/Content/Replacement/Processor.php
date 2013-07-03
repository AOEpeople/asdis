<?php

/**
 * Replaces content.
 *
 * @package Tx_Asdis
 * @subpackage Content_Replacement
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Replacement_Processor {

	/**
	 * @param Tx_Asdis_Content_Replacement_Map $replacementMap
	 * @param string $content
	 * @return string
	 */
	public function replace(Tx_Asdis_Content_Replacement_Map $replacementMap, $content) {
		$result = preg_replace(
			$replacementMap->getSources(),
			$replacementMap->getTargets(),
			$content
		);
		if(NULL === $result) {
			return $content;
		}
		return $result;
	}
}