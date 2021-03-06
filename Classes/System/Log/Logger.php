<?php
namespace Aoe\Asdis\System\Log;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * System logger.
 */
class Logger implements SingletonInterface
{
    /**
     * @param string $context
     * @param Exception $e
     */
    public function logException($context, \Exception $e)
    {
        if (true === version_compare(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getCurrentTypo3Version(), '9.5.0', '<')) {
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

        $this->logger = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Log\LogManager::class)->getLogger(__CLASS__);
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