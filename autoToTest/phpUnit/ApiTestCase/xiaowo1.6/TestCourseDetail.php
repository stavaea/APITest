<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestCourseDetail extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    static  $u="i";
    static  $v="2";
    public $Token;
    
    
    protected function setUp()
    {
        //课程简介和目录信息
        $this->url="http://dev.gn100.com/interface/course/detail";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
    
    }
    
    //参数正确，返回值
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $token =$this->Token->testUserTokenGenIsSuccessDev('23339');
        $postdata['token']=$token;
        $postdata['params']['courseId']= '5138';
        $postdata['params']['uid']= '3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertEquals('0', $result['code']);
        $this->assertArrayHasKey('recodeText', $result['result']);
    }
}