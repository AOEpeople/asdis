<?php

namespace Aoe\Asdis\Domain\Model;

/**
 * Represents an asset.
 * @see \Aoe\Asdis\Tests\Domain\Model\AssetTest
 */
class Asset
{
    private string $originalPath = '';

    private string $normalizedPath = '';

    private ?Server $server = null;

    /**
     * The mask character in the content. eg. " or '
     */
    private string $mask = '';

    public function getHash(): string
    {
        return md5($this->originalPath);
    }

    public function setOriginalPath(string $originalPath): void
    {
        $this->originalPath = $originalPath;
    }

    public function getOriginalPath(): ?string
    {
        return $this->originalPath;
    }

    public function setNormalizedPath(string $normalizedPath): void
    {
        $this->normalizedPath = $normalizedPath;
    }

    public function getNormalizedPath(): string
    {
        return $this->normalizedPath;
    }

    public function getPregQuotedOriginalPath(): string
    {
        return '~/?' . preg_quote($this->originalPath) . '~is';
    }

    public function getMaskedPregQuotedOriginalPath(): string
    {
        $mask = preg_quote($this->mask);
        return '~/?' . $mask . preg_quote($this->originalPath) . $mask . '~is';
    }

    public function setServer(Server $server): void
    {
        $this->server = $server;
    }

    public function getServer(): ?Server
    {
        return $this->server;
    }

    public function getUri(): string
    {
        $domain = '';
        if (isset($this->server)) {
            $domain = $this->server->getUri();
        }

        return $domain . $this->normalizedPath;
    }

    public function getMask(): ?string
    {
        return $this->mask;
    }

    public function setMask(string $mask): void
    {
        $this->mask = $mask;
    }
}
