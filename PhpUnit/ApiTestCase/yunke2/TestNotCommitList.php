<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

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
    public function testDataIsOK($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['taskId']='39';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertArrayHasKey('pk_task', $result['result']['data']);
        $this->assertArrayHasKey('desc', $result['result']['data']);
        //$this->assertEquals('假假按揭啊（勿删）', $result['result']['info']['title']);
        $this->assertArrayHasKey('endTimeHandle', $result['result']['data']);
        $this->assertArrayHasKey('teacherName', $result['result']['data']);
        $this->assertEquals('23339', $result['result']['data']['fk_user_teacher']);
        $this->assertArrayHasKey('thumb', $result['result']);
        $this->assertArrayHasKey('attach', $result['result']);
        $this->assertArrayHasKey('tag', $result['result']);
        $this->assertArrayHasKey('info', $result['result']);
    } 
    
    //参数为空，返回值
    public function testParamsIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['taskId']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    }
    
    //参数不存在，返回值
    public function testParamsIsNotExist($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['taskId']='aaa';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1051', $result['code']);//此作业不存在
    }
}