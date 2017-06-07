<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';
require_once '../yunke2.6/TestGetInfo.php';


class TestUpdateAddress extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    public $Token;
    static  $u="i";
    static  $v="2";
    //public $AddressInfo;
    
    
    protected function setUp()
    {
        //云课更新收获地址
        $this->url="http://dev.gn100.com/interface/user/updateAddress";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
        $this->AddressInfo = new TestGetInfo();
    }
    
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $token = $this->Token->testUserTokenGenIsSuccessDev('720');
        $postdata['token']=$token;
        $postdata['params']['userId']= "720";
        $postdata['params']['receiverUser']= "18888880050";
        $postdata['params']['tel']= "18888880050";
        $postdata['params']['addressStr']= "女";
        $postdata['params']['address']= "五道口";
        $postdata['params']['remark']= "发顺丰aaaaaaa";
        $postdata['params']['addressId']= "174";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        
         $Info = $this->AddressInfo->testAddAddressInfo('720');
         var_dump($Info);exit;
//         $this->assertEquals('发顺丰aaaaaaa',$Info['result']['addressInfo']['remark']);
    }
}