<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestOrgList extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //机构列表
        $this->url = "http://test.gn100.com/interface/org/list";
        $this->http = new HttpClass();
    
    }
    
    //参数正确，返回数据结果(北京市)
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['provinceId']= "1";
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['sort']= "1000";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump($result);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        for($i=0;$i<count($result['result']['data']);$i++)
        {
   
           $this->assertEquals('北京市', $result['result']['data'][$i]['provinceName']);
           $this->assertArrayHasKey('teacherNum', $result['result']['data'][$i]);
           $this->assertArrayHasKey('courseNum', $result['result']['data'][$i]);
           $this->assertArrayHasKey('studnetNum', $result['result']['data'][$i]);
        }
    }
    
    
    //排序，按课程数
    public function testCourseSort()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['provinceId']= "1";
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['sort']= "2000";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertGreaterThanOrEqual($result['result']['data']['3']['courseNum'], $result['result']['data']['0']['courseNum']);
    }
    
    //排序，按老师数
    public function testTeacherSort()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['provinceId']= "1";
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['sort']= "3000";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertGreaterThanOrEqual($result['result']['data']['3']['teacherNum'], $result['result']['data']['0']['teacherNum']);
    }
}