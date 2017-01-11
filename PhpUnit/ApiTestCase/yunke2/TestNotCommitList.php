<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestNotCommitList extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/studentTask/GetNoCommitList";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['taskId']='73';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('pk_task', $result['result']['data'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('desc', $result['result']['data'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('已截止', $result['result']['data']['countdown'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('san', $result['result']['data']['teacherName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('5304', $result['result']['data']['fk_user_teacher'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('http://testf.gn100.com/1,0266abcef015', $result['result']['data']['thumb_big'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('attach', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //$this->assertNotNull($result['result']['tag']);//fail
        $this->assertEquals('152', $result['result']['thumb'][0]['small_width'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    } 
    
    //参数为空，返回值
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['taskId']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key; 
       // var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//缺少必传参数
    }
    
    //参数不存在，返回值
    public function testParamsIsNotExist()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['taskId']='999999';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1051', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//此作业不存在
    }
    
    protected function tearDown()
    {
        unset($this->http);
    }
    
    
}