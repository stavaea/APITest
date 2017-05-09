<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestHomeV3 extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //首页
        $this->url = "http://test.gn100.com/interface/main/homev3";
        $this->http = new HttpClass();
    
    }
    
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']= "3596";
        $postdata['params']['condition']= "1,7,29";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertArrayHasKey('banner', $result['result']);
        $this->assertEquals('3', count($result['result']['subject']));
        $this->assertEquals('直播课', $result['result']['types'][0]['name']);
        $this->assertEquals('录播课', $result['result']['types'][1]['name']);
        $this->assertEquals('免费课', $result['result']['types'][2]['name']);
        $this->assertArrayHasKey('userWillPlan', $result['result']);
        $this->assertArrayHasKey('courseName', $result['result']['trySeeList'][0]['list'][0]);
        $this->assertArrayHasKey('stime', $result['result']['trySeeList'][0]['list'][0]);
        $this->assertArrayHasKey('sectionName', $result['result']['trySeeList'][0]['list'][0]);
        if(count($result['result']['trySeeList'])!=0)
        {
            for($i=0;$i<count($result['result']['trySeeList'])-1;$i++)
            {
                   $this->assertGreaterThanOrEqual(strtotime($result['result']['trySeeList'][$i+1]['time']), strtotime($result['result']['trySeeList'][$i]['time']));
            }
        } 
        $this->assertArrayHasKey('courseName', $result['result']['courseList'][0]);
        $this->assertArrayHasKey('subname', $result['result']['courseList'][0]);
        if(count($result['result']['courseList'])!=0)
        {
            $this->assertArrayHasKey('courseName', $result['result']['courseList'][0]);
            $this->assertArrayHasKey('subname', $result['result']['courseList'][0]);
            for($j=0;$j<count($result['result']['courseList'])-1;$j++)
            {
                  $this->assertGreaterThanOrEqual($result['result']['courseList'][$j+1]['userTotal'], $result['result']['courseList'][$j]['userTotal']);
            }
        }
        
        
        
    }
    
    
}