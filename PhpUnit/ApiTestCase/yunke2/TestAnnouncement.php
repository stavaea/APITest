<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestAnnouncement extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function  setUp()
    {
        $this->url = "http://dev.gn100.com/interface/announcement/Announcement";
        $this->http = new HttpClass();
    }
 //-------------------增加/更新公告---------------------------   
    //参数正确，返回节点是否正确
    public function testDataIsOK($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['status']='1';
        $postdata['params']['fkPlan']='8429';
        $postdata['params']['content']='测试一下公告哦';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);;
    }
    
    
    //fkPlan为空，返回值
    public function testFkPlanIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['status']='1';
        $postdata['params']['fkPlan']='';
        $postdata['params']['content']='测试一下公告哦';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    }
    
    //fkPlan不存在，返回值
    public function testFkPlanIsNotExist($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['status']='1';
        $postdata['params']['fkPlan']='8888';
        $postdata['params']['content']='测试一下公告哦';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('2017', $result['code']);//获取课程信息失败
    }
    
    //content为空，返回值
    public function testContentIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['status']='1';
        $postdata['params']['fkPlan']='8429';
        $postdata['params']['content']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    }
    
    
    //-------------------删除公告---------------------------
    //参数正确，返回节点是否正确
    public function testDelDataIsOK($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['status']='2';
        $postdata['params']['fkPlan']='8429';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
    
        $result1=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result1['code']);//删除成功
        $result2=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1', $result2['code']);//操作失败
    }
    
    //参数fkPlan不存在，返回值
    
    public function testDelfkPlanIsNotExisit($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['status']='2';
        $postdata['params']['fkPlan']='888888888';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
    
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('2017', $result['code']);//获取课程信息失败
    }
}