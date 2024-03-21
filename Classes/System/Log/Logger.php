<?php

namespace Aoe\Asdis\System\Log;

use Exception;
use TYPO3\CMS\Core\Log\Logger as T3Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * System logger.
 */
class Logger implements SingletonInterface
{
    private T3Logger $logger;

    public function logException(string $context, Exception $e): void
    {
        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '9.5.0', '<')) {
            $this->syslog(
                'Exception occured ' . PHP_EOL .
                '  Code:    ' . $e->getCode() . PHP_EOL .
                '  Message: "' . $e->getMessage() . '"' . PHP_EOL .
                '  Trace:' . PHP_EOL . $e->getTraceAsString(),
                4
            );
            return;
        }

        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(self::class);
        $this->logger->error(
            $context . ': ' . $e->getMessage(),
            $e->getTrace()
        );
    }

    private function syslog(string $message, int $severity): void
    {
        GeneralUtility::sysLog($message, 'asdis', $severity);
    }
}
