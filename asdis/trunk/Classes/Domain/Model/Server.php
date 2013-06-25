<?php

/**
 * Represents a server.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Server {

	/**
	 * @var string
	 */
	const PROTOCOL_HTTP = 'http';

	/**
	 * @var string
	 */
	const PROTOCOL_HTTPS = 'https';

	/**
	 * @var string
	 */
	private $domain;

	/**
	 * @var string
	 */
	private $protocol;

	/**
	 * @var string
	 */
	private $identifier;

	/**
	 * @param string $domain
	 */
	public function setDomain($domain) {
		$this->domain = $domain;
	}

	/**
	 * @return string
	 */
	public function getDomain() {
		return $this->domain;
	}

	/**
	 * @param string $identifier
	 */
	public function setIdentifier($identifier) {
		$this->identifier = $identifier;
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {
		return $this->identifier;
	}

	/**
	 * @param string $protocol
	 */
	public function setProtocol($protocol) {
		$this->protocol = $protocol;
	}

	/**
	 * @return string
	 */
	public function getProtocol() {
		return $this->protocol;
	}

	/**
	 * @return string
	 */
	public function getUri() {
		return $this->protocol . '://' . $this->domain . '/';
	}
}