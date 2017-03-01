<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestGetRegion extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //最近直播头部，地区
        $this->url = "http://test.gn100.com/interface/config/getRegion";
        $this->http = new HttpClass();
    
    }
    
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['']= "";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertEquals('12', count($result['result']));
    }
}