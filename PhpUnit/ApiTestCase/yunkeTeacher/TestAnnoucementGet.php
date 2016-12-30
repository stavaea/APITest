<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestAnnouncementGet extends PHPUnit_Framework_TestCase
{
    static $url =  "http://test.gn100.com/interface/announcement/GetAnnouncement ";
    static $u="i";
    static $v="2";
    static $planId;

    
    
    //公告获取是否正确
    public static function testAnnouceDataIsOK($planId)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['fkPlan']=$planId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);

        self::assertEquals('0',$result['code'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals($planId, $result['result']['fkPlan'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('测试一下公告哦', $result['result']['content'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('1', $result['result']['status'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
    }
    
    //更改公告之后数据
    public static function testAnnouceUpdateDataIsOK($planId)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['fkPlan']=$planId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
    
        self::assertEquals('0',$result['code'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals($planId, $result['result']['fkPlan'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('我更改一下公告哦', $result['result']['content'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        self::assertEquals('1', $result['result']['status'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
    }
    
    //删除公告之后数据结果
    
    public static function testAnnouceDelDataIsOK($planId)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['fkPlan']=$planId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
        
         self::assertEmpty($result['result'],'url:'.self::$url.'   Post data:'.json_encode($postdata));
        
    }

}