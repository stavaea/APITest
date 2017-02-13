<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';


class TestClosePlay extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    private $Token;
     
    
    protected function setUp()
    {
        //老师上课
        $this->url = "http://test.gn100.com/interface/plan/closePlay";
        $this->http = new HttpClass();
        $this->Token = new TestUserToken();

    }
    
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['planId']= '4949';
        $postdata['params']['uid']='23339';
        $token =$this->Token->testUserTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals('0', $result['code']);//下课成功
    }
}