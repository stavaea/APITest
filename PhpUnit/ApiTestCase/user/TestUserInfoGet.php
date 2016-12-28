<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';

/**
 * test case.
 */
class TestUserInfoGet extends PHPUnit_Framework_TestCase
{

    public  $uid;
    public  $url;
    public  $HttpUrl;
   
    public function  __construct()
    {
        $this->http =new HttpClass();
        $this->url= "http://api.gn100.com//user/info/get/";
    }
    
    public function testUserInfoGetSuccess($uid='0')
    {
        $HttpUrl=$this->url.$uid;
        $result =json_decode($this->http->HttpGet($HttpUrl),true);
        $this->assertEquals('200', $this->http->HttpGetCode($HttpUrl));
        return $result;
    }
    
    public function testUserInfoBasicInfo($uid='22415')
    {
        $HttpUrl=$this->url.$uid;
        $result = json_decode($this->http->HttpGet($HttpUrl),true);
        $this->assertEquals("nickname", $result['data']['name']);
        $this->assertContains('泠妞妞',($result['data']['profile']['real_name']));
        $result['data']['profile']['real_name'];
        $this->assertEquals("13122223333",$result['data']['mobile']);
        $this->assertEquals('normal',$result['data']['status']);
    }
    
    
    public function testUserInfoAvatar($uid='22415')
    {
        $HttpUrl=$this->url.$uid;
        $result = json_decode($this->http->HttpGet($HttpUrl),true);
        $this->assertNotEmpty($result['data']['avatar']['large']);
    }


    public function testUserInfoGetUserNotExist($uid=1000020230)
    {
        $HttpUrl=$this->url.$uid;
        $result = json_decode($this->http->HttpGet($HttpUrl),true);
        $this->assertEquals('-102', $result['data']['code']);
    }
    
/**
 * @dataProvider additionProvider
 */
    public function testUserInfoTypes($uid='22410')
    {
        $HttpUrl=$this->url.$uid;
        $result = json_decode($this->http->HttpGet($HttpUrl),true);
        $this->assertTrue($result['data']['types']['student']);
        $this->assertTrue($result['data']['types']['teacher']);
        $this->assertTrue($result['data']['types']['organization']);
    }

   
  
    
}

