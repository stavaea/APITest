<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestDiscountTicket extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $oid;
    
    protected function setUp()
    {
        //该课程下可用优惠码
        $this->url = "http://dev.gn100.com/interface/discountcode/DiscountTicket";
        $this->http = new HttpClass();
    
    }
    
    public function testDataIsOK($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']= "3596";
        $postdata['params']['objectId']= "4431";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump($result);
        $this->assertArrayHasKey('count', $result['result']);
    }
}