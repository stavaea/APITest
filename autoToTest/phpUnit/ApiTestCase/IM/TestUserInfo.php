<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestUserInfo extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //用户信息
        $this->url = "http://dev.gn100.com/interface/user/userbasicinfo";
        $this->http = new HttpClass();
    
    }
    
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']= "3596";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump($result);
        $this->assertEquals('3596', $result['result']['userId']);
        $this->assertEquals('杨明娟', $result['result']['name']);
        $this->assertEquals('杨明娟', $result['result']['realName']);
        $this->assertEquals('15510720812', $result['result']['mobile']);
        $this->assertEquals('http://devf.gn100.com/4,cc7170c2967d', $result['result']['thumbMed']);
        $this->assertEquals('http://devf.gn100.com/7,cc7007afacf0', $result['result']['thumbBig']);
        $this->assertEquals('http://devf.gn100.com/5,cc72266c8600', $result['result']['thumbSmall']);
    }
    
    //参数未传，返回值
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']= "";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals(NULL, $result);
        
    }
}