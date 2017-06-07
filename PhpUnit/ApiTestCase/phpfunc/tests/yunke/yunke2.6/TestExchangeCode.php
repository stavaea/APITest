<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestExchangeCode extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $oid;
    
    protected function setUp()
    {
        //兑换优惠码
        $this->url = "http://dev.gn100.com/interface/discountcode/ExchangeCode";
        $this->http = new HttpClass();
    
    }
    
    public function testDataIsOK($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']= "3596";
        $postdata['params']['code']= "768ys";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('-1', $result['code']);//已经兑换过了
    }
    
    public function testCodeIsCorrect($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']= "3596";
        $postdata['params']['code']= "aa";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('-1', $result['code']);//请输入有效的优惠码
    }
}