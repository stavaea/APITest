<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestMain extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/main/homev2";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='34,35,36';//云课2的兴趣选择是在定制中，此参数在此没有用
        $postdata['params']['uid']='159';//3596
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($postdata);
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(0, $result['code']);
        //比对是否存在相应的节点数据
        $this->assertArrayHasKey('ad',$result['result']);
        $this->assertArrayHasKey('types',$result['result']);
        $this->assertArrayHasKey('lives',$result['result']);
        $this->assertArrayHasKey('interests',$result['result']);
        $this->assertArrayHasKey('recommends',$result['result']);
    }
    
    
    
    
    /*参数正确，推荐课程最多四门课程
    public function testRecommendsMoreFour()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='34,35,36';//云课2的兴趣选择是在定制中，此参数在此没有用
        $postdata['params']['uid']='159';//3596
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
       // var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(0, $result['code']);
        var_dump(count($result['result']['recommends'][0]['list']));
        $this->assertLessThanOrEqual('4', count($result['result']['recommends'][0]['list']));
    }
    */
}