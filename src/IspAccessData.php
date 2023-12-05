<?php

namespace Khorsa\IspManagerApi;

class IspAccessData
{
    private const ISP_PATH = 'ispmgr';

    public function __construct(
        public readonly string $protocol,
        public readonly string $server,
        public readonly ?int $port,
        public readonly string $login,
        public readonly string $password,
    ) {
    }

    public function getSiteUrl(): string
    {
        $server = $this->server;
        if ($this->port) {
            $server .= ':'.$this->port;
        }

        return "$this->protocol://$server/".self::ISP_PATH;
    }
}
