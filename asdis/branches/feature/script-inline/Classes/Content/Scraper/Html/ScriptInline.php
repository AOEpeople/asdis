<?php

/**
 * Scrapes assets from inline CSS.
 *
 * @package    Tx_Asdis
 * @subpackage Content_Scraper_Html
 * @author     Kevin Schu <kevin.schu@aoe.com>
 */
class Tx_Asdis_Content_Scraper_Html_ScriptInline implements Tx_Asdis_Content_Scraper_ScraperInterface {
	/**
	 * @var string
	 */
	const ASSET_FILE_EXTENSIONS = 'js|css|png|jpg|jpeg|bmp|gif';

	/**
	 * @var Tx_Asdis_Domain_Model_Asset_Factory
	 */
	private $assetFactory;

	/**
	 * @param Tx_Asdis_Domain_Model_Asset_Factory $assetFactory
	 */
	public function injectAssetFactory(Tx_Asdis_Domain_Model_Asset_Factory $assetFactory) {
		$this->assetFactory = $assetFactory;
	}

	/**
	 * @param string $content
	 *
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		$collection = new Tx_Asdis_Domain_Model_Asset_Collection();
		$matches = array();
		$blocks = $this->getScriptBlocksFromMarkup($content);
		foreach ($blocks as $block) {
			$pattern = '~([\'"])(/[\w\~,;\-\./?%&+#=]*\.(' . self::ASSET_FILE_EXTENSIONS . '))([\'"])~is';
			preg_match_all(
				$pattern,
				$block,
				$matches
			);
			if (FALSE === is_array($matches) || sizeof($matches) < 1 || FALSE === is_array($matches[2])) {
				continue;
			}
			$collection->merge($this->assetFactory->createAssetsFromPaths(
				$matches[2],
				$matches[1]
			));
		}
		return $collection;
	}

	/**
	 * Returns the inner content of all <style></style> blocks of the given markup as an array.
	 *
	 * @param string $content
	 *
	 * @return array
	 */
	private function getScriptBlocksFromMarkup($content) {

		$blocks = array();
		$matches = array();

		preg_match_all(
			'~<script[^>]*>(.*?)</script>~is',
			$content,
			$matches,
			PREG_PATTERN_ORDER
		);

		if (is_array($matches) && sizeof($matches) > 1
			&& is_array(
				$matches[1]
			)
		) {
			$blocks = $matches[1];
		}

		return $blocks;
	}
}