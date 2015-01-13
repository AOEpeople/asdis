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
	const PROTOCOL_WILDCARD = 'wildcard';

	/**
	 * @var string
	 */
	const PROTOCOL_MARKER = 'marker';

	/**
	 * @var string
	 */
	const PROTOCOL_DYNAMIC = 'dynamic';

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
	 * @var string
	 */
	private $protocolMarker;

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
		if(FALSE === in_array($protocol, array(self::PROTOCOL_WILDCARD, self::PROTOCOL_MARKER, self::PROTOCOL_HTTP, self::PROTOCOL_HTTPS, self::PROTOCOL_DYNAMIC))) {
			return;
		}
		$this->protocol = $protocol;
	}

	/**
	 * @return string
	 */
	public function getProtocol() {
		return $this->protocol;
	}

	/**
	 * @param string $protocolMarker
	 */
	public function setProtocolMarker($protocolMarker) {
		$this->protocolMarker = $protocolMarker;
	}

	/**
	 * @return string
	 */
	public function getUri() {
		return $this->getProtocolPrefix() . $this->domain . '/';
	}

	/**
	 * @return string
	 */
	private function getProtocolPrefix() {
		$protocolPrefix = '';
		$protocol = $this->protocol;
		if($protocol === self::PROTOCOL_DYNAMIC) {
			$protocol = $this->getRequestProtocol();
		}
		switch($protocol) {
			case self::PROTOCOL_MARKER :
				$protocolPrefix = $this->protocolMarker;
				break;
			case self::PROTOCOL_WILDCARD :
				$protocolPrefix = '//';
				break;
			case self::PROTOCOL_HTTP :
				$protocolPrefix = 'http://';
				break;
			case self::PROTOCOL_HTTPS :
				$protocolPrefix = 'https://';;
				break;
		}
		return $protocolPrefix;
	}

	/**
	 * @return string
	 */
	protected function getRequestProtocol() {
		if (strlen($_SERVER['HTTPS']) > 0 || strtolower($_SERVER['HTTPS']) !== 'off') {
			return Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTPS;
		}
		return Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTP;
	}
}