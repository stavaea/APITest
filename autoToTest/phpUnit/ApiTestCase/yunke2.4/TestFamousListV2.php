<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestFamousListV2 extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //名师列表
        $this->url = "http://test.gn100.com/interface/teacher/famouslistv2";
        $this->http = new HttpClass();
    
    }
    
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['condition']= "0,7,3";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump($result);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('3', count($result['result']['subject']));
        $this->assertArrayHasKey('teacherName', $result['result']['data']['list'][0]);
        $this->assertArrayHasKey('teacherImg', $result['result']['data']['list'][0]);
        $this->assertArrayHasKey('courseCount', $result['result']['data']['list'][0]);
        $this->assertArrayHasKey('commentCount', $result['result']['data']['list'][0]);
        $this->assertArrayHasKey('avgScore', $result['result']['data']['list'][0]);
        $this->assertArrayHasKey('desc', $result['result']['data']['list'][0]);
        $this->assertArrayHasKey('teacherName', $result['result']['data']['list'][0]);
    }
    
    
    //缺少参数
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['condition']= "";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        
        $this->assertEquals(1000, $result['code']);
    }
}