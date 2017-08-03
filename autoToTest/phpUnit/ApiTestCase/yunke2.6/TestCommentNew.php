<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';

class TestCommentNew extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    static  $u="i";
    static  $v="2";
    
    
    protected function setUp()
    {
        //老师评论列表
        $this->url="http://test.gn100.com/interface/teacher/CommentNew";
        $this->http = new HttpClass();

    }
    //参数正确，返回结果
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['teacherId']= '23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('userName', $result['result']['list'][0]);
        $this->assertArrayHasKey('thumbMed', $result['result']['list'][0]);
        $this->assertArrayHasKey('comment', $result['result']['list'][0]);
        $this->assertArrayHasKey('className', $result['result']['list'][0]);
        $this->assertArrayHasKey('time', $result['result']['list'][0]);
        $this->assertArrayHasKey('sectionName', $result['result']['list'][0]);
        $this->assertArrayHasKey('score', $result['result']['list'][0]);
        $this->assertArrayHasKey('replay', $result['result']['list'][0]);
    }
    
    
    
    
    //必传参数为空，返回结果
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['teacherId']= '';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        
        $this->assertEquals('1000', $result['code']);//请求参数为空
        
    }
}