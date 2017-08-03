<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestStudentList extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //学生列表
        $this->url = "http://test.gn100.com/interface/course/student";
        $this->http = new HttpClass();
    
    }
    
    
    //参数正确，返回数据节点
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['courseId']= "1101";
        $postdata['params']['classId']= '1277';//2班：1385
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('13', count($result['result']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('李胜红', $result['result'][0]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
    }
    //缺少必传参数
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['courseId']= "1101";
        $postdata['params']['classId']= '';//2班：1385
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1008', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    //classId不存在，返回值
    public function testClassIdIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['courseId']= "1101";
        $postdata['params']['classId']= '11111111';//2班：1385
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEmpty($result['result']);
    }
    
    //报名人数有500人
    public function testStudentNumIsBig()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['courseId']= "1186";
        $postdata['params']['classId']= '1389';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump(count($result['result']));
        
    }
    
}