<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';
require_once '../yunke2/TestStudentTaskList.php';

/**
 * test case.
 */
class TestStudentCourse extends PHPUnit_Framework_TestCase
{
    private  $url;
    private  $http;
    private $GenToken;
    public $task;
    static  $u="i";
    static  $v="2";
    public  $uid;
    protected function setUp()
    {
        $this->url="test.gn100.com/interface/org/studentCourse";
        $this->http = new HttpClass();
        $this->GenToken =new TestUserToken();
        $this->task = new TestStudentTaskList();    
    }
    
    // todo 获取个人中心报名课程数，select count(*) from t_course_user where fk_user=22410 and fk_user_owner=183;
    
    /*
    //传参正确，userId存在该机构报名课，返回数据节点是否正确
    public function testCheckDataNode($oid="116",$uid="22410")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="30";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertArrayHasKey("data",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata)); //课程数据
        $this->assertArrayHasKey("exper",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));    //经验值
        $this->assertArrayHasKey("isDayCourse",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata)); //当天有没有课程,1有课程；0无课程
        $this->assertArrayHasKey("isDaySign",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//是否签到
        $this->assertArrayHasKey("level",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//当前等级
        $this->assertArrayHasKey("levelName",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//等级名称
        $this->assertArrayHasKey("msgNum",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//
        $this->assertArrayHasKey("nextEx",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//下个等级
        $this->assertArrayHasKey("nextLevelName",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//下个等级名称
        $this->assertArrayHasKey("page",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//页数
        $this->assertArrayHasKey("thumbMed",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//头像
        $this->assertArrayHasKey("pageTotal",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//页总数
        $this->assertArrayHasKey("pageSize",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//总课程数
        $this->assertArrayHasKey("unfinishNum",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//学生待提交作业
        $this->assertArrayHasKey("waitTask",$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata)); //老师待批改作业       
    }
  

    //传参正确，userId个人等级字段正确
    public function testVerifyUserLevelInfo($oid="116",$uid="22414")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $db="db_user";
        $sql="select fk_level,title,score FROM t_user_score where fk_user=$uid";
        $leveldata =interface_func::ConnectDB($db,$sql); //db获取用户等级相关数据
        $this->assertEquals($leveldata[0][2], $result['result']['exper'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($leveldata[0][0],$result['result']['level'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($leveldata[0][1], $result['result']['levelName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
        */
    

    //传参正确，userId个人信息，签到
    public function testCheckIsDaySign($oid="116",$uid="22414")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $date=date("Y-m-d");
        $db="db_user";
        $sql="select day FROM t_user_sign where fk_user=$uid and day=$date";
        $signdata =interface_func::ConnectDB($db,$sql);
        if(empty($signdata)) //返回bool类型说明，当天未签到记录
          //  $this->assertEquals('0', $result['result']['isDaySign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('0', $result['result']['isDaySign']);
            else 
        //    $this->assertEquals('1', $result['result']['isDaySign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('1', $result['result']['isDaySign']);
    }
    
    
    //传参正确，userId个人信息课程数量
    public function testCheckCourseNum($oid="116",$uid="22410")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="50";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $date=date("Y-m-d");
        $db="db_course";
        $sql="select count(*) from t_course_user where fk_user=$uid and fk_user_owner=183";
        $courseNum =interface_func::ConnectDB($db,$sql); //用户课程总数
        //$this->assertEquals($courseNum[0][0], $result['result']['pageSize'],'url:'.$this->url.'   Post data:'.json_encode($postdata));     
        $this->assertEquals($courseNum[0][0], $result['result']['pageSize']);
    }
    
    //传参正确，userId个人信息，学生unfinish作业数据
    public function testCheckUnfinishTaskData($oid="116",$uid="22410")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="50";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $tasknum=$this->task->testGetUncommitTaskNum($uid); //通过调用学生作业接口获取未提交作业数据
        $this->assertEquals($tasknum, $result['result']['unfinishNum'],'url:'.$this->url.'   Post data:'.json_encode($postdata));  
    }
 /*
  
    public function testRegCourseFields($oid="116",$uid="22410")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="2";
        $postdata['params']['length']="30";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }

    
    public function testStudentCourseFieldsdd($oid="214",$uid="22410")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }*/

}

