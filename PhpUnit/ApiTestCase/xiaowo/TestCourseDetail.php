<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

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
    /*
    public function testComment($courseid="180",$uid="868")
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //$this->assertEquals("http://testf.gn100.com/3,447db337c372", $result['result']['data'][0]['thumbMed']);
        //$this->assertEquals("691", $result['result']['data'][0]['courseId']);
        //$this->assertEquals("1", $result['result']['data'][0]['feeType']);
        //$this->assertEquals("0.01", $result['result']['data'][0]['price']);
    }
 
    public function testCourseDetailFed($courseid="3647",$uid="0")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //$this->assertEquals("http://testf.gn100.com/3,447db337c372", $result['result']['data'][0]['thumbMed']);
        //$this->assertEquals("691", $result['result']['data'][0]['courseId']);
        //$this->assertEquals("1", $result['result']['data'][0]['feeType']);
        //$this->assertEquals("0.01", $result['result']['data'][0]['price']);
    }
       */
    
    // "uploadCourse"=>array('116','659','0'),
    public function testUploadCourseInfo($courseid='659',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        $this->assertEquals("http://testf.gn100.com/3,447db337c372", $result['result']['data'][0]['thumbMed']);
        $this->assertEquals("691", $result['result']['data'][0]['courseId']);
        $this->assertEquals("1", $result['result']['data'][0]['feeType']);
        $this->assertEquals("0.01", $result['result']['data'][0]['price']);
    }
    
    //"liveFeeCourse"=>array('116','662','0'),
    public function testLiveFeeCourseInfo($courseid='662',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //  "offlineCourse"=>array('116','655','0'),
    public function testOfflineCourse($courseid='655',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "tryCourse"=>array('116','624','0'), //课程trySee和plan trySee一致 trySee=1
    public function testTryCourse($courseid='624',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //"liveTryCourse"=>array('116','624','22410'),
    public function testLiveTryCourse($courseid='624',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "UnStartCourse"=>array('214','511','0'), //视频状态status=1
    public function testUnstartCourse($courseid='511',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //  "doneCourse"=>array('214','695','22339'), //视频状态status=3
    public function testDoneCourse($courseid='695',$uid='22339')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "regCourse"=>array('116','688','22410'), // isSign=1
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //  "regUserCourseFull"=>array('116','675','22410')， // "checkSign":0,"isSign":1
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //"NoRegUserCourseFull"=>array('116','675','22414'), // "checkSign":0,"isSign":0
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //  "twoClassCourse"=>array('116','285','22410'),//返回2个班级信息
    public function twoClassCourse($courseid='285',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "RegUsertwoClassOneRegAll"=>array('214','705','22410')， //一个checkSign": 1,一个checkSign:0
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "FavCourse"=>array('116','608','22410'), //isFav=1
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "NoFavCourse"=>array('116','608','0'), //isFav=0
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //"NoReglivehasPlayerTime"=>array('116','618','22333'), //isstudy=0
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //  "ReglivehasPlayerTime"=>array('116','701','22410'), //用户观看时间存在，plan=2260,isstudy=1
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }

    // "NoRegliveIsStudy"=>array('174','713','0'), //plan=2288,isstudy=0
    public function testNoRegliveIsStudy($courseid='713',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "RegVideoCoursehasVideoCourse"=>array('116','619','22410'), //fail isstudy问题
    public function testRegVideoCoursehasVideoCourse($courseid='619',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "MemberStopWithMemberUser"=>array('116','617','269'),  //会员停用,isFree=1,issign=0
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "NoRegMember"=>array('116','538','22410'),  //会员未报名,FeeType=1,isFree应该为0
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "RegMember"=>array('116','543','22410'), //会员报名课程，isSign=1,isFree应该为0
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //  "RegUserIsTwoMemberOneExpired"=>array('116','364','185')  //isFree=0,issign=1,会员报名(牛逼会员)，课程所属2会员，用户所属2会员，1个过期（蓝钻过期）
    public function testRegUserIsTwoMemberOneExpired($courseid='543',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "PayCourseUserMember"=>array('116','651','22410'),//会员报名非会员付费课,isFree=1,FeeType=1
    public function testPayCourseUserMember($courseid='543',$uid='22410')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    
   // "RegMemberStop"=>array('116','543','269'),//会员报名,isFree=0,FeeType=1，issign=0
    public function testRegMemberStop($courseid='543',$uid='269')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    // "CommentUserMember" =>array('116','592','0'), //多条评论，评论获取分数5分，score=5.0
    public function testCommentUserMember($courseid='592',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
      
   //"Numteacher" =>array('227','721','0'), //多个老师
    public function testNumteacher($courseid='721',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
       //  "Noteacher" =>array('116','227','0'), //无班主任
    public function testNoteacher($courseid='227',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
    
    //  "LiveCourseVerifyDownUrl"=>array('214','909','0')  //下载地址测试课程，包含隐藏课程
    public function testLiveCourseVerifyDownUrl($courseid='909',$uid='0')
    {
        $postdata['oid']=self::$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
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
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }

            //"twoClassVerifyDownUrl"=>array('116','570','0')  //多班同一章节下载地址确认，
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
                $result=$this->http->HttpPost($this->url, json_encode($postdata));
            }
           //    "offlineCourseTwoClass"=>array('214','908','22410')  //线下课多班，用户报名2班
            //"offlineCourseTwoClass"=>array('469','3033','22410')  //线下课多班，用户报名2班
            public function testOfflineCourseTwoClass($courseid='3303',$uid='22410')
            {
                $postdata['oid']=self::$oid;
                $postdata['time']=strtotime(date('Y-m-d H:i:s'));
                $postdata['u']=self::$u;
                $postdata['v']=self::$v;
                $postdata['params']['uid']=$uid;
                $postdata['params']['courseId']=$courseid;
                $key=interface_func::GetAppKey($postdata);
                $postdata['key']=$key;
                $result=$this->http->HttpPost($this->url, json_encode($postdata));
            }
           // "offlineCourseTwoClass"=>array('116','946','22410')  //线下课多班，用户报名2班

    
   
    
}

