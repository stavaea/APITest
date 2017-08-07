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
    static $i;
    static $j;
    static $k;
    
    protected function setUp()
    {
        //老师课表
        $this->url = "http://test.gn100.com/interface/teacher/mytable";
        $this->http = new HttpClass();
    
    }
    
    
    //参数正确，返回数据节点(42天)
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['startTime']= "2017-05-01 00:00:00";
        $postdata['params']['endTime']= "2017-06-11 23:59:59";
        $postdata['params']['userId']='1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
       
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        
        $this->assertEquals('0',$result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //$this->assertEquals('4', count($result['result']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('planId', $result['result'][0]['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('className', $result['result'][0]['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseName', $result['result'][0]['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('status', $result['result'][0]['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
    }
    
    //判断返回的日期是否本周的所有日期
    public function testDateIsWeek()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['startTime']= "2017-06-26 00:00:00";
        $postdata['params']['endTime']= "2017-07-01 23:59:59";
        $postdata['params']['userId']='1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        for($i=0;$i<count($result['result']);$i++)
        {
            $days=(strtotime($result['result'][$i]['time'])-strtotime('2016-12-26'))/(3600*24);
            if(abs($days)<=6)
            {
               $aa='是这个周的';
               $this->assertEquals('是这个周的', $aa,'url:'.$this->url.'   Post data:'.json_encode($postdata));
            }
            else
            {
                $bb='不是这个周的';
                $this->assertEquals('不是这个周的', $bb,'url:'.$this->url.'   Post data:'.json_encode($postdata));
            }
    
        }
     }
     
     
     //startTime=endTime,返回当天课程
     public function testOneDay()
     {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
         $postdata['u']=self::$u;
         $postdata['v']=self::$v;
         $postdata['params']['startTime']= "2017-05-25 00:00:00";
         $postdata['params']['endTime']= "2017-05-25 23:59:59";
         $postdata['params']['userId']='1';
         $key=interface_func::GetAppKey($postdata);
         $postdata['key']=$key;
         //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
         $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
         $this->assertEquals('2017-5-25', $result['result'][0]['time'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
         $this->assertEquals('740', $result['result'][0]['data'][0]['planId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
         $this->assertEquals('ymjtest', $result['result'][0]['data'][0]['courseName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
         
     }
     //当天直播课超过30节课，返回数据开课时间按最近的开始
     public function testOneDayMoreCourse()
     {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
         $postdata['u']=self::$u;
         $postdata['v']=self::$v;
         $postdata['params']['startTime']= "2017-06-08 00:00:00";
         $postdata['params']['endTime']= "2017-06-08 23:59:59";
         $postdata['params']['userId']='1';
         $key=interface_func::GetAppKey($postdata);
         $postdata['key']=$key;
         
         $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
         $this->assertLessThanOrEqual('30', count($result['result'][0]['data']));
         
         for($j=0;$j<count($result['result'][0]['data'])-1;$j++)
         {
             
             $this->assertGreaterThanOrEqual(strtotime($result['result'][0]['data'][$j]['stime']),strtotime($result['result'][0]['data'][$j+1]['stime']));
             
         }   
         
         $this->assertEquals('第15课时', $result['result'][0]['data'][0]['sectionName']);
     }
     
     //必传参数为空，返回数据
     public function testParamsIsNull()
     {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
         $postdata['u']=self::$u;
         $postdata['v']=self::$v;
         $postdata['params']['startTime']= "2017-01-03 00:00:00";
         $postdata['params']['endTime']= "";
         $postdata['params']['userId']='1';
         $key=interface_func::GetAppKey($postdata);
         $postdata['key']=$key;
         //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
         $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
         $this->assertEquals('1000', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//请求参数为空
     } 
     
     
     //status状态校验，是否可以进入播放页(之前和今天的课可以进入)
     public function testCanPCTeacher()
     {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
         $postdata['u']=self::$u;
         $postdata['v']=self::$v;
         $postdata['params']['startTime']= "2017-08-03 00:00:00";
         $postdata['params']['endTime']= "2018-08-10 23:59:59";
         $postdata['params']['userId']='1';
         $key=interface_func::GetAppKey($postdata);
         $postdata['key']=$key;
         
         $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
         if($result['code']!='3002')
         {
             for($k=0;$k<count($result['result']);$k++)
             {
                 if(strtotime(date('Y-m-d'))>=strtotime($result['result'][$k]['time']))
                 {
                     $this->assertEquals('1', $result['result'][$k]['data'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                 }
                 else 
                 {
                     $this->assertEquals('0', $result['result'][$k]['data'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                 }
        
             }
             
             
         }

     }
     
     //线下课，address不为空
     public function testAddressIsNotNull()
     {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
         $postdata['u']=self::$u;
         $postdata['v']=self::$v;
         $postdata['params']['startTime']= "2017-08-03 00:00:00";
         $postdata['params']['endTime']= "2017-08-03 23:59:59";
         $postdata['params']['userId']='1';
         $key=interface_func::GetAppKey($postdata);
         $postdata['key']=$key;
         //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
         $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
         $this->assertEquals('北京市东城区123', $result['result'][0]['data'][1]['address']);
     }
     
     //线下课，status为0，不能进入课堂
     /* public function testAddressStatus()
     {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
         $postdata['u']=self::$u;
         $postdata['v']=self::$v;
         $postdata['params']['startTime']= "2018-08-05 00:00:00";
         $postdata['params']['endTime']= "2018-08-05 23:59:59";
         $postdata['params']['userId']='1';
         $key=interface_func::GetAppKey($postdata);
         $postdata['key']=$key;
         //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
         $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
         $this->assertEquals('0', $result['result'][0]['data'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
     } */
     
     
}