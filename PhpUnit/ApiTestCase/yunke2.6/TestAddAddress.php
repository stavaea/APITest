<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';
//require_once '../yunke2.6/TestGetInfo.php';

class TestAddAddress extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    public $Token;
    //public $addressInfo;
    public  $uid;
    static  $u="i";
    static  $v="2";


    protected function setUp()
    {
        //云课添加收获地址
        $this->url="http://dev.gn100.com/interface/user/addAddress";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
        //$this->addressInfo = new TestGetInfo();
    }
    
    //参数正确，返回值
    public function testDataIsOK($uid='722')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $token =$this->Token->testUserTokenGenIsSuccessDev($uid);
        $postdata['token']=$token;
        $postdata['params']['userId']= $uid;
        $postdata['params']['receiverUser']= "18888880050";
        $postdata['params']['tel']= "18888880050";
        $postdata['params']['addressStr']= "女";
        $postdata['params']['address']= "五道口";
        $postdata['params']['remark']= "发顺丰";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump($result);
//         $addressInfo = $this->addressInfo->testAddAddressInfo($uid);
//         var_dump($addressInfo);
//         $this->assertNotEmpty($addressInfo['result']['addressInfo']);
    }
    
}