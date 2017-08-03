<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestCourseAttachList extends PHPUnit_Framework_TestCase
{
private $url;
private $http;
static $u='i';
static $v=2;

    protected function setUp()
    {
        $this->url='http://test.gn100.com/interface/course/AttachList';
        //$this->url='http://dev.gn100.com/interface/course/AttachList';
        $this->http =new HttpClass();
    }

//返回字段
    public function testReturnField($userId=22414,$courseId=912,$classId=1133)
    {        
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;        
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertArrayHasKey("attachName", $result['result'][0]);
        $this->assertArrayHasKey("attachType", $result['result'][0]);
        $this->assertArrayHasKey("fileFormat", $result['result'][0]);
    }
    
    //课件类型，多个课件10个
    public function testCourseware($userId=22414,$courseId=912,$classId=1133)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(10,count(array_keys($result['result'])));
        foreach ($result['result'] as $resultkey =>$value)
        {
            if ($result['result'][$resultkey]['attachName']=="天津学区")
            {
                $this->assertEquals('xls',$result['result'][$resultkey]['fileFormat']);
                $this->assertEquals('http://testf.gn100.com/5,591432ad3f73',stripslashes($result['result'][$resultkey]['downUrl']));
        }
    }
    }
    
    //返回课件result为数组
    public function testResultType($userId=22414,$courseId=912,$classId=1133)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $arrayResult=array_keys($result['result']);
        $this->assertTrue(is_int($arrayResult[0]));
    }
    
    //多班课件
    public function testTwoClass($userId=5312,$courseId=912,$classId=1134)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("class2",$result['result'][0]['attachName']);
    }
    
    //管理员不可下载,目前接口未处理老师和管理员
    public function testOrgAdmin($userId=23317,$courseId=912,$classId=1134)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002",$result['code']);
    }
    
    //老师不可下载，目前接口未处理老师和管理员
    public function testOrgTeacher($userId=22411,$courseId=912,$classId=1134)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002",$result['code']);
    }
    
    //多班课件,非本班
    public function testNoRegClass($userId=5312,$courseId=912,$classId=1133)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002",$result['code']);
    }
    
    //多班课件，未报名
    public function testNoRegUser($userId=531,$courseId=912,$classId=1133)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002",$result['code']);
    }
    
    //未登陆
    public function testVisitor($userId=0,$courseId=912,$classId=1133)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002",$result['code']);
    }
    
    //无课件课程
    public function testCourseNoCourseware($userId=22410,$courseId=980,$classId=1191)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['classId']=$classId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002",$result['code']);
    }
    
    
}