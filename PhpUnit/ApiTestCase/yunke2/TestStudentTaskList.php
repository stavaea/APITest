<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
class TestStudentTaskList extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/studentTask/StudentTaskList";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['status']='0';//未提交
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertArrayHasKey('page', $result['result']);
        $this->assertArrayHasKey('data', $result['result']);
    }
    
    //未提交作业，排序按发布作业日期
    public function testNotCommitSort()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['status']='0';//未提交
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        if($result['result']['page']['total']>1)
        {
           $this->assertGreaterThanOrEqual($result['result']['data'][1]['day'], $result['result']['data'][0]['day']);
        }
        
    }
    
    //已批改作业，排序按提交作业日期
    public function testNReplySort()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['status']='2';//未批改
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        var_dump($result['result']['data'][0]['days'][0]['reply_time']);
        if($result['result']['page']['total']>1)
        {
            $this->assertGreaterThanOrEqual($result['result']['data'][1]['days'][0]['reply_time'], $result['result']['data'][0]['days'][0]['reply_time']);
        }
    
    }
    
    //必填参数为空，返回值
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['page']='1';
        $postdata['params']['status']='0';//未提交
        $postdata['params']['uId']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必填参数
        
    }
    
    //status为空，返回值,默认是status=0
    public function testStatusIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['page']='1';
        $postdata['params']['status']='';//未提交
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('4', $result['result']['data'][0]['days'][0]['student_status']);
    }
    
    //page参数很大，返回值
    public function testPageIsBig()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['page']='-1';
        $postdata['params']['status']='0';//未提交
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1054', $result['code']);//作业列表为空
    }
    
    //status不存在时，返回值
    public function testStatusIsNotExist()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['status']='3';//未提交
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEmpty($result['result']['data']);
    }
}