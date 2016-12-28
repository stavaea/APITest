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
        $postdata['params']['uid']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
         //$result=$this->http->HttpPost($this->url, json_encode($postdata));
        $result2=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        
        $this->assertArrayHasKey('typeId', $result2['result'][0]);
        
        $this->assertArrayHasKey('type', $result2['result'][0]);
        
        $this->assertArrayHasKey('teachers', $result2['result'][0]);
        
        $this->assertArrayHasKey('originName', $result2['result'][0]['teachers'][0]);
        
        $this->assertArrayHasKey('score', $result2['result'][0]['teachers'][0]);
        $this->assertArrayHasKey('counts', $result2['result'][0]['teachers'][0]);
        $this->assertArrayHasKey('lessons', $result2['result'][0]['teachers'][0]);
    }
    //参数正确，分类最多返回10条数据
    public function testDataIsLeastTen()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertLessThanOrEqual(10, count($result['result'][0]['teachers']));
        
    }
    
    //参数正确，返回数据由评论由高到低排序
    public function testCountSort()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertLessThanOrEqual($result['result'][0]['teachers'][1]['counts'], $result['result'][0]['teachers'][2]['counts']);
    }
    
    protected function tearDown()
    {
        unset($this->http);

    }
    
}