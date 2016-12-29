<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once 'TestUserInfoGet.php';
/**
 * test case.
 */
class TestUserInfoUpdate extends PHPUnit_Framework_TestCase
{
    private $uid;
    private $url;
    private $http;
    private $InfoGet;
    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        $this->url="http://api.gn100.com//user/info/update/";
        $this->http=new HttpClass();
        $this->InfoGet= new TestUserInfoGet();
    }
    
    public function testUserInfoUpdateParamsError($uid="")
    {
        $httpurl=$this->url.$uid;
        $this->assertEquals('200', $this->http->HttpGetCode($httpurl));
        $result =json_decode($this->http->HttpPost($httpurl,  json_encode("")),true);
        $this->assertEquals('-11', $result['result']['code'],'url:'.$this->url);
    }
    
    public function testUserInfoUpdateGenderSuccess($uid="22415")
    {
        $httpurl=$this->url.$uid;
        $postData['gender']="male";
        $result =json_decode($this->http->HttpPost($httpurl,  json_encode($postData)),true);
        $this->assertEquals("ok", $result['result']['msg'],'url:'.$this->url);
        $getInfo=$this->InfoGet->testUserInfoGetSuccess($uid);
        $this->assertEquals("male", $getInfo['data']['gender'],'url:'.$this->url);
    }
    
    public function testUserInfoUpdateRestoreData($uid="22415")
    {
        $httpurl=$this->url.$uid;
        $postData['gender']="female";
        $result =json_decode($this->http->HttpPost($httpurl,  json_encode($postData)),true);
        $this->assertEquals("ok", $result['result']['msg'],'url:'.$this->url);
    }
}

