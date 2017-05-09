<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestGetDetailNoteList extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    
    protected function setUp()
    {
        //详情页笔记筛选
        $this->url = "http://test.gn100.com/interface/note/GetDetailNoteList";
        $this->http = new HttpClass();
    
    }
    
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['fkUser']= "23339";
        $postdata['params']['classId']= "1521";
        $postdata['params']['planId']= "";//5101  5103
        $postdata['params']['page']= "1";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('content', $result['result']['items'][0]);
        $this->assertArrayHasKey('hidden', $result['result']['items'][0]);
        $this->assertArrayHasKey('tailor', $result['result']['items'][0]);
        $this->assertArrayHasKey('date', $result['result']['items'][0]);
        $this->assertArrayHasKey('time', $result['result']['items'][0]);
        $this->assertArrayHasKey('playTime', $result['result']['items'][0]);
        $this->assertArrayHasKey('playTimeTmpHandle', $result['result']['items'][0]);
        $this->assertArrayHasKey('playTimeFormat', $result['result']['items'][0]);
        $this->assertArrayHasKey('planId', $result['result']['items'][0]);
        $this->assertArrayHasKey('selectName', $result['result']['items'][0]);
    }
    
    
    //传planId，筛选后的数据
    public function testDataPlanId()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['fkUser']= "23339";
        $postdata['params']['classId']= "1521";
        $postdata['params']['planId']= "5101";//5101  5103
        $postdata['params']['page']= "1";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        for($i=0;$i<count($result['result']['items']);$i++)
        {
            $this->assertEquals('5101', $result['result']['items'][$i]['planId']);
        }
        
    }
    
    //参数planId不存在，返回值
    public function testPlanIdIsNotExist()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['fkUser']= "23339";
        $postdata['params']['classId']= "1521";
        $postdata['params']['planId']= "aaaaa";//5101  5103
        $postdata['params']['page']= "1";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(NULL,$result['result']);
    }
}