<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestOrderInfo extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    public $Token;
    static  $u="i";
    static  $v="2";
    
    
    protected function setUp()
    {
        //小沃订单
        $this->url="http://dev.gn100.com/interface/user/orderInfo";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
    }
    
    public function testDataIsOK($oid="842")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $token =$this->Token->testUserTokenGenIsSuccessDev('3596');
        $postdata['token']=$token;
        $postdata['params']['userId']= "3596";
        $postdata['params']['ext']= "3200";
        $postdata['params']['objectType']= "1";//课程
        $postdata['params']['objectId']= "4486";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('planNum', $result['result']);//排课数
        $this->assertArrayHasKey('finishPla', $result['result']);//完结的排课数
        $this->assertArrayHasKey('notFinishPlan', $result['result']);//未完结的排课数
        $this->assertArrayHasKey('planName', $result['result']);//排课名称
        $this->assertArrayHasKey('planTime', $result['result']);//开课时间
        $this->assertArrayHasKey('status', $result['result']);
        
    }
}