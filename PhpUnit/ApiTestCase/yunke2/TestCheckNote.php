<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestCheckNote extends PHPUnit_Framework_TestCase
{
    static $url="http://test.gn100.com/interface/note/NoteList";
    //private $http;
    static $u="i";
    static $v="2";
    static $noteId;
    
    /* protected function setUp()
    {
       
        //笔记列表
        //$this->url = "http://test.gn100.com/interface/note/NoteList";
        //$this->http = new HttpClass();
    } */
    
    
    
    //---------------------笔记列表功能---------------------------------------
     public static function testListDataIsOK($noteId)
    {
        //var_dump($noteId);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $url2=self::$url;
        $postdata['params']['planId']='3724';
        $postdata['params']['videoStatus']='2';
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump(HttpClass::HttpPost($url2, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost($url2, json_encode($postdata)),true);
        self::assertEquals('0', $result['code']);
        self::assertEquals($noteId, $result['result']['items'][0]['id']);
        self::assertArrayHasKey('courseId', $result['result']['items'][0]);
        self::assertArrayHasKey('planId', $result['result']['items'][0]);
        self::assertArrayHasKey('userId', $result['result']['items'][0]);
        self::assertArrayHasKey('status', $result['result']['items'][0]);
        self::assertEquals('啊哈哈哈哈', $result['result']['items'][0]['content']);
        self::assertEquals('123', $result['result']['items'][0]['playTimeTmp']);
        self::assertEquals('00:02:03', $result['result']['items'][0]['playTimeFormat']);
       
        
    } 
    
    public static function testUpdateListDataIsOK($noteId)
    {
        //var_dump($noteId);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $url2=self::$url;
        $postdata['params']['planId']='3724';
        $postdata['params']['videoStatus']='2';
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump(HttpClass::HttpPost($url2, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost($url2, json_encode($postdata)),true);
        self::assertEquals('0', $result['code']);
        self::assertEquals($noteId, $result['result']['items'][0]['id']);
        self::assertEquals('我修改了内容哦', $result['result']['items'][0]['content']);
        self::assertEquals('123', $result['result']['items'][0]['playTimeTmp']);
        self::assertEquals('00:02:03', $result['result']['items'][0]['playTimeFormat']);
         
    
    }
    
    //必填参数为空，返回值
      public function testListParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['planId']='3724';
        $postdata['params']['videoStatus']='2';
        $postdata['params']['uId']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);
        
    }  
}