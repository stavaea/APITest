<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestLiveListInfo extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/plan/latelyLiveList";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回的数据节点是否正确
    public function testDataIsOK($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']='';//不必传
        $postdata['params']['sTime']='2017-01-04';//开始时间
        $postdata['params']['page']='1';//页数
        $postdata['params']['length']='20';//每页的长度
        $postdata['params']['cateId']='7';//
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;//此key值必须放到后面，要不然会验证失败
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('isSign', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseId', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('planId', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('className', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('classId', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('trys', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseName', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseImg', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('sectionName', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('status', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('stime', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    

    //参数正确，返回的直播课信息正确
    public function testLiveCourseInfo($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']='';//不必传
        $postdata['params']['sTime']='2017-06-06';//开始时间
        $postdata['params']['page']='1';//页数
        $postdata['params']['length']='20';//每页的长度
        $postdata['params']['cateId']='7';//
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;//此key值必须放到后面，要不然会验证失败
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['result']['data'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1195', $result['result']['data'][0]['courseId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('4511', $result['result']['data'][0]['planId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1班', $result['result']['data'][0]['className'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1399', $result['result']['data'][0]['classId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['data'][0]['trys'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('今日直播', $result['result']['data'][0]['courseName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('第1课时', $result['result']['data'][0]['sectionName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['data'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('10:30', $result['result']['data'][0]['stime'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    
    
    //参数正确，返回当天课程信息正确
    
    
    //sTime为2016-11-25，没有直播课程
    public function testDataIsNull($oid='0')
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
        $this->assertEquals('3002', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
    }
    protected function tearDown()
    {
        unset($this->http);

    }
}