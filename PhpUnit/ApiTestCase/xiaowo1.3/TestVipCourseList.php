<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestVipCourseList extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    public $Token;
    static  $u="i";
    static  $v="2";
    
    protected function setUp()
    {
        //小沃会员课程列表
        $this->url="http://dev.gn100.com/interface/member/courseList";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
    }
    
    public function testDataIsOK($oid='842')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $token =$this->Token->testUserTokenGenIsSuccess('3596');
        $postdata['token']=$token;
        $postdata['params']['userId']= "3596";
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "10";
        $postdata['params']['memberId']= "55";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('', $result['result']);
        
    }
}