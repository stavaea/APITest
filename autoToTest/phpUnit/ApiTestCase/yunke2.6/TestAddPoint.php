<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';

class TestAddPoint extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    static  $u="i";
    static  $v="2";
    
    
    protected function setUp()
    {
        //添加积分经验值
        $this->url="http://test.gn100.com/interface/point/AddPoint";
        $this->http = new HttpClass();
    
    }
    //笔记增加2经验值，0积分
    /* public function testNote()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['type']= '5';
        $postdata['params']['uId']= '23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump($result);
        $this->assertEquals('2', $result['result']['add_score']);
        $this->assertEquals('0', $result['result']['add_point']);
    } */
    
    
    //答题卡增加0经验值，1积分
    public function testAnswerCard()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['type']= '6';
        $postdata['params']['uId']= '23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertEquals('0', $result['result']['add_score']);
        $this->assertEquals('1', $result['result']['add_point']);
    }
    
    
    
    //提交作业增加2经验值，2积分
    public function testCommitTask()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['type']= '7';
        $postdata['params']['uId']= '23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertEquals('2', $result['result']['add_score']);
        $this->assertEquals('2', $result['result']['add_point']);
    }
    
    
    
    //报名付费课增加2经验值，2积分
    public function testCourseBaoming()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['type']= '8';
        $postdata['params']['uId']= '23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertEquals('2', $result['result']['add_score']);
        $this->assertEquals('2', $result['result']['add_point']);
    }
    
    //缺少必传参数，返回值
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['type']= '8';
        $postdata['params']['uId']= '';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
//         var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
//         var_dump($result);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
        
    }
}