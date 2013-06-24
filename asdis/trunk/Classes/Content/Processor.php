<?php

class Tx_Asdis_Content_Processor {

	/**
	 * @var Tx_Asdis_Content_Scraper_ChainFactory
	 */
	private $scraperChainFactory;

	/**
	 * @var Tx_Asdis_System_Log_Logger
	 */
	private $logger;

	/**
	 * @param Tx_Asdis_Content_Scraper_ChainFactory $scraperChainFactory
	 */
	public function injectScraperChainFactory(Tx_Asdis_Content_Scraper_ChainFactory $scraperChainFactory) {
		$this->scraperChainFactory = $scraperChainFactory;
	}

	/**
	 * @param Tx_Asdis_System_Log_Logger $logger
	 */
	public function injectLogger(Tx_Asdis_System_Log_Logger $logger) {
		$this->logger = $logger;
	}

	public function scrapeAssets(Tx_Asdis_Domain_Model_Page $page) {

	}



	/**
	 * @param tslib_fe $pObj
	 */
	/*public function replaceAssets(tslib_fe $pObj) {

		// check if is enabled
		// @todo

		// check if is html page
		if(FALSE === $this->isHtmlDocument($pObj)) {
			//return;
		}

		$assets = $this->scraperChainFactory->buildChain()->scrape($pObj->content);
		// @todo remove assets which point to different domains
		// @todo remove assets which should be excluded by regex


		// @todo enrich remaining assets with subdomains provided by domain provider which is using a specific distribution strategy for the current page
		$this->distributionProvider->distribute($assets);

		// @todo replace

		//var_dump($assets); die('DDD');
		$this->logger->log(get_class($this), 'done');
		$pObj->content = $this->replace($pObj->content, $assets);
	}*/

	/**
	 * @param string $content
	 * @param Tx_Asdis_Domain_Model_Asset_Collection $assets
	 * @return string
	 */
	private function replace($content, Tx_Asdis_Domain_Model_Asset_Collection $assets) {
		$sourcePaths = array();
		$targetPaths = array();
		foreach($assets as $asset) {
			/** @var Tx_Asdis_Domain_Model_Asset $asset */
			//$sourcePaths[] = '~(' . preg_quote($pObj->baseUrl) . ')?(' . preg_quote($cloudBaseUrl) . ')?/?' . preg_quote($resource->getPath()) . '~is';
			$sourcePaths[] = '~' . preg_quote($asset->getOriginalPath()) . '~is';
			$targetPaths[] = $asset->getRelativePath();
		}
		return preg_replace($sourcePaths, $targetPaths, $content);
	}

	/**
	 * Checks if the given content is valid (X)HTML.
	 *
	 * @param string $content
	 * @return boolean
	 */
	public function isHtmlDocument($content) {
		return preg_match('~<html.*?-->~is', $content) ? TRUE : FALSE;
	}
}