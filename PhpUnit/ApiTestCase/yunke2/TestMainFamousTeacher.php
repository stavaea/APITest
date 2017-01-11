<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestMainFamousTeacher extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/teacher/famousList";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回数据节点是否正确
    public  function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']='22410';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
         //$result=$this->http->HttpPost($this->url, json_encode($postdata));
        $result2=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertArrayHasKey('typeId', $result2['result'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
        $this->assertArrayHasKey('type', $result2['result'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
        $this->assertArrayHasKey('teachers', $result2['result'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
        $this->assertArrayHasKey('originName', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
        $this->assertArrayHasKey('score', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('counts', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('lessons', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    //参数正确，分类最多返回10条数据
    public function testDataIsLeastTen()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']='22410';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertLessThanOrEqual(10, count($result['result'][0]['teachers']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
    }
    
    //参数正确，返回数据由评论由高到低排序
    public function testCountSort()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']='22410';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertLessThanOrEqual($result['result'][1]['teachers'][0]['counts'], $result['result'][1]['teachers'][1]['counts'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    protected function tearDown()
    {
        unset($this->http);

    }
    
}