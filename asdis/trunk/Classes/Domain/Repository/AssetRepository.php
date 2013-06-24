<?php

class Tx_Asdis_Domain_Repository_AssetRepository {

	/**
	 * @param Tx_Asdis_Domain_Model_Page $page
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 * @todo implement
	 */
	public function findAllByPage(Tx_Asdis_Domain_Model_Page $page) {
		return new Tx_Asdis_Domain_Model_Asset_Collection();
	}
}