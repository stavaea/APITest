<?php

class TestTeacherInfo extends PHPUnit_Framework_TestCase
{
protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/teacher/detail";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    //grade_id:4000,teacher_status:1,visiable:1,course_count:1,5000
    //传参正确，返回老师基本信息info数据正确
    public function testTeacherInfoIsOk()
    {   
        $this->postData['params'] = [
            'teacherId'=>'1',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals(0, $result['code']);
        $this->assertEquals('1', $result['result']['info']['teacherId']);
        $this->assertEquals('http://testf.gn100.com/5,cf0e19ade357', $result['result']['info']['thumbMed']);
        $this->assertEquals('杨明娟', $result['result']['info']['name']);
        $this->assertEquals('1', $result['result']['info']['years']);
        $this->assertEquals('清华大学', $result['result']['info']['college']); 
        $this->assertEquals("语文,化学,历史", $result['result']['info']['subject']);
        $this->assertEquals('最美教师', $result['result']['info']['desc']);
        $this->assertEquals('', $result['result']['info']['taughtGrade']);
        $this->assertEquals('5', $result['result']['info']['score']);
        $this->assertEquals('0', $result['result']['info']['isFav']);
        $this->assertEquals('', $result['result']['info']['address']);
    }

   // 传参正确，返回老师统计数据正确
    public function testTeacherStat()
    {
        $this->postData['params'] = [
            'teacherId'=>'1',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $sql='select * from t_teacher_stat where fk_user=1';
        $dbStat=dbConnect::ConnectDB('db_stat', $sql);
        $this->assertEquals($dbStat[0][1], $result['result']['info']['courseCount']);
        $this->assertEquals($dbStat[0][2], $result['result']['info']['userTotal']);
        $this->assertEquals(round($dbStat[0][4]/3600), round($result['result']['info']['courseTotalTime']));
    }
    
    //传参正确，uid不为空，且收藏老师，返回info老师被收藏
    public function testTeacherFav()
    {
        $this->postData['params'] = [
            'teacherId'=>'1',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['result']['info']['isFav']);
    }
    


    //传参正确，老师plan类型（数组）且返回字段是否正确
    public function testTeacherPlan()
    {
        $this->postData['params'] = [
            'teacherId'=>'1',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $arrayResult=array_keys($result['result']['plan']);
        $this->assertTrue(is_int($arrayResult[0]));
        $arrayKey=array_column($result['result']['plan'],'planId');
        foreach ($arrayKey as $key => $value)
        {
             if ($arrayKey[$key]=='919')
             {
                 $this->assertEquals('1',$result['result']['plan'][$key]['sectionDesc']);
                 $this->assertEquals('第1课时',$result['result']['plan'][$key]['sectionName']);
                 $this->assertEquals('1',$result['result']['plan'][$key]['courseType']);
                 $this->assertEquals('http://testf.gn100.com/1,d2910c74ac02',$result['result']['plan'][$key]['thumbMed']);
             }
        }
       
    }
    
    //传参正确，老师course类型且返回字段是否正确
    public function testTeacherCourse()
    {
        $this->postData['params'] = [
            'teacherId'=>'1',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $arrayResult=array_keys($result['result']['course']);
        $arrayKey=array_column($result['result']['course'],'courseId');
        foreach ($arrayKey as $key => $value)
        {
             if ($arrayKey[$key]=='58')
             {
                 $this->assertEquals('会员课程测试',$result['result']['course']['list'][$key]['title']);
                 $this->assertEquals('小沃',$result['result']['course']['list'][$key]['orgSubname']);
                 $this->assertEquals('1',$result['result']['course']['list'][$key]['courseType']);
                 $this->assertEquals('http://testf.gn100.com/1,d29456187fdc',$result['result']['course']['list'][$key]['thumbMed']);
                 $this->assertEquals('1',$result['result']['course']['list'][$key]['price']);
             }
        }
    }
    
    //翻页
    /* public function testPage($uid="22410",$teacherId='12357')
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
    } */

    
    //传参正确，老师无课程数据
    public function testTeacherNoCourse()
    {
        $this->postData['params'] = [
            'teacherId'=>'12',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEmpty('0',$result['result']['info']['courseCount']);
    }
   
    //必传参数为空，返回值
    public function testParamsIsNull()
    {   
        $this->postData['params'] = [
            'teacherId'=>'',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1000', $result['code']);//请求参数为空
    }
    
    //参数不存在，返回值
    public function testParamsIsNotExist()
    {
        $this->postData['params'] = [
            'teacherId'=>'aa',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('3002', $result['code']);//获取数据失败
    }

}