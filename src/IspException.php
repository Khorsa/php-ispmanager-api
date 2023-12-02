<?php

namespace IspManagerApi;

class IspException extends \Exception
{
    public function __construct(string $ispMessage)
    {
        parent::__construct($ispMessage, 0, null);
    }
}
