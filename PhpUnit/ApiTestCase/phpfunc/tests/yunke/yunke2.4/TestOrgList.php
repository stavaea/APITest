<?php

class TestOrgList extends PHPUnit_Framework_TestCase
{
     protected function setUp()
       {
        $this->url = "http://test.gn100.com/interface/org/list";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
             ];
       }
    
    //参数正确，返回数据结果(北京市)
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'provinceId'=>'1',
            'page'=>'1',
            'length'=>'20',
            'sort'=>'1000'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        for($i=0;$i<count($result['result']['data']);$i++)
        {
   
           $this->assertEquals('北京市', $result['result']['data'][$i]['provinceName']);
           $this->assertArrayHasKey('teacherNum', $result['result']['data'][$i]);
           $this->assertArrayHasKey('courseNum', $result['result']['data'][$i]);
           $this->assertArrayHasKey('studnetNum', $result['result']['data'][$i]);
        }
    }
    
    
    //排序，按课程数
    public function testCourseSort()
    {
        $this->postData['params'] = [
            'provinceId'=>'1',
            'page'=>'1',
            'length'=>'20',
            'sort'=>'2000'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
		//$lgth = count($result['result']['data']);
        $this->assertGreaterThanOrEqual($result['result']['data']['3']['courseNum'], $result['result']['data']['0']['courseNum']);
    }
    
    //排序，按老师数
    public function testTeacherSort()
    {
        $this->postData['params'] = [
            'provinceId'=>'1',
            'page'=>'1',
            'length'=>'20',
            'sort'=>'3000'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
		//$lgth = count($result['result']['data']);
        $this->assertGreaterThanOrEqual($result['result']['data']['3']['teacherNum'], $result['result']['data']['0']['teacherNum']);
    }
}