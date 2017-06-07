<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';

class TestLiveTable extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    static  $u="i";
    static  $v="2";
    
    protected function setUp()
    {
        //小沃直播列表
        $this->url="http://dev.gn100.com/interface/plan/LiveTable";
        $this->http = new HttpClass();
    }
    
    public function testDataIsOK($oid="842")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']= "159";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
       if($result['result'][1]!=NULL)
       {
           $this->assertArrayHasKey('trys', $result['result'][1]['data'][0]);
           $this->assertArrayHasKey('courseName', $result['result'][1]['data'][0]);
           $this->assertArrayHasKey('sectionName', $result['result'][1]['data'][0]);
           $this->assertArrayHasKey('stime', $result['result'][1]['data'][0]);
           $this->assertArrayHasKey('price', $result['result'][1]['data'][0]);//新增课程价格
       }
           
    }
    
    
    //判断返回的日期是否本周的所有日期
    public function testDateIsWeek($oid='842')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['userId']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        for($i=0;$i<=5;$i++)
        {
        $days=(strtotime(date('Y-m-d'))-strtotime($result['result'][$i]['time']))/(3600*24);
        if(abs($days)<=6)
        {
        $aa='是这个周的';
        $this->assertEquals('是这个周的', $aa,'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
        else
        {
            $this->assertEquals('是这个周的', $aa,'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
    
        }
        }
}