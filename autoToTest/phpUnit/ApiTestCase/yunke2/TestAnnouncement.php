<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestAnnouncement extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function  setUp()
    {
        $this->url = "http://test.gn100.com/interface/announcement/GetAnnouncement";
        $this->http = new HttpClass();
    } 
    //参数正确，新增公告
    public function testPlanNotice($fkPlan='4332')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['fkPlan']=$fkPlan;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;    
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('4332', $result['result']['fkPlan'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('这是课程公告，希望你们都看得见！东方', $result['result']['content'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['status'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('71', $result['result']['id'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //参数正确，删除公告Plan
    public function testDelNotice($fkPlan='4334')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['fkPlan']=$fkPlan;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEmpty($result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //参数正确，修改公告Plan
    public function testUpdateNotice($fkPlan='4333')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['fkPlan']=$fkPlan;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('4333', $result['result']['fkPlan'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('更新公告内容', $result['result']['content'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['status'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
     
    //fkPlan为空，返回值
    public function testFkPlanIsNull($fkPlan='')
    {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['fkPlan']=$fkPlan;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//缺少必传参数
    }
    
    //fkPlan不存在，返回值
    public function testFkPlanIsNotExist($fkPlan='2342424')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['fkPlan']=$fkPlan;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//获取课程信息失败
        $this->assertEmpty($result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    protected function tearDown()
    {
        unset($this->http);
    }

    
}