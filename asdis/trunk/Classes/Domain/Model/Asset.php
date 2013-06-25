<?php

/**
 * Represents an asset.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Asset {

	/**
	 * @var string
	 */
	private $relativePath;

	/**
	 * @var string
	 */
	private $originalPath;

	/**
	 * @var string
	 */
	private $normalizedPath;

	/**
	 * @var Tx_Asdis_Domain_Model_Server
	 */
	private $server;

	/**
	 * @return string
	 */
	public function getHash() {
		return md5($this->originalPath.$this->normalizedPath);
	}

	/**
	 * @param string $relativePath
	 */
	public function setRelativePath($relativePath) {
		$this->relativePath = $relativePath;
	}
	/**
	 * @return string
	 */
	public function getRelativePath() {
		return $this->relativePath;
	}
	/**
	 * @param string $originalPath
	 */
	public function setOriginalPath($originalPath) {
		$this->originalPath = $originalPath;
		$this->setNormalizedPath($originalPath);
	}
	/**
	 * @return string
	 */
	public function getOriginalPath() {
		return $this->originalPath;
	}

	public function setNormalizedPath($normalizedPath) {
		$this->normalizedPath = $normalizedPath;
	}

	/**
	 * @return string
	 */
	public function getPregQuotedOriginalPath() {
		return '~/?' . preg_quote($this->getOriginalPath()) . '~is';
	}

	function __toString() {
		return $this->relativePath.':'.$this->originalPath;
	}
	/**
	 * @param Tx_Asdis_Domain_Model_Server $server
	 */
	public function setServer(Tx_Asdis_Domain_Model_Server $server) {
		$this->server = $server;
	}
	/**
	 * @return Tx_Asdis_Domain_Model_Server
	 */
	public function getServer() {
		return $this->server;
	}

	/**
	 * @return string
	 */
	public function getUri() {
		$domain = '';
		if(isset($this->server)) {
			$domain = $this->server->getUri();
		}
		return $domain . $this->normalizedPath;
	}
}