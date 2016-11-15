<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
/**
 * test case.
 */
class TestUserToken extends PHPUnit_Framework_TestCase
{
    /**
     * Constructs the test case.
     */
    public  $http;
    public  $uid;
    public function __construct()
    {
        $this->http=new HttpClass();
    }
    
    /*
     * test API user/token/gen
     */
    /*
     * 登陆用户生成token正确用例
     */
    public function testUserTokenGenIsSuccess($uid="22414")
    {
        $url='http://api.gn100.com//user/token/gen';
        $postData['uid']=$uid;
        $postData['platform']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $postData['ip']="121.69.7.6";
        $data =json_encode($postData,true);
         $result =  json_decode($this->http->HttpPost($url, $data),true);
         $token =$result['data']['token'];
         $this->assertEquals('0',$result['result']['code']);
         $this->assertNotEmpty($result['data']['token']);
         return $token;
    }
    /*
     * 游客生成token正确
     */
    public function testUserTokenGenVisitor()
    {
        $url='http://api.gn100.com//user/token/gen';
        $postData['uid']="0";
        $postData['platform']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $postData['ip']="121.69.7.6";
        $data =json_encode($postData,true);
        $result =  json_decode($this->http->HttpPost($url, $data),true);
        $token2 =$result['data']['token'];
        $this->assertEquals('0',$result['result']['code']);
        return $token2;
    }
    
    /*
     * 必填参数确实用例
     */
    public function testUserTokenGenNoIp()
    {
        $url='http://api.gn100.com//user/token/gen';
        $postData['uid']="22410";
        $postData['platform']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $data =json_encode($postData,true);
        $result =  json_decode($this->http->HttpPost($url, $data),true);
        $this->assertEquals('-1',$result['result']['code']); 
    }
    
    /*
     * 参数名错误用例
     */
    
    public function testUserTokenGenParamsError()
    {
        $url='http://api.gn100.com//user/token/gen';
        $postData['uid']="22410";
        $postData['platform3']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $data =json_encode($postData,true);
        $result =  json_decode($this->http->HttpPost($url, $data),true);
        $this->assertEquals('-1',$result['result']['code']);
    }
    
    
    /*
     * token唯一性用例
     */
    /**
     * 
     * @depends testUserTokenGenIsSuccess
     * @depends testUserTokenGenVisitor
     */
    public function testUserTokenGenUnique($token,$token2)
    {
        $this->assertNotEquals($token, $token2);
    }
    
    /*
     * test API user/token/get
     */
    
    /*
     * 根据token获取用户信息正确
     */
    
    /**
     * @depends testUserTokenGenIsSuccess
     */
    public function testUserTokenGetIsSuccess($token)
    {
        $url="http://api.gn100.com//user/token/get/$token";
        $result =json_decode($this->http->HttpGet($url),true);
        $this->assertEquals('0', $result['result']['code']);
        $this->assertEquals('22414', $result['data']['uid']);
    }
    
    /*
     * 用户不存在用例
     */
    public function testUserTokenGetParamsError()
    {
        $url="http://api.gn100.com//user/token/get/2993939";
        $result =json_decode($this->http->HttpGet($url),true);
        $this->assertEquals('-1', $result['result']['code']);
    }
    
    /*
     * test API user/token/del
     */
    
    /*
     * 删除token成功用例
     */
    /**
     * @depends testUserTokenGenIsSuccess
     */
    public function testUserTokenDel($token)
    {
        $url="http://api.gn100.com//user/token/del/$token";
        $result =json_decode($this->http->HttpPost($url, ''),true);
        $this->assertEquals('1', $result['result']['code']);
        $geturl="http://api.gn100.com//user/token/get/$token";
        $getresult =json_decode($this->http->HttpGet($url),true);
        $this->assertEquals('-1', $getresult['result']['code']);
    }
    
    /*
     * 删除游客token
     */
    /**
     * @depends testUserTokenGenVisitor
     */
    public function testUserTokenDelVisitorToken($token2)
    {
        $url="http://api.gn100.com//user/token/del/$token2";
        $result =json_decode($this->http->HttpPost($url, ''),true);
        $this->assertEquals('1', $result['result']['code']);
    }
    
    }


