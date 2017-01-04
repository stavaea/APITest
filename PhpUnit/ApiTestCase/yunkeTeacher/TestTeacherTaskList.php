<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestTeacherTaskList extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //老师作业列表
        $this->url = "http://test.gn100.com/interface/teacherTask/TaskList";
        $this->http = new HttpClass();
    
    }
    
    //参数正确，返回数据
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']= "1";
        $postdata['params']['uId']= "23339";
        $postdata['params']['status']='0';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1', $result['result']['page']);
        $this->assertEquals('8', $result['result']['pageSize']);
        $this->assertEquals('20', $result['result']['limit']);
        $this->assertEquals('8', $result['result']['totalSize']);    
    }
    
    
    //uId为空，返回错误码
    public function testUIdIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']= "1";
        $postdata['params']['uId']= "";
        $postdata['params']['status']='0';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
        
        
    }
    
    
    //status不存在，返回结果
    public function testStatusIsNotExist()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']= "1";
        $postdata['params']['uId']= "23339";
        $postdata['params']['status']='5';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //$this->assertEquals('1001', $result['code']);//缺少必传参数
    }
}