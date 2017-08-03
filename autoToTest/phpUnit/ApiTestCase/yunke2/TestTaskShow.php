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
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('2016-11-14 星期一 17:07', $result['result']['reply']['data']['lastUpdatedHandle'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('4', $result['result']['reply']['data']['level'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('11-14 16:26', $result['result']['publish']['data']['startTimeHandle'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('taskInfo', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
      
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
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1052', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//不是此学生作业
    }
    
    protected function tearDown()
    {
        unset($this->http);
    }
}