<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestGetInfo extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    public $Token;
    static  $u="i";
    static  $v="2";
    static $uid;
    
    
    protected function setUp()
    {
        //云课收货地址
        $this->url="http://dev.gn100.com/interface/user/GetInfo";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
    }
    
    //参数正确，返回结果
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $token =$this->Token->testUserTokenGenIsSuccessDev('3596');
        $postdata['token']=$token;
        $postdata['params']['uid']= "3596";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump($result);
        $this->assertEquals('娟娟', $result['result']['nickName']);
        $this->assertEquals('http://devf.gn100.com/7,cc7007afacf0', $result['result']['image']);
        $this->assertEquals('15510720812', $result['result']['mobile']);
        $this->assertEquals('杨明娟', $result['result']['realName']);
        $this->assertEquals('女', $result['result']['sex']);
        $this->assertEquals('黑龙江省,哈尔滨市,道里区', $result['result']['address']);
        $this->assertEquals('5,132,4410', $result['result']['addressId']);
        $this->assertEquals('0', $result['result']['schoolType']);
        $this->assertEquals('', $result['result']['school']);
        $this->assertEquals('0', $result['result']['schoolId']);
        $this->assertEquals('一年级', $result['result']['grade']);
        $this->assertEquals('1001', $result['result']['gradeId']);
        $this->assertEquals('2016-01-01', $result['result']['birthday']);
        $this->assertEquals('148', $result['result']['addressInfo']['addressId']);
        $this->assertEquals('杨明娟', $result['result']['addressInfo']['receiverUser']);
        $this->assertEquals('15510720812', $result['result']['addressInfo']['tel']);
        $this->assertEquals('北京市', $result['result']['addressInfo']['province']);
        $this->assertEquals('昌平区', $result['result']['addressInfo']['city']);
        $this->assertEquals('', $result['result']['addressInfo']['country']);
        $this->assertEquals('沙河镇', $result['result']['addressInfo']['address']);
        $this->assertEquals('11', $result['result']['addressInfo']['remark']);//备注
        
        
    }
    
    //传参正确，未填收货地址
    public function testAddressIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $token =$this->Token->testUserTokenGenIsSuccessDev('701');
        $postdata['token']=$token;
        $postdata['params']['uid']= "701";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump($result);
        $this->assertEmpty($result['result']['addressInfo']);//收货地址为空
    }
    
    
    public function testAddAddressInfo($uid='')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $token =$this->Token->testUserTokenGenIsSuccessDev($uid);
        $postdata['token']=$token;
        $postdata['params']['uid']= $uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        return $result;
    }
}