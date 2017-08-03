<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestOrgCourseList extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //机构课程列表
        $this->url = "http://test.gn100.com/interface/org/courseList";
        $this->http = new HttpClass();
    
    }
    
    //参数正确，返回数据
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['orgId']= "231";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //$this->assertEquals('7', count($result['result']['data']));
        $this->assertArrayHasKey('title', $result['result']['data'][0]);
        $this->assertArrayHasKey('thumbMed', $result['result']['data'][0]);
        $this->assertArrayHasKey('subject', $result['result']['data'][0]);
        $this->assertArrayHasKey('userTotal', $result['result']['data'][0]);
        $this->assertArrayHasKey('price', $result['result']['data'][0]);
        $this->assertArrayHasKey('courseType', $result['result']['data'][0]);
        $this->assertArrayHasKey('title', $result['result']['data'][0]);
        
    }
}