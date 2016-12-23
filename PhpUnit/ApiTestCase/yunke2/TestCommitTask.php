<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestCommitTask extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/studentTask/CommitTask";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['fkTask']='8';
        $postdata['params']['uId']='5304';
        //$postdata['params']['desc']='我是杨明娟，这是我的作业哦。。。。能提交成功吗？';
        $postdata['params']['images']['thumb_big']='';
        //$postdata['params']['images']['thumb_small']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //$this->assertEquals('1053', $result['code']);//作业已经提交
    }
    
    protected function tearDown()
    {
        unset($this->http);
    }
}