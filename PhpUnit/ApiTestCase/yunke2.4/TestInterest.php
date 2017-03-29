<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestInterest extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //兴趣列表
        $this->url = "http://dev.gn100.com/interface/config/interest";
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
        
        $this->assertEquals('小学', $result['result'][0]['data']['name']);
        $this->assertEquals('10', count($result['result'][0]['data']['data']));
        $this->assertEquals('初中', $result['result'][1]['data']['name']);
        $this->assertEquals('6', count($result['result'][1]['data']['data']));
        $this->assertEquals('高中', $result['result'][2]['data']['name']);
        $this->assertEquals('6', count($result['result'][2]['data']['data']));
    }
}