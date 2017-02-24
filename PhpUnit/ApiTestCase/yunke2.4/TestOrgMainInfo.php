<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestOrgMainInfo extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //机构首页
        $this->url = "http://dev.gn100.com/interface/org/info";
        $this->http = new HttpClass();
    
    }
    
    
    //传参正确，返回数据
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['orgId']= "84215";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('84215', $result['result']['orgId']);
        $this->assertEquals('http://devf.gn100.com/4,b9afb16aceb0', $result['result']['orgImg']);
        $this->assertEquals('娟娟的机构', $result['result']['name']);
        $this->assertEquals('7', $result['result']['teacherNum']);
        $this->assertEquals('4', $result['result']['courseNum']);
        $this->assertEquals('15510720812', $result['result']['hotline']);
        $this->assertEquals('啊啊啊啊啊啊aa', $result['result']['address']);
        $this->assertEquals('啊啊啊啊啊啊啊啊啊', $result['result']['desc']);
        $this->assertEquals('杨明娟', $result['result']['teacherList'][0]['teacherName']);
        $this->assertEquals('2', count($result['result']['teacherList']));
        $this->assertEquals('http://devf.gn100.com/4,cc7170c2967d', $result['result']['teacherList']['0']['teacherImg']);
        $this->assertArrayHasKey('price', $result['result']['courseList'][0]);
        var_dump(count($result['result']['courseList']));
        
    }
}