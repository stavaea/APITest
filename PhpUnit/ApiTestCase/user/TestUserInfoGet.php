<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/dbConfig.php';

/**
 * test case.
 */
class TestUserInfoGet extends PHPUnit_Framework_TestCase
{

    public $uid;

    public $url;

    public $HttpUrl;

    public function __construct()
    {
        $this->http = new HttpClass();
         global $IP;
        $this->url = "http://" . $IP . "/user/info/get/";
    }

    public function testUserInfoGetSuccess($uid = '0')
    {
        $HttpUrl = $this->url . $uid;
        $result = json_decode($this->http->HttpApiGet($HttpUrl), true);
        $this->assertEquals('200', $this->http->HttpApiGetCode($HttpUrl), 'url:' . $this->url);
        return $result;
    }

    public function testUserInfoBasicInfo($uid = '22415')
    {
        $HttpUrl = $this->url . $uid;
        $result = json_decode($this->http->HttpApiGet($HttpUrl), true);
        $this->assertEquals("nickname", $result['data']['name'], 'url:' . $this->url);
        $this->assertContains('泠妞妞', ($result['data']['profile']['real_name']), 'url:' . $this->url);
        $this->assertEquals("13122223333", $result['data']['mobile'], 'url:' . $this->url);
        $this->assertEquals('normal', $result['data']['status'], 'url:' . $this->url);
    }

    public function testUserInfoAvatar($uid = '22415')
    {
        $HttpUrl = $this->url . $uid;
        $result = json_decode($this->http->HttpApiGet($HttpUrl), true);
        $this->assertNotEmpty($result['data']['avatar']['large'], 'url:' . $this->url);
    }

    public function testUserInfoGetUserNotExist($uid = 1000020230)
    {
        $HttpUrl = $this->url . $uid;
        $result = json_decode($this->http->HttpApiGet($HttpUrl), true);
        $this->assertEquals('-102', $result['data']['code'], 'url:' . $this->url);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testUserInfoTypes($uid = '22410')
    {
        $HttpUrl = $this->url . $uid;
        $result = json_decode($this->http->HttpApiGet($HttpUrl), true);
        $this->assertTrue($result['data']['types']['student'], 'url:' . $this->url);
        $this->assertTrue($result['data']['types']['teacher'], 'url:' . $this->url);
        $this->assertTrue($result['data']['types']['organization'], 'url:' . $this->url);
    }
}

