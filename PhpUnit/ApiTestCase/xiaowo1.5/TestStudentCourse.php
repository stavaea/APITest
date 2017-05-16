<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestStudentCourse extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $oid;
    private $GetToken;
    
    
    protected function setUp()
    {
        //小沃1.5个人中心
        $this->url = "http://dev.gn100.com/interface/org/studentCourse";
        $this->http = new HttpClass();
        $this->GetToken =new TestUserToken();
    
    }
    
    
    public function testDataIsOK($oid='842')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['userId']= "3596";
        $token=$this->GetToken->testUserTokenGenIsSuccessDev($uid="3596");
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseName', $result['result']['data'][0]);
        $this->assertArrayHasKey('courseImg', $result['result']['data'][0]);
        $this->assertArrayHasKey('isMember', $result['result']['data'][0]);
        $this->assertArrayHasKey('longTime', $result['result']['data'][0]);//学习时长
        $this->assertArrayHasKey('courseType', $result['result']['data'][0]);
        $this->assertArrayHasKey('days', $result['result']['data'][0]);//会员剩余天数
        $this->assertArrayHasKey('noteNum', $result['result']['data'][0]);//新增笔记数
    }
    
    
}