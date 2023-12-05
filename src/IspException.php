<?php

namespace Khorsa\IspManagerApi;

class IspException extends \Exception
{
    public function __construct(string $ispMessage)
    {
        parent::__construct($ispMessage);
    }
}
