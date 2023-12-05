<?php

namespace Khorsa\IspManagerApi\Tests;

use Khorsa\IspManagerApi\IspException;
use Khorsa\IspManagerApi\IspUser\IspUser;

class IspUserTest extends IspAbstractTest
{
    public function testUserSuspend(): void
    {
        $callResult = '{"doc":{"$lang":"en","$func":"user.suspend","$binary":"\/ispmgr","$host":"https:\/\/fake-site.com:1500","$themename":"dragon","$features":"ed13fed30f9503fcf2cdf0415231f846","$notify":"","$theme":"\/manimg\/dragon\/","$css":"main.css","$logo":"logo.png","$logolink":"https:\/\/fake-site.com","$favicon":"favicon.ico","$localdir":"local_bcb801722638\/","ok":{},"saved_filters":{},"tparams":{"elid":{"$":"user0"},"func":{"$":"user.suspend"},"out":{"$":"sjson"}}}}';
        $function = new IspUser($this->mockConnection($callResult));
        $function->setAccessData($this->getAccessDto());

        $function->suspend('user0');
        $this->assertTrue(true);    // No exception
    }

    public function testUserResume(): void
    {
        $callResult = '{"doc":{"$lang":"en","$func":"user.resume","$binary":"\/ispmgr","$host":"https:\/\/fake-site.com:1500","$themename":"dragon","$features":"ed13fed30f9503fcf2cdf0415231f846","$notify":"","$theme":"\/manimg\/dragon\/","$css":"main.css","$logo":"logo.png","$logolink":"https:\/\/fake-site.com","$favicon":"favicon.ico","$localdir":"local_bcb801722638\/","ok":{},"saved_filters":{},"tparams":{"elid":{"$":"user0"},"func":{"$":"user.resume"},"out":{"$":"sjson"}}}}';
        $function = new IspUser($this->mockConnection($callResult));
        $function->setAccessData($this->getAccessDto());

        $function->resume('user0');
        $this->assertTrue(true);    // No exception
    }

    public function testUserDelete(): void
    {
        $callResult = '{"doc":{"$lang":"en","$func":"user.delete","$binary":"\/ispmgr","$host":"https:\/\/fake-site.com:1500","$themename":"dragon","$features":"ed13fed30f9503fcf2cdf0415231f846","$notify":"","$theme":"\/manimg\/dragon\/","$css":"main.css","$logo":"logo.png","$logolink":"https:\/\/fake-site.com","$favicon":"favicon.ico","$localdir":"local_bcb801722638\/","ok":{},"saved_filters":{},"tparams":{"elid":{"$":"user0"},"func":{"$":"user.delete"},"out":{"$":"sjson"}}}}';
        $function = new IspUser($this->mockConnection($callResult));
        $function->setAccessData($this->getAccessDto());

        $function->delete('user0');
        $this->assertTrue(true);    // No exception
    }

    public function testGetRedirectLink(): void
    {
        $callResult = '{"doc":{"$lang":"en","$func":"session.newkey","$binary":"\/ispmgr","$host":"https:\/\/fake-site.com:1500","$themename":"dragon","$features":"ed13fed30f9503fcf2cdf0415231f846","$notify":"","$theme":"\/manimg\/dragon\/","$css":"main.css","$logo":"logo.png","$logolink":"https:\/\/fake-site.com","$favicon":"favicon.ico","$localdir":"local_bcb80b722638\/","ok":{},"saved_filters":{},"tparams":{"func":{"$":"session.newkey"},"key":{"$":"23d5a822f913171ee6e7ba691edf33e9"},"out":{"$":"sjson"}}}}';
        $function = new IspUser($this->mockConnection($callResult));
        $function->setAccessData($this->getAccessDto());

        $result = $function->getRedirectLink('user0');

        $this->assertTrue(1 === preg_match("/^https:\/\/fake-site\.com:1500\/ispmgr\?func=auth&username=user0&key=[0-9a-zA-Z]+&checkcookie=no$/i", $result));
    }

    public function testGetRedirectLinkAccessError(): void
    {
        $callResult = '{"doc":{"error":{"$type":"auth","$object":"badpassword","$lang":"en","detail":{"$":"Invalid username or password "},"msg":{"$":"Invalid username or password "},"param":[{"$name":"object","$type":"msg","$":"badpassword"},{"$name":"value","$":"remote_addr: [85.140.114.49]"}]}}}';
        $function = new IspUser($this->mockConnection($callResult));
        $function->setAccessData($this->getAccessDto());

        $this->expectException(IspException::class);
        $this->expectExceptionMessage('Execution session.newkey error: Invalid username or password');
        $function->getRedirectLink('user0');
    }
}
