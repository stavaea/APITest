<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestOrgTeacherList extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //机构老师列表
        $this->url = "http://test.gn100.com/interface/org/teacherList";
        $this->http = new HttpClass();
    
    }
    
    //参数正确，返回数据内容
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
        $this->assertEquals('6', count($result['result']['data']));
        $this->assertArrayHasKey('name', $result['result']['data'][0]);
        $this->assertArrayHasKey('thumbMed', $result['result']['data'][0]);
        $this->assertArrayHasKey('score', $result['result']['data'][0]);
        $this->assertArrayHasKey('grade', $result['result']['data'][0]);
        $this->assertArrayHasKey('subjectName', $result['result']['data'][0]);
        $this->assertArrayHasKey('courseTotal', $result['result']['data'][0]);
        var_dump($result['result']['data'][0]);
    }
}