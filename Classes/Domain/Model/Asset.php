<?php
namespace Aoe\Asdis\Domain\Model;

use Aoe\Asdis\Domain\Model\Server;

/**
 * Represents an asset.
 */
class Asset
{
    /**
     * @var string
     */
    private $originalPath;

    /**
     * @var string
     */
    private $normalizedPath;

    /**
     * @var \Aoe\Asdis\Domain\Model\Server
     */
    private $server;

    /**
     * The mask character in the content. eg. " or '
     * @var string
     */
    private $mask;

    /**
     * @return string
     */
    public function getHash()
    {
        return md5($this->originalPath);
    }

    /**
     * @param string $originalPath
     */
    public function setOriginalPath($originalPath)
    {
        $this->originalPath = $originalPath;
    }

    /**
     * @return string
     */
    public function getOriginalPath()
    {
        return $this->originalPath;
    }

    /**
     * @param string $normalizedPath
     */
    public function setNormalizedPath($normalizedPath)
    {
        $this->normalizedPath = $normalizedPath;
    }

    /**
     * @return string
     */
    public function getNormalizedPath()
    {
        return $this->normalizedPath;
    }

    /**
     * @return string
     */
    public function getPregQuotedOriginalPath()
    {
        return '~/?' . preg_quote($this->originalPath) . '~is';
    }

    /**
     * @return string
     */
    public function getMaskedPregQuotedOriginalPath()
    {
        $mask = preg_quote($this->getMask());
        return '~/?' . $mask . preg_quote($this->originalPath) . $mask . '~is';
    }

    /**
     * @param \Aoe\Asdis\Domain\Model\Server $server
     */
    public function setServer(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @return \Aoe\Asdis\Domain\Model\Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        $domain = '';
        if (isset($this->server)) {
            $domain = $this->server->getUri();
        }
        return $domain . $this->normalizedPath;
    }

    /**
     * @return string
     */
    public function getMask()
    {
        return $this->mask;
    }

    /**
     * @param string $mask
     */
    public function setMask($mask){
        $this->mask = $mask;
    }
}