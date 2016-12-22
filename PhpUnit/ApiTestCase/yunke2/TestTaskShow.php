<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
class TestTaskShow extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/studentTask/TaskShow";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['fkTaskStudent']='75';
        $postdata['params']['uId']='23339';
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('2016-11-14 星期一 17:07', $result['result']['reply']['data']['lastUpdatedHandle']);
        $this->assertEquals('4', $result['result']['reply']['data']['level']);
        $this->assertEquals('11-14 16:26', $result['result']['publish']['data']['startTimeHandle']);
        $this->assertArrayHasKey('taskInfo', $result['result']);
      
        //$this->assertNotEmpty(count($result['result']['publish']['tag']));
    }
    
    //必传参数为空，返回值
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['fkTaskStudent']='75';
        $postdata['params']['uId']='';
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1052', $result['code']);//不是此学生作业
    }
}