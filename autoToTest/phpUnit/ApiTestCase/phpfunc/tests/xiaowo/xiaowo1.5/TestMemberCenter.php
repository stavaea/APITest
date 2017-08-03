<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestMemberCenter extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $oid;
    private $GetToken;
    
    
    protected function setUp()
    {
        //小沃1.5会员中心
        $this->url = "http://test.gn100.com/interface/member/core";
        $this->http = new HttpClass();
        $this->GetToken =new TestUserToken();
    
    }
    
    public function testDataIsOK($oid='227')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']= "23339";
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid="23339");
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0110会员测试', $result['result']['userInfo'][0]['memberName']);
        $this->assertEquals('2017-05-24', $result['result']['userInfo'][0]['endTime']);
        $this->assertArrayHasKey('remainder', $result['result']['userInfo'][0]);
        $this->assertArrayHasKey('memberName', $result['result']['memberList'][0]['list'][0]);
        $this->assertArrayHasKey('descript', $result['result']['memberList'][0]['list'][0]);
        $this->assertArrayHasKey('memberStatus', $result['result']['memberList'][0]['list'][0]);
    }
    
    
    //不传参数，返回值
    public function testParamsIsNull($oid='227')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']= "";
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid="23339");
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1000', $result['code']);
    }
}