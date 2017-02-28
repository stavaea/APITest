<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestCheckNote extends PHPUnit_Framework_TestCase
{
    static $url="http://test.gn100.com/interface/note/NoteList";
    static $u="i";
    static $v="2";
    static $noteId;
    
    
    
    
    //---------------------笔记列表功能---------------------------------------
     public static function testListDataIsOK($noteId)
    {
        
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
        self::assertEquals('0', $result['code'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals($noteId, $result['result']['items'][0]['id'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertArrayHasKey('courseId', $result['result']['items'][0],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertArrayHasKey('planId', $result['result']['items'][0],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertArrayHasKey('userId', $result['result']['items'][0],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertArrayHasKey('status', $result['result']['items'][0],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('1：55', $result['result']['items'][0]['content'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('123', $result['result']['items'][0]['playTimeTmp'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('00:02:03', $result['result']['items'][0]['playTimeFormat'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
       
        
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
        self::assertEquals('0', $result['code'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals($noteId, $result['result']['items'][0]['id'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('2：55', $result['result']['items'][0]['content'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('123', $result['result']['items'][0]['playTimeTmp'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('00:02:03', $result['result']['items'][0]['playTimeFormat'],'url:'.self::$url.'   Post data:'.json_encode($postdata));

    }
    
}