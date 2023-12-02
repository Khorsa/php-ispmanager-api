<?php

namespace App\Tests;

use IspManagerApi\IspAccessData;
use IspManagerApi\IspConnection;
use PHPUnit\Framework\TestCase;

abstract class IspAbstractTest extends TestCase
{
    protected function mockConnection(string $callResult): IspConnection
    {
        $mock = $this->createMock(IspConnection::class);
        $mock->method('call')->willReturn($callResult);

        return $mock;
    }

    protected function getAccessDto(): IspAccessData
    {
        return new IspAccessData(
            'https',
            'fake-site.com',
            1500,
            'login',
            'password',
        );
    }
}
