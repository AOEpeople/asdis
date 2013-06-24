<?php

class Tx_Asdis_Domain_Model_Server {

	const PROTOCOL_HTTP = 'http';
	const PROTOCOL_HTTPS = 'https';

	private $domain;
	private $protocol;
	private $identifier;

	public function setDomain($domain) {
		$this->domain = $domain;
	}
	public function getDomain() {
		return $this->domain;
	}
	public function setIdentifier($identifier) {
		$this->identifier = $identifier;
	}
	public function getIdentifier() {
		return $this->identifier;
	}
	public function setProtocol($protocol) {
		$this->protocol = $protocol;
	}
	public function getProtocol() {
		return $this->protocol;
	}

	public function getUri() {
		return $this->protocol . '://' . $this->domain . '/';
	}
}