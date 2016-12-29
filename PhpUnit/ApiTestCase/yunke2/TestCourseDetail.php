<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';
/**
 * test case.
 */
class TestCourseDetail extends PHPUnit_Framework_TestCase
{
    protected $url;
    public  $http;
    static  $u="i";
    static  $v="2";
    static $oid="0";
    static $db="db_course";
    private $GetToken;
    
    protected function setUp()
    {
         $this->url="test.gn100.com/interface.course.detail";
         $this->http = new HttpClass();
         $this->GetToken =new TestUserToken();     
    }

    //传参正确，确认返回节点
    public function testCourseDetailNode($courseid="659",$uid="868")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('avgScore', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('class', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('commentNum', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseId', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseName', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseType', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('decurl', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('feeType', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('imgurl', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('isFav', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('isFree', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('shareContent', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('trySee', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('shareUrl', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('userTotal', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('checkSign', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('classId',$result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('isSign', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('name', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseType', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('downUrl', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('duration', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('hideVideo', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('isPlay', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('isStudy', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('name', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('planId', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('startTime', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('status', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('totalTime', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('trySee', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('videoId', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('endTime', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('userName', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
 

//uploadCourse录播课程
    public function testUploadCourseInfo($courseid='659',$uid='0')
    {
        $sql="select type, title, thumb_med, user_total from t_course where pk_course=659";
        $courseinfo=interface_func::ConnectDB(self::$db, $sql);
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertContains($courseinfo[0][2], $result['result']['imgurl'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($courseinfo[0][1], $result['result']['courseName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($courseinfo[0][0], $result['result']['courseType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($courseinfo[0][3], $result['result']['userTotal'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //"liveFeeCourse"=>array('116','662','0'),
    public function testLiveFeeCourseInfo($courseid='662',$uid='0')
    {
        $sql="select type, fee_type from t_course where pk_course=662";
        $courseinfo=interface_func::ConnectDB(self::$db, $sql);
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals($courseinfo[0][1], $result['result']['feeType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($courseinfo[0][0], $result['result']['courseType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //  线下课,班级基本信息，班主任等
    public function testOfflineCourse($courseid='908',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('5.0', $result['result']['avgScore'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals("上海市 卢湾区  测试地址1班", $result['result']['class']['0']['address'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals("apiTest", $result['result']['class']['0']['userName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('3', $result['result']['courseType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //  已删除课程
    public function testDeleteCourse($courseid='251',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1056', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    // 录播试看课程，课程trySee和plan trySee一致 trySee=1
    public function testTryCourse($courseid='624',$uid='0')
    {
        $sql="select pk_plan,start_time,end_time,fk_class from t_course_plan where fk_course=624 and deleted=0 order by fk_section";
        $courseinfo=interface_func::ConnectDB(self::$db, $sql);
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1', $result['result']['trySee'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($courseinfo[0][0], $result['result']['class'][0]['section'][0]['planId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['class'][0]['section'][0]['trySee'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertContains($result['result']['class'][0]['section'][0]['endTime'],$courseinfo[0][2],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertContains($result['result']['class'][0]['section'][0]['startTime'],$courseinfo[0][1],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($courseinfo[0][3], $result['result']['class'][0]['classId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

    //多班直播试看 且有班级删除508 
    public function testDeleteClassCourse($courseid='508',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('2', count($result['result']['class']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['class']['0']['section']['trySee'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    

    //删除课时
    public function testDeletePlanCourse($courseid='1171',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('4393',$result['result']['class'][0]['section'][1]['planId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('2', count($result['result']['class'][0]['section']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    // 未开课课程，视频状态status=1
    public function testUnstartCourse($courseid='511',$uid='0')
    {
        $sql="select status,fk_video from t_course_plan where fk_course=511 and deleted=0 order by fk_section";
        $courseinfo=interface_func::ConnectDB(self::$db, $sql);
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals($courseinfo[0][0], $result['result']['class'][0]['section'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($courseinfo[0][1], $result['result']['class'][0]['section'][0]['videoId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //  已完结课程，"doneCourse"=>array('214','695','22339'), //视频状态status=3
    public function testDoneCourse($courseid='695',$uid='22339')
    {
        $sql="select status,fk_video from t_course_plan where fk_course=695 and deleted=0 order by fk_section";
        $courseinfo=interface_func::ConnectDB(self::$db, $sql);
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('3', $result['result']['class'][0]['section'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($courseinfo[0][1], $result['result']['class'][0]['section'][0]['videoId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //报名课程 "regCourse"=>array('116','688','22410'), // isSign=1
    public function testRegCourse($courseid='688',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //报名已满  "regUserCourseFull"=>array('116','675','22410')， // "checkSign":0,"isSign":1
    public function testRegUserCourseFull($courseid='675',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['result']['class'][0]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //未报名课程已满 "NoRegUserCourseFull"=>array('116','675','22414'), // "checkSign":0,"isSign":0
    public function testNoRegUserCourseFull($courseid='675',$uid='22414')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['result']['class'][0]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    

    //  多班返回2个班级信息
    public function testTwoClassCourse($courseid='705',$uid='22410')
    {
        $sql="select count(*) from t_course_class where fk_course=705 and deleted=0 ";
        $courseinfo=interface_func::ConnectDB(self::$db, $sql);
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals($courseinfo[0][0],count($result['result']['class']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
  
    // 多班一个报满，一个checkSign": 1,一个checkSign:0
    public function testRegUsertwoClassOneRegAll($courseid='705',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['result']['class'][0]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['class'][1]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
     
    //收藏课程 "FavCourse"=>array('116','608','22410'), //isFav=1
    public function testFavCourse($courseid='608',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1',count($result['result']['isFav']),'url:'.$this->url.'   Post data:'.json_encode($postdata));   
    }
 
    // 未收藏课程//isFav=0
    public function testNoFavCourse($courseid='608',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0',$result['result']['isFav'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    

    //未报名有视频课程 isstudy=0
    public function testNoReglivehasPlayerTime($courseid='618',$uid='22333')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['result']['class'][0]['section'][0]['isStudy'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

    // 报名观看过课程视频，用户观看时间存在，plan=2260,isstudy=1
    public function testReglivehasPlayerTime($courseid='701',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1', $result['result']['class'][0]['section'][1]['isStudy'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

    
    
    // 报名未观看课程视频，isStudy=0
    public function testReghasVideoCourse($courseid='619',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['result']['class'][0]['section'][1]['isStudy'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    // //会员停用,isFree=1,isSign=0
    public function testMemberStopWithMemberUser($courseid='617',$uid='269')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //会员未报名,FeeType=1,isFree应该为0
    public function testNoRegMember($courseid='538',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['feeType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    // 会员报名课程，isSign=1,isFree应该为0
    public function testRegMember($courseid='543',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
    }
    
    //  isFree=0,issign=1,会员报名(牛逼会员)，课程所属2会员，用户所属2会员，1个过期（蓝钻过期）
    public function testRegUserIsTwoMemberOneExpired($courseid='543',$uid='5969')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    // 会员报名非会员付费课,isFree=1,FeeType=1
    public function testPayCourseUserMember($courseid='504',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['feeType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    
   // 会员报名后，会员停用,isFree=1,FeeType=1，issign=0
    public function testRegMemberStop($courseid='699',$uid='22411')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['feeType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    // "CommentUserMember" =>array('116','592','0'), //多条评论，评论获取分数5分，score=5.0
    public function testCommentUserMember($courseid='592',$uid='0')
    {
        $sql="select count(*) from t_comment_score where fk_course=592 and status=1";
        $courseinfo=interface_func::ConnectDB('db_message', $sql);
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals($courseinfo[0][0], $result['result']['commentNum'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
      
   //"Numteacher" =>array('227','721','0'), //多个老师,简介H5页面
   
    // 下载地址测试，包含视频隐藏，hideVideo=1,duration
    public function testLiveCourseVerifyDownUrl($courseid='909',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('标清', $result['result']['class'][0]['section'][0]['downUrl'][0]['clear'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertContains("http://115.28.38.142/hls/1474282141/22410_2937_177223685/W1swLDI1OV1d/low.m3u8", $result['result']['class'][0]['section'][0]['downUrl'][0]['url'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('高清', $result['result']['class'][0]['section'][0]['downUrl'][1]['clear'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertContains("hd.m3u8", $result['result']['class'][0]['section'][0]['downUrl'][1]['url'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('4 分钟', $result['result']['class'][0]['section'][0]['duration'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['result']['class'][0]['section'][0]['hideVideo'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('标清', $result['result']['class'][0]['section'][1]['downUrl'][0]['clear'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('高清', $result['result']['class'][0]['section'][1]['downUrl'][1]['clear'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEmpty($result['result']['class'][0]['section'][3]['downUrl'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('8 分钟', $result['result']['class'][0]['section'][3]['duration'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['class'][0]['section'][3]['hideVideo'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEmpty($result['result']['class'][0]['section'][4]['downUrl'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    
    //"twoClassVerifyTrySee"=>array('214','705','0')  //多班试看，trySee=1
    public function testTwoClassVerifyTrySee($courseid='705',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1', $result['result']['trySee'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

    //多班同一章节下载地址确认，通过判断两个章节videoid
    public function testTwoClassVerifyDownUrl($courseid='570',$uid='0')
            {
                $postdata['oid']=self::$oid;
                $postdata['time']=strtotime(date('Y-m-d H:i:s'));
                $postdata['u']=self::$u;
                $postdata['v']=self::$v;
                $postdata['params']['uid']=$uid;
                $postdata['params']['courseId']=$courseid;
                $key=interface_func::GetAppKey($postdata);
                $postdata['key']=$key;
                $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
                $this->assertNotEquals($result['result']['class'][0]['section'][0]['videoId'],$result['result']['class'][1]['section'][0]['videoId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            }
            
           //   已结束线下课多班，checksign=2
        public function testOfflineCourseTwoClass($courseid='908',$uid='22410')
            {
                $postdata['oid']=self::$oid;
                $postdata['time']=strtotime(date('Y-m-d H:i:s'));
                $postdata['u']=self::$u;
                $postdata['v']=self::$v;
                $postdata['params']['uid']=$uid;
                $postdata['params']['courseId']=$courseid;
                $key=interface_func::GetAppKey($postdata);
                $postdata['key']=$key;
                $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
                $this->assertEquals('2',$result['result']['class'][0]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('2',$result['result']['class'][1]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            }

             //课程绑定QQ资讯，QQ和QQ群数据正确
            public function testQQ($courseid='1170',$uid='22410')
            {
                $postdata['oid']=self::$oid;
                $postdata['time']=strtotime(date('Y-m-d H:i:s'));
                $postdata['u']=self::$u;
                $postdata['v']=self::$v;
                $postdata['params']['uid']=$uid;
                $postdata['params']['courseId']=$courseid;
                $key=interface_func::GetAppKey($postdata);
                $postdata['key']=$key;
                $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
                $this->assertEquals('2',count($result['result']['qqData']['qq']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('2',count($result['result']['qqData']['qqun']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('214',$result['result']['qqData']['qq'][0]['fk_org'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('29',$result['result']['qqData']['qq'][0]['pk_customer'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('79',$result['result']['qqData']['qq'][0]['pk_relation'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('1',$result['result']['qqData']['qq'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('1',$result['result']['qqData']['qq'][0]['type'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('hye2',$result['result']['qqData']['qq'][0]['type_name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('182537361',$result['result']['qqData']['qq'][0]['type_value'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals("https://jq.qq.com/?_wv=1027&k=42kzwAY",$result['result']['qqData']['qqun'][0]['ext'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('2',$result['result']['qqData']['qqun'][0]['type'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('hye2群',$result['result']['qqData']['qqun'][0]['type_name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals('423569792',$result['result']['qqData']['qqun'][0]['type_value'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            }

            protected function tearDown()
            {
                unset($this->http);
                unset($this->GetToken);
            }
}

