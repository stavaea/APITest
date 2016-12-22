<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestStudentTaskDetail extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/studentTask/StudentTaskDetail";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTaskStudent']='15';
        $postdata['params']['uId']='23339';
    
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('34', $result['result']['commit']['data']['fk_task']);
        $this->assertEquals('我是杨明娟。。。。。。', $result['result']['commit']['data']['desc']);
        $this->assertEquals('2016-10-18 11:38:26', $result['result']['commit']['data']['last_updated']);
        //var_dump($result['result']['publish']['tag'][0]['name']);//tag这个值有的时候有，有的时候没有
        //$this->assertEquals('', $result['result']['publish']['tag']);
        //$this->assertEquals('6,b7c667ea9e19', $result['result']['commit']['thumb'][0]['thumb_big']);
        $this->assertEquals('杨明娟', $result['result']['taskInfo']['teacherName']);
    }
    
    
    //pkTaskStudent参数为空，返回值
    public function testpkTaskStudentIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['pkTaskStudent']='';
        $postdata['params']['uId']='23339';
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    }
    
    //pkTaskStudent参数不存在，返回值
    public function testpkTaskStudentIsNotExsit()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['pkTaskStudent']='-1';
        $postdata['params']['uId']='23339';
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1051', $result['code']);//此作业不存在
    }
    
    //uId为空或者是pk=142，返回值
    public function testuIdIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['pkTaskStudent']='142';
        $postdata['params']['uId']='23339';
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1052', $result['code']);//不是此学生作业
    }
    
}