<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';
require_once '../yunkeTeacher/TestClosePlay.php';

class TestStartPlay extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    private $Token;
    private $closePlay;
     
    
    protected function setUp()
    {
        //老师上课
        $this->url = "http://test.gn100.com/interface/plan/StartPlay";
        $this->http = new HttpClass();
        $this->Token = new TestUserToken();
        $this->closePlay = new TestClosePlay();
        
        
    
    }
    
    public function testDataIsOK($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['planId']= '4949';
        $postdata['params']['cleanFile']='yes';
        $token =$this->Token->testUserTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['code']);//上课成功
        
        //$this->closePlay->testDataIsOK();//调用下课接口
    }
}