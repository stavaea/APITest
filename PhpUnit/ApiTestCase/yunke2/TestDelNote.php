<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestDelNote extends PHPUnit_Framework_TestCase
{
    
    static $url="http://test.gn100.com/interface/note/DelNote";
    //private $http;
    static $u="i";
    static $v="2";
    static $noteId;
    
    /* protected function setUp()
    {
        
        //笔记删除
        $this->url = "http://test.gn100.com/interface/note/DelNote";
        $this->http = new HttpClass();
        
    } */  
    //---------------------删除笔记功能---------------------------------------
    
    //传参正确，返回节点数据是否正确
    
      public static function testDelDataIsOK($noteId)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $url2=self::$url;
        $postdata['params']['planId']='3724';
        $postdata['params']['videoStatus']='2';
        $postdata['params']['noteId']=$noteId;
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost($url2, json_encode($postdata)),true);
        self::assertEquals('0', $result['code']);//操作成功
         
    } 
    
    //必填参数为空，返回值
     public function testDelParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['planId']='3724';
        $postdata['params']['videoStatus']='2';
        $postdata['params']['noteId']='';
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    } 
    
    
}
