<?php

class TestTaskShow extends PHPUnit_Framework_TestCase
{
     protected function setUp()
     {
        //已批改详情页
        $this->url = "http://test.gn100.com/interface/studentTask/TaskShow";
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
            'uId'=>'1',
            'fkTaskStudent'=>'3'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('2017-06-07 星期三 14:30', $result['result']['reply']['data']['lastUpdatedHandle']);
        $this->assertEquals('4', $result['result']['reply']['data']['level']);
        $this->assertEquals('05-24 18:17', $result['result']['publish']['data']['startTimeHandle']);
        $this->assertArrayHasKey('taskInfo', $result['result']);
      
        //$this->assertNotEmpty(count($result['result']['publish']['tag']));
    }
    
    //必传参数为空，返回值
    public function testParamsIsNull()
    {
        $this->postData['params'] = [
            'uId'=>'',
            'fkTaskStudent'=>'3'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1052', $result['code']);//不是此学生作业
    }
    
    
}