<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestTeacherTable extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //老师课表
        $this->url = "http://test.gn100.com/interface/teacher/mytable";
        $this->http = new HttpClass();
    
    }
    
    
    //参数正确，返回数据节点
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['startTime']= "2016-12-01";
        $postdata['params']['endTime']= "2017-01-08";
        $postdata['params']['userId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        
        $this->assertEquals('0',$result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //$this->assertEquals('4', count($result['result']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('planId', $result['result'][0]['data'][0]);
        $this->assertArrayHasKey('className', $result['result'][0]['data'][0]);
        $this->assertArrayHasKey('courseName', $result['result'][0]['data'][0]);
        $this->assertArrayHasKey('status', $result['result'][0]['data'][0]);
        
    }
    
    //判断返回的日期是否本周的所有日期
    public function testDateIsWeek()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['startTime']= "2016-12-26";
        $postdata['params']['endTime']= "2017-01-01";
        $postdata['params']['userId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        for($i=0;$i<=count($result['result']);$i++)
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
     
     
     //startTime=endTime,返回当天课程
     public function testOneDay()
     {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
         $postdata['u']=self::$u;
         $postdata['v']=self::$v;
         $postdata['params']['startTime']= "2016-12-29";
         $postdata['params']['endTime']= "2016-12-29";
         $postdata['params']['userId']='23339';
         $key=interface_func::GetAppKey($postdata);
         $postdata['key']=$key;
         var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
         $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
     }
     //
}