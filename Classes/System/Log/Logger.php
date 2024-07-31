<?php

namespace Aoe\Asdis\System\Log;

use Exception;
use TYPO3\CMS\Core\Log\Logger as T3Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * System logger.
 */
class Logger implements SingletonInterface
{
    private T3Logger $logger;

    public function logException(string $context, Exception $e): void
    {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(self::class);
        $this->logger->error(
            $context . ': ' . $e->getMessage(),
            $e->getTrace()
        );
    }
}
