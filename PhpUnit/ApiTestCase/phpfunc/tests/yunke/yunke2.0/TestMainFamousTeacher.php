<?php

class TestMainFamousTeacher extends PHPUnit_Framework_TestCase
{
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/teacher/famousList";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    //参数正确，返回数据节点是否正确
    public  function testDataIsOK()
    {
        $this->postData['params'] = [
            'uid'=>'1',
            'condition'=>'2000'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertArrayHasKey('totalTime', $result['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('type', $result['result'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('typeId', $result['result'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('imageUrl', $result['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('teacherId', $result['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));   
        $this->assertArrayHasKey('subjectName', $result['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('teacherName', $result['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('originName', $result['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('score', $result['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('counts', $result['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('lessons', $result['result'][0]['teachers'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }

    
    //参数正确，返回初中2000分类下状态正常的老师
     public function testJuniorTeacherData()
    {

        $f=array("teacher_id","user_status","real_name","name","thumb_med","course_count","student_count","avg_score","comment","subject","totaltime");
        $ob=array("comment"=>"desc");
        $q=array("grade_id"=>"2000","course_count"=>"1,5000","teacher_status"=>"1","visiable"=>"1");
        $p=1;
        $pl=6;
        $seekData = seekFunc::TeacherSeek($f, $q, $ob,$p,$pl);
        
        $this->postData['params'] = [
            'uid'=>'1',
            'condition'=>'2000'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals(count($seekData['data']), count($result['result'][0]['teachers']));
        $this->assertEquals($seekData['data'][0]['teacher_id'], $result['result'][0]['teachers'][0]['teacherId']);
        $this->assertEquals(round($seekData['data'][0]['totaltime']/3600), $result['result'][0]['teachers'][0]['totalTime']);
        $this->assertEquals(round($seekData['data'][0]['avg_score'],1),$result['result'][0]['teachers'][0]['score']);
        $this->assertEquals($seekData['data'][0]['course_count'], $result['result'][0]['teachers'][0]['lessons']);

    } 
    
    //参数正确，分类最多返回6条数据
    public function testDataIsLeastTen()
    {
        $this->postData['params'] = [
            'uid'=>'1',
            'condition'=>'2000'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertLessThanOrEqual(6, count($result['result'][2]['teachers']),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        
    }
    
    //参数正确，返回数据由评论由高到低排序
    public function testCountSort()
    {
        $this->postData['params'] = [
            'uid'=>'1',
            'condition'=>'2000'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertLessThanOrEqual($result['result'][1]['teachers'][0]['counts'], $result['result'][1]['teachers'][1]['counts'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
}