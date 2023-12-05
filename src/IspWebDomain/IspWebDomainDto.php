<?php

namespace Khorsa\IspManagerApi\IspWebDomain;

class IspWebDomainDto
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public string $ipAddress,
        public ?string $database,
        public string $docRoot,
        public string $handler,
        public string $owner,
        public string $phpMode,
        public string $php,
        public string $phpVersion,
        public bool $secure,
    ) {
    }
}
