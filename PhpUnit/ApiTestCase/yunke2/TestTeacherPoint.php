<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestTeacherPoint extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/video/GetTeacherPoint";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['planId']='3724';
        $postdata['params']['rtime']='0';
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('9', $result['result']['items'][0]['pTime']);
        $this->assertEquals('视频打点1', $result['result']['items'][0]['content']);
        $this->assertEquals('9', $result['result']['items'][0]['playTimeTmpHandle']);
        $this->assertEquals('00:00:09', $result['result']['items'][0]['playTimeFormat']);
        
    }
    
    //planId为空，返回值
    public function testPlanIdIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['planId']='';
        $postdata['params']['rtime']='0';
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    }
    
    //planId不存在，返回值
    public function testPlanIdIsNotExist()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['planId']='00000';
        $postdata['params']['rtime']='0';
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//缺少必传参数
    }
    
    
    //被剪辑后视频打点信息,视频被剪辑掉了前3分钟
    public function testVideoEdit()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
    
        $postdata['params']['planId']='3725';
        $postdata['params']['rtime']='0';
    
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('360', $result['result']['items'][0]['pTime'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('视频3', $result['result']['items'][0]['content'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('180', $result['result']['items'][0]['playTimeTmpHandle'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('00:03:00', $result['result']['items'][0]['playTimeFormat'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    protected function tearDown()
    {
        unset($this->http);
    }
}