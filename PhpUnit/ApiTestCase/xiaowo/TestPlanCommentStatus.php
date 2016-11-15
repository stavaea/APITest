<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

/**
 * test case.
 */
class TestPlanCommentStatus extends PHPUnit_Framework_TestCase
{
private $url;
private $http;
static $u="i";
static $v="2";

    protected function setUp()
    {
        $this->url='http://test.gn100.com/interface/plan/PlanCommentStatus';
        $this->http = new HttpClass();
    }
    

    //返回字段，planId\sectionName\type
    public function testFieldReturn($courseId='976',$userId='53343',$classId='1187')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertArrayHasKey("planId",$result['result']['0']);
        $this->assertArrayHasKey("sectoinName",$result['result']['0']);
        $this->assertArrayHasKey("type",$result['result']['0']);
    }
    
    //开课type，type=1可评论；type=0不可评论；
    public function testType($courseId='976',$userId='22414',$classId='1187')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        foreach ($result['result'] as $resultkey =>$value)
        {
            if ($result['result'][$resultkey]['planId']==3475)
                $this->assertEquals("1",$result['result'][$resultkey]['type']);
            elseif ($result['result'][$resultkey]['planId']==3464)
                $this->assertEquals("0",$result['result'][$resultkey]['type']);
            else 
                $this->assertEquals("0",$result['result'][$resultkey]['type']);
        }      
    }
    
    //评论过又删除；
    public function testDeleteComment($courseId='976',$userId='5312',$classId='1187')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1",$result['result']['0']['type']);
    }
    
    //线下课已结束，报名未评论，type=1；
    public function testOfflineCourseStart($courseId='384',$userId='12362',$classId='419')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1",$result['result']['0']['type']);
    }
    
    //线下课未开课，报名，type=0；
    public function testOfflineCourseNoStart($courseId='980',$userId='22410',$classId='1191')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("0",$result['result']['0']['type']);
    }

    //多班，报名章节评论过，type=0；
    public function testTwoClassesCommented($courseId='908',$userId='22410',$classId='1130')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("0",$result['result']['0']['type']);
    }
    
/*
    //多班，报名章节未评论过，type=1；
    public function testTwoClassesCommented($courseId='908',$userId='22410',$classId='1130')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump(json_encode($postdata));
        $this->assertEquals("1",$result['result']['0']['type']);
    }
    */
   //线下课多班，未报名班级，type=0；接口未对多班未报名班级做处理，APP只会传已报名班级的班级id
    public function testTwoClassesNoRegClass($courseId='908',$userId='22410',$classId='1129')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("0",$result['result']['0']['type']);
    }
    
    //线下课多班，未传classid；
    public function testTwoClassesNoComment($courseId='908',$userId='22410')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=' ';
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1000",$result['code']);
    }
    
    //未报名；接口未处理，现在返回同报名用户
    public function testStartCourseNoReg($courseId='976',$userId='224',$classId='1187')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
    foreach ($result['result'] as $resultkey =>$value)
        {
            if ($result['result'][$resultkey]['planId']==3475)
                $this->assertEquals("1",$result['result'][$resultkey]['type']);
            elseif ($result['result'][$resultkey]['planId']==3464)
                $this->assertEquals("1",$result['result'][$resultkey]['type']);
            else 
                $this->assertEquals("0",$result['result'][$resultkey]['type']);
        }
    }
      
    //未登陆；
    public function testNoReg($courseId='976',$userId='0',$classId='1187')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1000",$result['code']);
    }
    
    //course不存在,获取数据失败
    public function testCourseNotExist($courseId='97600',$userId='273',$classId='1187')
    {
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['params']['courseId']=$courseId;
        $postdata['params']['userId']=$userId;
        $postdata['params']['classId']=$classId;
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002",$result['code']);
    }
    

}

