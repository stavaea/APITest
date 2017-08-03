<?php

class TestAddPlanFlower extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        //判断是否可以领取鲜花
        $this->url = "http://test.gn100.com/interface/gift/AddPlanFlower";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'planId'=>'740',
            'uId'=>'1',
            'courseId'=>'43'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        print_r($result);
        $this->assertEquals('2075', $result['code']);//超时不能领取
    }
    
    public function testNotBaoming()
    {
        $this->postData['params'] = [
            'planId'=>'308',
            'uId'=>'1',
            'courseId'=>'26'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        print_r($result);
        $this->assertEquals('2052', $result['code']);//未报名此课程
    }
    
    public function testParamsIsNull()
    {
        $this->postData['params'] = [
            'planId'=>'308',
            'uId'=>'',
            'courseId'=>'26'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        print_r($result);
        $this->assertEquals('1001', $result['code']);//缺少参数
    }
}