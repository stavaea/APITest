<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestLive extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/plan/latelyLiveTop";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回的数据节点是否正确
    public function testDataIsOK($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']='';//userId并不影响接口返回结果
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(0, $result['code']);
        $this->assertArrayHasKey('days', $result['result']);
        $this->assertArrayHasKey('cateList', $result['result']);
    }
    
    //判断返回的日期是否本周的所有日期
    public function testDateIsWeek($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        for($i=0;$i<=5;$i++)
        {
            $days=(strtotime(date('Y-m-d'))-strtotime($result['result']['days'][$i]['dayTime']))/(3600*24);
            if(abs($days)<=6)
            {
                $aa='是这个周的';
                $this->assertEquals('是这个周的', $aa);
            }
            else 
            {
                $this->assertEquals('是这个周的', $aa);
            }
            
        }
    }
    
    protected function tearDown()
    {
        unset($this->http);
    }
}