<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestUpdateNote extends PHPUnit_Framework_TestCase
{
    static $url="http://test.gn100.com/interface/note/UpdateNote";
   // private $http;
    static $u="i";
    static $v="2";
    static $content;
    static $noteId;
    
   /*  protected function setUp()
    {
        
        //笔记修改
        $this->url = "http://test.gn100.com/interface/note/UpdateNote";
        $this->http = new HttpClass();
        
    } */
    
 
    
    //---------------------修改笔记功能---------------------------------------
      public static function testUpdateData($noteId,$content)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $url2=self::$url;
        $postdata['params']['planId']='3724';
        $postdata['params']['videoStatus']='2';
        $postdata['params']['noteId']=$noteId;
        $postdata['params']['content']=$content;
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost($url2, json_encode($postdata)),true);
        self::assertEquals('0', $result['code'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
    } 
    
    
    
    
    
   
}