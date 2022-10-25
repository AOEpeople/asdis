<?php

namespace Aoe\Asdis\System\Log;

use Exception;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * System logger.
 */
class Logger implements SingletonInterface
{
    /**
     * @param string $context
     * @param Exception $e
     */
    public function logException($context, Exception $e)
    {
        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '9.5.0', '<') === true) {
            $this->syslog(
                $context,
                'Exception occured ' . PHP_EOL .
                '  Code:    ' . $e->getCode() . PHP_EOL .
                '  Message: "' . $e->getMessage() . '"' . PHP_EOL .
                '  Trace:' . PHP_EOL . $e->getTraceAsString(),
                4
            );
            return;
        }

        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        $this->logger->error(
            $context . ': ' . $e->getMessage(),
            $e->getTrace()
        );
    }

    /**
     * @param string $message
     * @param integer $severity
     */
    private function syslog($message, $severity)
    {
        GeneralUtility::sysLog($message, 'asdis', $severity);
    }
}
