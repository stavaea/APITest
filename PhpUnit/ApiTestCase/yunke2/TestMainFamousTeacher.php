<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../func/seek.php';

class TestMainFamousTeacher extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    private $seek;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/teacher/famousList";
        $this->http = new HttpClass();
        $this->seek = new seek();
    }
    
    //参数正确，返回数据节点是否正确
    public  function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']='22410';
        $postdata['params']['condition']='2000';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
         //$result=$this->http->HttpPost($this->url, json_encode($postdata));
        $result2=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertArrayHasKey('totalTime', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('type', $result2['result'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('typeId', $result2['result'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('imageUrl', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('teacherId', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));   
        $this->assertArrayHasKey('subjectName', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('teacherName', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('originName', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('score', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('counts', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('lessons', $result2['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

    
    //参数正确，返回初中2000分类下状态正常的老师
    public function testJuniorTeacherData()
    {
        $f=array("teacher_id","user_status","real_name","name","thumb_med","course_count","student_count","avg_score","comment","subject","totaltime");
        $ob=array("comment"=>"desc");
        $q=array("grade_id"=>"2000","course_count"=>"1,5000","teacher_status"=>"1","visiable"=>"1");
        $p=1;
        $pl=6;
        $seekData = $this->seek->TeacherSeek($f, $q, $ob,$p,$pl);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']='22410';
        $postdata['params']['condition']='2000';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(count($seekData['data']), count($result['result'][0]['teachers']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($seekData['data'][0]['teacher_id'], $result['result'][0]['teachers'][0]['teacherId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals(round($seekData['data'][0]['totaltime']/3600), $result['result'][0]['teachers'][0]['totalTime'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals(round($seekData['data'][0]['avg_score'],1),$result['result'][0]['teachers'][0]['score'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($seekData['data'][0]['comment'], $result['result'][0]['teachers'][0]['counts'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals($seekData['data'][0]['course_count'], $result['result'][0]['teachers'][0]['lessons'],'url:'.$this->url.'   Post data:'.json_encode($postdata));

    }
    
    //参数正确，分类最多返回6条数据
    public function testDataIsLeastTen()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']='22410';
        $postdata['params']['condition']='2000';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertLessThanOrEqual(6, count($result['result'][2]['teachers']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
    }
    
    //参数正确，返回数据由评论由高到低排序
    public function testCountSort()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uid']='22410';
        $postdata['params']['condition']='2000';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertLessThanOrEqual($result['result'][1]['teachers'][0]['counts'], $result['result'][1]['teachers'][1]['counts'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    

    protected function tearDown()
    {
        unset($this->http);

    }
    
}