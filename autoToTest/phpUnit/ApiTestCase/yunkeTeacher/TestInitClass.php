<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestInitClass extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    public $Token;
    
    protected function setUp()
    {
        //初始化上课接口（点击进入详情页拿到所有需要的数据）
        $this->url = "http://test.gn100.com/interface/play/planinfo";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
    }
    
    
    
    //缺少参数，返回结果
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['planId']= "";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->Token->testUserTokenGenIsSuccess('1');
        $postdata['token']=$token;
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1000', $result['code']);//请求参数为空
    }
    
     //参数正确，返回数据节点
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['planId']= '4606';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->Token->testUserTokenGenIsSuccess('1');
        $postdata['token']=$token;
        var_dump($token);
       // var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertArrayHasKey('stream', $result['result']);
        $this->assertArrayHasKey('plan', $result['result']);
        $this->assertArrayHasKey('announcement', $result['result']);
        $this->assertArrayHasKey('question', $result['result']);
        $this->assertArrayHasKey('share', $result['result']);
        
    }
    
    /*
    //参数正确，第一次进入直播页面，无公告，返回结果
    public function testOneLiveNotAnnoucement()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['planId']= "3596";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
    }
    
    
    //参数正确，再次进入播放页面，有公告，返回结果
    public function testLiveAnnoucement()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['planId']= "3596";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
    }
    
    
    //参数正确，无备课返回值
    public function testNotQuestion()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['planId']= "3596";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
    }
     */
    
    
}