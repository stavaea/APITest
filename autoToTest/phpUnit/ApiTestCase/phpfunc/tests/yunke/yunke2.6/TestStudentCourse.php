<?php

class TestStudentCourse extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/org/studentCourse";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'1',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'userId'=>'1',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        $this->assertArrayHasKey('isDayCourse', $result['result']);//有无课程
        $this->assertArrayHasKey('isDaySign', $result['result']);//是否签到
        $this->assertArrayHasKey('exper', $result['result']);//经验值
        $this->assertArrayHasKey('level', $result['result']);//等级
        $this->assertArrayHasKey('nextEx', $result['result']);//据下个等级所需经验值
        $this->assertArrayHasKey('unfinishNum', $result['result']);//未完成的作业数
        $this->assertArrayHasKey('waitTask', $result['result']);//是否有带批改的作业
        $this->assertArrayHasKey('userScore', $result['result']);//用户积分
        $this->assertArrayHasKey('userFlow', $result['result']);//用户鲜花数
        
    }
}