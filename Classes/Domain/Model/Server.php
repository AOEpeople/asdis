<?php

namespace Aoe\Asdis\Domain\Model;

/**
 * Represents a server.
 */
class Server
{
    /**
     * @var string
     */
    public const PROTOCOL_WILDCARD = 'wildcard';

    /**
     * @var string
     */
    public const PROTOCOL_MARKER = 'marker';

    /**
     * @var string
     */
    public const PROTOCOL_DYNAMIC = 'dynamic';

    /**
     * @var string
     */
    public const PROTOCOL_HTTP = 'http';

    /**
     * @var string
     */
    public const PROTOCOL_HTTPS = 'https';

    private ?string $domain = null;

    private ?string $protocol = null;

    private ?string $identifier = null;

    private ?string $protocolMarker = null;

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setProtocol(string $protocol): void
    {
        if (!in_array(
            $protocol,
            [self::PROTOCOL_WILDCARD,
                self::PROTOCOL_MARKER,
                self::PROTOCOL_HTTP,
                self::PROTOCOL_HTTPS,
                self::PROTOCOL_DYNAMIC,
            ]
        )) {
            return;
        }
        $this->protocol = $protocol;
    }

    public function getProtocol(): ?string
    {
        return $this->protocol;
    }

    public function setProtocolMarker(string $protocolMarker): void
    {
        $this->protocolMarker = $protocolMarker;
    }

    public function getUri(): string
    {
        return $this->getProtocolPrefix() . $this->domain . '/';
    }

    protected function getRequestProtocol(): string
    {
        if (strlen($_SERVER['HTTPS']) > 0) {
            return self::PROTOCOL_HTTPS;
        }
        if (strtolower($_SERVER['HTTPS']) !== 'off') {
            return self::PROTOCOL_HTTPS;
        }
        return self::PROTOCOL_HTTP;
    }

    private function getProtocolPrefix(): string
    {
        $protocolPrefix = '';
        $protocol = $this->protocol;
        if ($protocol === self::PROTOCOL_DYNAMIC) {
            $protocol = $this->getRequestProtocol();
        }
        switch ($protocol) {
            case self::PROTOCOL_MARKER:
                $protocolPrefix = $this->protocolMarker;
                break;
            case self::PROTOCOL_WILDCARD:
                $protocolPrefix = '//';
                break;
            case self::PROTOCOL_HTTP:
                $protocolPrefix = 'http://';
                break;
            case self::PROTOCOL_HTTPS:
                $protocolPrefix = 'https://';
                break;
        }
        return $protocolPrefix;
    }
}
