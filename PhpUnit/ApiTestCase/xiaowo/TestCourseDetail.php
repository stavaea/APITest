<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

/**
 * test case.
 */
class TestCourseDetail extends PHPUnit_Framework_TestCase
{
    protected $url;
    public  $http;
    static  $u="i";
    static  $v="2";
    
    protected function setUp()
    {
         $this->url="test.gn100.com/interface.course.detail";
        //$this->url="dev.gn100.com/interface.course.detail";
        $this->http = new HttpClass();
    }
    /*
    public function testComment($courseid="180",$uid="868")
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
    
    /**
     *
     * @dataProvider additionProvider
     */
    public function testCourseDetailVerifyCourseInfo($oid,$courseid,$uid)
    {
        $postdata['oid']=$oid;
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump( json_encode($postdata));
       //$result=$this->http->HttpPost($this->url, json_encode($postdata));
       //var_dump($result);
    
        //$this->assertEquals("http://testf.gn100.com/3,447db337c372", $result['result']['data'][0]['thumbMed']);
        //$this->assertEquals("691", $result['result']['data'][0]['courseId']);
        //$this->assertEquals("1", $result['result']['data'][0]['feeType']);
        //$this->assertEquals("0.01", $result['result']['data'][0]['price']);
    }
    
    public function additionProvider()
    {
        return array(
           // "uploadCourse"=>array('116','659','0'),
            //"liveFeeCourse"=>array('116','662','0'),
          //  "offlineCourse"=>array('116','655','0'),
          // "tryCourse"=>array('116','624','0'), //课程trySee和plan trySee一致 trySee=1
           //"liveTryCourse"=>array('116','624','22410'),
           // "UnStartCourse"=>array('214','511','0'), //视频状态status=1
          //  "doneCourse"=>array('214','695','22339'), //视频状态status=3
           // "regCourse"=>array('116','688','22410'), // isSign=1
           //  "regUserCourseFull"=>array('116','675','22410')， // "checkSign":0,"isSign":1
             //"NoRegUserCourseFull"=>array('116','675','22414'), // "checkSign":0,"isSign":0
           //  "twoClassCourse"=>array('116','285','22410'),//返回2个班级信息
           // "RegUsertwoClassOneRegAll"=>array('214','705','22410')， //一个checkSign": 1,一个checkSign:0
          // "FavCourse"=>array('116','608','22410'), //isFav=1
            // "NoFavCourse"=>array('116','608','0'), //isFav=0
             //"NoReglivehasPlayerTime"=>array('116','618','22333'), //isstudy=0
           //  "ReglivehasPlayerTime"=>array('116','701','22410'), //用户观看时间存在，plan=2260,isstudy=1
            // "NoRegliveIsStudy"=>array('174','713','0'), //plan=2288,isstudy=0
            // "RegVideoCoursehasVideoCourse"=>array('116','619','22410'), //fail isstudy问题
              // "NoRegMember"=>array('116','538','22410'),  //会员未报名,FeeType=1,isFree应该为0
            // "RegMember"=>array('116','543','22410'), //会员报名课程，isSign=1,isFree应该为0
           // "MemberStopWithMemberUser"=>array('116','617','269'),  //会员停用,isFree=1,issign=0
          //  "RegUserIsTwoMemberOneExpired"=>array('116','364','185')  //isFree=0,issign=1,会员报名(牛逼会员)，课程所属2会员，用户所属2会员，1个过期（蓝钻过期）
         // "FreeCourseUserMember"=>array('116','191','22410'),//会员报名免费课，isFree=0,FeeType=0
           // "PayCourseUserMember"=>array('116','651','22410'),//会员报名非会员付费课,isFree=1,FeeType=1
           // "RegMemberStop"=>array('116','543','269'),//会员报名,isFree=0,FeeType=1，issign=0
          // "CommentUserMember" =>array('116','592','0'), //多条评论，评论获取分数5分，score=5.0
            //"Numteacher" =>array('227','721','0'), //多个老师
           //  "Numteacher" =>array('116','227','0'), //无班主任
         //  "LiveCourseVerifyDownUrl"=>array('214','909','0')  //下载地址测试课程，包含隐藏课程
              "twoClassVerifyTrySee"=>array('214','705','0')  //多班试看，trySee=1
            //"twoClassVerifyDownUrl"=>array('116','570','0')  //多班同一章节下载地址确认，
           //    "offlineCourseTwoClass"=>array('214','908','22410')  //线下课多班，用户报名2班
            //"offlineCourseTwoClass"=>array('469','3033','22410')  //线下课多班，用户报名2班
           // "offlineCourseTwoClass"=>array('116','946','22410')  //线下课多班，用户报名2班
        );
    }
    
   
    
}

