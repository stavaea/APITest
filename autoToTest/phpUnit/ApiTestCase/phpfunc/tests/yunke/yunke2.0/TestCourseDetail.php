<?php

/**
 * test case.
 */
class TestCourseDetail extends PHPUnit_Framework_TestCase
{
    
    protected function setUp()
    {
         $this->url="http://test.gn100.com/interface.course.detail";
         $this->postData = [
             'u'=>'i',
             'v'=>'2',
             'time'=> strtotime(date('Y-m-d H:i:s'))
         ];
    }


    //传参正确，确认返回节点
    public function testCourseDetailNode($courseid="43",$uid="1")
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('avgScore', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('class', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('commentNum', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('courseId', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('courseName', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('courseType', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('decurl', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('feeType', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('imgurl', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('isFav', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('isFree', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('shareContent', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('trySee', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('shareUrl', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('userTotal', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('checkSign', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('classId',$result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('isSign', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('name', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('courseType', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('downUrl', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('duration', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('hideVideo', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('isPlay', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('isStudy', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('name', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('planId', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('startTime', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('status', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('totalTime', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('trySee', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('videoId', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('endTime', $result['result']['class'][0]['section'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('userName', $result['result']['class'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
 

    //uploadCourse录播课程
     public function testUploadCourseInfo($courseid='54',$uid='0')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        
        
        $this->assertContains('http://testf.gn100.com/1,d27db42fa202', $result['result']['imgurl'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('课程虚拟价-免费', $result['result']['courseName'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('2', $result['result']['courseType'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('0', $result['result']['userTotal'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    } 
    
    //"liveFeeCourse"=>array('116','662','0'),
    /* public function testLiveFeeCourseInfo($courseid='662',$uid='0')
    {
        $sql="select type, fee_type from t_course where pk_course=662";
        $courseinfo=interface_func::ConnectDB(db_user, $sql);
        
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals($courseinfo[0][1], $result['result']['feeType'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals($courseinfo[0][0], $result['result']['courseType'],'url:'.$this->url.'   Post data:'.json_encode(v));
        $this->assertEquals('1', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    } */
    
    //  线下课,班级基本信息，班主任等
    public function testOfflineCourse($courseid='25',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['result']['avgScore'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals("北京市 海淀区  银谷大厦615", $result['result']['class']['0']['address'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals("马静", $result['result']['class']['0']['userName'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('3', $result['result']['courseType'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
    //  已删除课程
    public function testDeleteCourse($courseid='56',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1056', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
 

    //多班直播试看 
    public function testDeleteClassCourse($courseid='40',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('2', count($result['result']['class']),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('0', $result['result']['class']['0']['section'][1]['trySee'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    

    //删除课时
    public function testDeletePlanCourse($courseid='43',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('741',$result['result']['class'][0]['section'][1]['planId'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('100', count($result['result']['class'][0]['section']),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
    // 未开课课程，视频状态status=1
     public function testUnstartCourse($courseid='43',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals(1, $result['result']['class'][0]['section'][99]['status'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    } 
    
    //  已完结课程，"doneCourse"=>array('214','695','22339'), //视频状态status=3
    /* public function testDoneCourse($courseid='695',$uid='22339')
    {
        $sql="select status,fk_video from t_course_plan where fk_course=695 and deleted=0 order by fk_section";
        $courseinfo=interface_func::ConnectDB(self::$db, $sql);
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('3', $result['result']['class'][0]['section'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals($courseinfo[0][1], $result['result']['class'][0]['section'][0]['videoId'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
     */
    //报名课程 "regCourse"=>array('116','688','22410'), // isSign=1
    public function testRegCourse($courseid='1',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
    //报名已满 
    public function testRegUserCourseFull($courseid='57',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['result']['class'][0]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
    //未报名课程已满 
    public function testNoRegUserCourseFull($courseid='57',$uid='2')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['result']['class'][0]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('0', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }


    //  多班返回2个班级信息
     public function testTwoClassCourse($courseid='57',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals(2,count($result['result']['class']),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('58',$result['result']['class'][0]['classId']);
        $this->assertEquals('1',$result['result']['class'][0]['isSign']);
        $this->assertEquals('1班',$result['result']['class'][0]['name']);
        $this->assertEquals('请填写班级介绍',$result['result']['class'][0]['desc']);
        $this->assertEquals('杨明娟老师',$result['result']['class'][0]['userName']);
        $this->assertEquals('1',$result['result']['class'][0]['courseType']);
        $this->assertEquals('0',$result['result']['class'][0]['checkSign']);
        $this->assertEquals('919',$result['result']['class'][0]['section'][0]['planId']);
    }
     
 
    
  
    // 多班一个报满，一个checkSign": 1,一个checkSign:0
    public function testRegUsertwoClassOneRegAll($courseid='57',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['result']['class'][0]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1', $result['result']['class'][1]['checkSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
     
    //收藏课程
    public function testFavCourse($courseid='57',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1',$result['result']['isFav'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));   
    }
 
    // 未收藏课程//isFav=0
    public function testNoFavCourse($courseid='50',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0',$result['result']['isFav'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    

    //未报名有视频课程 isstudy=0
    public function testNoReglivehasPlayerTime($courseid='28',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['result']['class'][0]['section'][7]['isStudy'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }

 
    //会员停用,isFree=1,isSign=1
    public function testMemberStopWithMemberUser($courseid='50',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('0', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
    //会员未报名,FeeType=1,isFree应该为0
    public function testNoRegMember($courseid='42',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1', $result['result']['feeType'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
    // 会员报名课程，isSign=1,isFree应该为0
    public function testRegMember($courseid='38',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        
    }
    
    //  isFree=0,issign=1,会员报名，课程所属2会员，用户所属2会员，1个过期（蓝钻过期）
    public function testRegUserIsTwoMemberOneExpired($courseid='58',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['result']['isFree'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1', $result['result']['class'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
   
    // 下载地址测试，包含视频隐藏，hideVideo=1,duration，暂时没有
   /*  public function testLiveCourseVerifyDownUrl($courseid='40',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('标清', $result['result']['class'][0]['section'][0]['downUrl'][0]['clear'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        //$this->assertContains("http://121.42.232.97/hls/1495628118/2_6_169812212/W1swLDMxMjBdXQ/low.m3u8", $result['result']['class'][0]['section'][0]['downUrl'][0]['url']);
        $this->assertEquals('高清', $result['result']['class'][0]['section'][0]['downUrl'][1]['clear'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertContains("hd.m3u8", $result['result']['class'][0]['section'][0]['downUrl'][1]['url'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('49 分钟', $result['result']['class'][0]['section'][0]['duration'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('0', $result['result']['class'][0]['section'][0]['hideVideo'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('标清', $result['result']['class'][0]['section'][1]['downUrl'][0]['clear'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('高清', $result['result']['class'][0]['section'][1]['downUrl'][1]['clear'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    } */
    
    
    //"twoClassVerifyTrySee" //多班试看，trySee=1
    public function testTwoClassVerifyTrySee($courseid='57',$uid='1')
    {
        $this->postData['params'] = [
            'uid'=>$uid,
            'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1', $result['result']['trySee'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }

    //多班同一章节下载地址确认，通过判断两个章节videoid
    /* public function testTwoClassVerifyDownUrl($courseid='57',$uid='1')
    {
        $this->postData['params'] = [
           'uid'=>$uid,
           'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertNotEquals($result['result']['class'][0]['section'][0]['videoId'],$result['result']['class'][1]['section'][0]['videoId'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
            
     } */
            

    //课程绑定QQ资讯，QQ和QQ群数据正确
    public function testQQ($courseid='2',$uid='1')
    {
        $this->postData['params'] = [
           'uid'=>$uid,
           'courseId'=>$courseid
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1',count($result['result']['qqData']['qq']),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1',count($result['result']['qqData']['qqun']),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('2',$result['result']['qqData']['qq'][0]['fk_org'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1',$result['result']['qqData']['qq'][0]['pk_customer'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('7',$result['result']['qqData']['qq'][0]['pk_relation'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1',$result['result']['qqData']['qq'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1',$result['result']['qqData']['qq'][0]['type'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('高能100',$result['result']['qqData']['qq'][0]['type_name'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('423569791',$result['result']['qqData']['qq'][0]['type_value'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals("https://jq.qq.com/?_wv=1027&k=49VEDiY",$result['result']['qqData']['qqun'][0]['ext'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('2',$result['result']['qqData']['qqun'][0]['type'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('高能壹佰产品技术群',$result['result']['qqData']['qqun'][0]['type_name'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('423569791',$result['result']['qqData']['qqun'][0]['type_value'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
           
          
}

