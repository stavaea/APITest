<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';

class TestXiaoWoDetail extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    static  $u="i";
    static  $v="2";
    
    protected function setUp()
    {
        //小沃老师详情
        $this->url="http://test.gn100.com/interface/teacher/xiaoWoDetail";
        $this->http = new HttpClass();
    }
    
    public function testDataIsOK($oid="227")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']= "22392";
        $postdata['params']['teacherId']= "22392";
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
       // var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('杨红月', $result['result']['info']['name']);
        $this->assertEquals('http://testf.gn100.com/1,29705754b23b', $result['result']['info']['thumbMed']);
        $this->assertArrayHasKey('userTotal', $result['result']['info']);
        $this->assertArrayHasKey('courseCount', $result['result']['info']);
        $this->assertArrayHasKey('courseTotalTime', $result['result']['info']);
        $this->assertArrayHasKey('taughtGrade', $result['result']['info']);
        $this->assertArrayHasKey('subject', $result['result']['info']);
        $this->assertArrayHasKey('plan', $result['result']);
        $this->assertArrayHasKey('course', $result['result']);//分销课
        
    }
    
    
    //缺少参数
    public function testParamsIsNull($oid="227")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']= "";
        $postdata['params']['teacherId']= "";
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals('1000', $result['code']);//请求参数为空
    }
}