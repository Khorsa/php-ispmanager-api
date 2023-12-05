<?php

namespace Khorsa\IspManagerApi\IspUser;

class IspUserDto
{
    public function __construct(
        public string $name,
        public bool $isActive,
        public string $fullName,
        public ?int $quotaTotal,
        public int $quotaUsed,
    ) {
    }
}
