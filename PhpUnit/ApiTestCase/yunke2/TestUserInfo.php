<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

/**
 * test case.
 */
class TestUserInfo extends PHPUnit_Framework_TestCase
{    
    private $url;
    private $http;
    static $u="i";
    static $v="2"; 
    static $db="db_user";
    private $GetToken;
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/user/GetInfo";
        $this->http = new HttpClass();
        $this->GetToken =new TestUserToken();
    }

    public function testUserHasRealName($uid='22410')
    {
        $db=self::$db;
        $sql ="select name,real_name,mobile,thumb_big from t_user where pk_user=$uid";
        $userInfo=interface_func::ConnectDB($db, $sql);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals($userInfo[0][0], $result['result']['nickName']);
        $this->assertEquals($userInfo[0][1], $result['result']['realName']);
         $this->assertContains($userInfo[0][2], $result['result']['mobile']);
        $this->assertContains($userInfo[0][3], $result['result']['image']);
    }

    public function testNoRealNameUser($uid='196')
    {
        $db=self::$db;
        $sql ="select name,real_name,mobile,thumb_big from t_user where pk_user=$uid";
        $userInfo=interface_func::ConnectDB($db, $sql);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals($userInfo[0][0], $result['result']['nickName']);
        $this->assertEmpty($result['result']['realName']);
    }
    
    public function testUserNoLogin($uid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('3002', $result['code']);
    }
    
    //用户不存在应返回相应提示
    public function testUserNoExist($uid='99898300')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertNotEquals(0, $result['code']);
    }
}

