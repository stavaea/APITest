<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestDiscountCode extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $oid;
    
    protected function setUp()
    {
        //优惠码个人中心
        $this->url = "http://dev.gn100.com/interface/discountcode/DiscountCode";
        $this->http = new HttpClass();
    
    }
    //未使用
    public function testDataNotUsed($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']= "1";
        $postdata['params']['status']= "0";
        $postdata['params']['userId']="1";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        //$this->assertEquals('-1', $result['code']);
        $this->assertArrayHasKey('discount_value', $result['data']['items'][0]);
        $this->assertArrayHasKey('min_fee', $result['data']['items'][0]);
        $this->assertArrayHasKey('left_num', $result['data']['items'][0]);//剩余次数
        $this->assertArrayHasKey('org_name', $result['data']['items'][0]);
        $this->assertArrayHasKey('range_name', $result['data']['items'][0]);
        $this->assertArrayHasKey('time_limit', $result['data']['items'][0]);
    }
    
    //已使用
    public function testDataUsed($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']= "1";
        $postdata['params']['status']= "1";
        $postdata['params']['userId']="3596";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        //$this->assertEquals('-1', $result['code']);
        $this->assertArrayHasKey('discount_value', $result['data']['items'][0]);
        $this->assertArrayHasKey('min_fee', $result['data']['items'][0]);
        $this->assertEquals('0', $result['data']['items'][0]['left_num']);
        $this->assertArrayHasKey('org_name', $result['data']['items'][0]);
        $this->assertArrayHasKey('range_name', $result['data']['items'][0]);
        $this->assertArrayHasKey('time_limit', $result['data']['items'][0]);
        
    }
    
    
    
}