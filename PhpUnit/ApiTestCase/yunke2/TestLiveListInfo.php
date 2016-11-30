<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestLiveListInfo extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://dev.gn100.com/interface/plan/latelyLiveList";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回的数据节点是否正确
    public function testDataIsOK($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']='';//不必传
        $postdata['params']['sTime']='2016-11-11';//开始时间
        $postdata['params']['page']='1';//页数
        $postdata['params']['length']='20';//每页的长度
        $postdata['params']['cateId']='8';//
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;//此key值必须放到后面，要不然会验证失败
        
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertArrayHasKey('isSign', $result['result']['data'][0]);
        $this->assertArrayHasKey('courseId', $result['result']['data'][0]);
        $this->assertArrayHasKey('stime', $result['result']['data'][0]);
    }
    
    //sTime为2016-11-25，没有直播课程
    public function testDataIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']='';//不必传
        $postdata['params']['sTime']='2016-11-25';//开始时间
        $postdata['params']['page']='1';//页数
        $postdata['params']['length']='20';//每页的长度
        $postdata['params']['cateId']='9';//
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('3002', $result['code']);
        
    }
}