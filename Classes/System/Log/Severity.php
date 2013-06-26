<?php

/**
 * Defines log severities.
 *
 * @package Tx_Asdis
 * @subpackage System_Log
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
interface Tx_Asdis_System_Log_Severity {

	/**
	 * @var integer
	 */
	const INFO = 0;

	/**
	 * @var integer
	 */
	const NOTICE = 1;

	/**
	 * @var integer
	 */
	const WARNING = 1;

	/**
	 * @var integer
	 */
	const ERROR = 3;

	/**
	 * @var integer
	 */
	const FATAL_ERROR = 4;
}