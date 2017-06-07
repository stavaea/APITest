<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestCourseSearch extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $oid;
    
    
    protected function setUp()
    {
        //小沃1.5课程搜索
        $this->url = "http://dev.gn100.com/interface/search/CourseSearch";
        $this->http = new HttpClass();
    
    }
    
    public function testDataIsOK($oid="842")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['keywords']= "0926直播课测试";
        $postdata['params']['sort']= "1";//此参数老版本在用，这个版本不用
        $postdata['params']['type']= "1";
        $postdata['params']['condition']= "9,41,";//高中 高二 全部
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertEquals('0926直播课测试', $result['result']['data'][0]['title']);
    }
    
    
    //keywords不存在，返回值
    public function testKeywordsIsNotExist($oid="842")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['keywords']= "lalalalallalalalalaallalalalallalal";
        $postdata['params']['sort']= "1";//此参数老版本在用，这个版本不用
        $postdata['params']['type']= "2";//此参数老版本在用，这个版本不用
        $postdata['params']['condition']= "9,41,";//高中 高二 全部
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertEquals('3002', $result['code']);//获取数据失败
    }
    
    //keywords带有特殊字符，返回结果
    public function testKeywordsIsEng($oid='842')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['keywords']= "直播课-170418";//中间层搜索不准确
        $postdata['params']['sort']= "1";//此参数老版本在用，这个版本不用
        $postdata['params']['type']= "1";
        $postdata['params']['condition']= "";//
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
    }
}