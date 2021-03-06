<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestTeacherInfo extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    public  $GetToken;
    
    public function  __construct()
    {
        //$this->url = "http://dev.gn100.com/interface/teacher/detail";
        $this->url = "http://test.gn100.com/interface/teacher/detail";
        $this->http = new HttpClass();
        $this->GetToken =new TestUserToken();
    }
    
    //grade_id:4000,teacher_status:1,visiable:1,course_count:1,5000
    //传参正确，返回老师基本信息info数据正确
    public function testTeacherInfoIsOk($uid="0",$teacherId='23402')
    {   
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['teacherId']=$teacherId;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;

        
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(0, $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('23402', $result['result']['info']['teacherId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('http://testf.gn100.com/5,02810efbc5ea', $result['result']['info']['thumbMed'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('老师详情接口测试', $result['result']['info']['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('2', $result['result']['info']['years'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('武汉大学', $result['result']['info']['college'],'url:'.$this->url.'   Post data:'.json_encode($postdata)); 
        $this->assertEquals("英语", $result['result']['info']['subject'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('老师简介desc-勿动', $result['result']['info']['desc'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('', $result['result']['info']['taughtGrade'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('5', $result['result']['info']['score'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('2', $result['result']['info']['comment'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['result']['info']['isFav'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('浙江温州', $result['result']['info']['address'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

   // 传参正确，返回老师统计数据正确
    public function testTeacherStat($uid="0",$teacherId='23402')
    {
        $sql='select * from t_teacher_stat where fk_user=23402';
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['teacherId']=$teacherId;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $dbStat=interface_func::ConnectDB('db_stat', $sql);
        $this->assertEquals($dbStat[0][1], $result['result']['info']['courseCount'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($dbStat[0][2], $result['result']['info']['userTotal'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals(round($dbStat[0][4]/3600), round($result['result']['info']['courseTotalTime']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //传参正确，uid不为空，且收藏老师，返回info老师被收藏
    public function testTeacherFav($uid="22410",$teacherId='23402')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['teacherId']=$teacherId;
        $postdata['params']['userId']=$uid;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['info']['isFav'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //传参正确，uid不为空，且收藏老师，返回info老师被收藏
    public function testTeacherUnFav($uid="22490",$teacherId='23402')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['teacherId']=$teacherId;
        $postdata['params']['userId']=$uid;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['result']['info']['isFav'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

    //传参正确，老师plan类型（数组）且返回字段是否正确
    public function testTeacherPlan($uid="22410",$teacherId='23317')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['teacherId']=$teacherId;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $arrayResult=array_keys($result['result']['plan']);
        $this->assertTrue(is_int($arrayResult[0]),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $arrayKey=array_column($result['result']['plan'],'planId');
        foreach ($arrayKey as $key => $value)
        {
             if ($arrayKey[$key]=='3464')
                 $this->assertEquals('已开课，报名用户已评价type=0',$result['result']['plan'][$key]['sectionDesc'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                 $this->assertEquals('第1课时',$result['result']['plan'][$key]['sectionName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                 $this->assertEquals('1',$result['result']['plan'][$key]['courseType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                 $this->assertEquals('http://testf.gn100.com/5,6d50e938e6ac',$result['result']['plan'][$key]['thumbMed'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
       
    }
    
    //传参正确，老师course类型且返回字段是否正确
//     public function testTeacherCourse($uid="22410",$teacherId='22436')
//     {
//         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
//         $postdata['u']=self::$u;
//         $postdata['v']=self::$v;
//         $postdata['params']['page']='1';
//         $postdata['params']['length']='20';
//         $postdata['params']['teacherId']=$teacherId;
//         $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
//         $postdata['token']=$token;
//         $key=interface_func::GetAppKey($postdata);
//         $postdata['key']=$key;
//         $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
//         var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
//         $arrayResult=array_keys($result['result']['info']);
        
//         $this->assertTrue(is_int($arrayResult[0]),'url:'.$this->url.'   Post data:'.json_encode($postdata));
//         $arrayKey=array_column($result['result']['info'],'courseId');
//         foreach ($arrayKey as $key => $value)
//         {
//              if ($arrayKey[$key]=='918')
//                  $this->assertEquals('测试联通支付',$result['result']['course']['list'][$key]['title'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
//                  $this->assertEquals('xiawot',$result['result']['course']['list'][$key]['orgSubname'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
//                  $this->assertEquals('1',$result['result']['course']['list'][$key]['courseType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
//                  $this->assertEquals('http://testf.gn100.com/5,5cc0ffb7ec6d',$result['result']['course']['list'][$key]['thumbMed'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
//                  $this->assertLessThanOrEqual($result['result']['course']['list'][$key]['userTotal'],'2','url:'.$this->url.'   Post data:'.json_encode($postdata));
//                  $this->assertEquals('1',$result['result']['course']['list'][$key]['price'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
//         }
//     }
    
    //翻页
    public function testPage($uid="22410",$teacherId='12357')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='1';
        $postdata['params']['teacherId']=$teacherId;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertLessThan($result['result']['info'],0,'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

    
    //传参正确，老师无课程数据
    public function testTeacherNoCourse($uid='22486',$teacherId='35652')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['teacherId']=$teacherId;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEmpty('0',$result['result']['info']['courseCount'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
   
    //必传参数为空，返回值
    public function testParamsIsNull($oid='469')
    {   
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['teacherId']='';
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1000', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//请求参数为空
    }
    
    //参数不存在，返回值
    public function testParamsIsNotExist($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['teacherId']='aa';
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('3002', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//获取数据失败
    }

    protected function tearDown()
    {
        unset($this->http);
        unset($this->GetToken);
    }
    //
}