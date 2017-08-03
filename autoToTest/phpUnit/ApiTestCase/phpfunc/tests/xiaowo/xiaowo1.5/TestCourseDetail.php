<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestCourseDetail extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $oid;
    private $GetToken;
    
    
    protected function setUp()
    {
        //小沃1.5课程详情
        $this->url = "http://test.gn100.com/interface/course/detail";
        $this->http = new HttpClass();
        $this->GetToken =new TestUserToken();
    
    }
    
    public function testDataIsOK($oid='227')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['courseId']= "1409";
        $postdata['params']['uid']= "23339";
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid="23339");
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('啊啊啊啊', $result['result']['courseName']);
        $this->assertArrayHasKey('userTotal', $result['result']);
        $this->assertArrayHasKey('avgScore', $result['result']);
        $this->assertArrayHasKey('trySee', $result['result']);
        $this->assertArrayHasKey('isFree', $result['result']);
        $this->assertArrayHasKey('isMember', $result['result']);
        $this->assertArrayHasKey('userTotal', $result['result']);
        
    }
    
    //courseId不存在，返回值
    public function testCourseIdIsNotExist($oid='227')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['courseId']= "aaa";
        $postdata['params']['uid']= "23339";
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid="23339");
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1000', $result['code']);
    }
}