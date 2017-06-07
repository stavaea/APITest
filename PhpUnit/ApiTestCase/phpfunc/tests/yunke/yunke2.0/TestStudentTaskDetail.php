<?php

class TestStudentTaskDetail extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url="http://test.gn100.com/interface/studentTask/StudentTaskDetail";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'pkTaskStudent'=>'3',
            'uId'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('2', $result['result']['commit']['data']['fk_task']);
        $this->assertEquals('我提交作业了', $result['result']['commit']['data']['desc']);
        $this->assertEquals('2017-05-24 18:19:13', $result['result']['commit']['data']['last_updated']);
        $this->assertEquals('马静', $result['result']['taskInfo']['teacherName']);
    }
    
    
    //pkTaskStudent参数为空，返回值
    public function testpkTaskStudentIsNull()
    {
        $this->postData['params'] = [
            'pkTaskStudent'=>'',
            'uId'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    }
    
    //pkTaskStudent参数不存在，返回值
    public function testpkTaskStudentIsNotExsit()
    {
        $this->postData['params'] = [
            'pkTaskStudent'=>'11111111111111',
            'uId'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1051', $result['code']);//此作业不存在
    }
    
    //uId为空或者是pk=142，返回值
    public function testuIdIsNull()
    {
        $this->postData['params'] = [
            'pkTaskStudent'=>'1',
            'uId'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1052', $result['code']);//不是此学生作业
    }
    
}