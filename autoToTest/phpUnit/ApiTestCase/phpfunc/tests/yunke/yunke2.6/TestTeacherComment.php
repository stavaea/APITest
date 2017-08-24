<?php

class TestTeacherComment extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/teacher/CommentNew";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    
    //参数正确，返回结果
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'teacherId'=>'1',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        //print_r($result);
        $this->assertArrayHasKey('userName', $result['result']['list'][0]);
        $this->assertArrayHasKey('thumbMed', $result['result']['list'][0]);
        $this->assertArrayHasKey('comment', $result['result']['list'][0]);
        $this->assertArrayHasKey('className', $result['result']['list'][0]);
        $this->assertArrayHasKey('sectionName', $result['result']['list'][0]);
        $this->assertArrayHasKey('time', $result['result']['list'][0]);
        $this->assertArrayHasKey('score', $result['result']['list'][0]);
    }
    
    //参数正确，返回有回复消息的
    public function testHaveReply()
    {
        $this->postData['params'] = [
            'teacherId'=>'1',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        print_r($result);
        $this->assertArrayHasKey('replay', $result['result']['list'][1]);
        $this->assertArrayHasKey('manage_name', $result['result']['list'][1]['replay']);//回复人名称
        $this->assertArrayHasKey('contents', $result['result']['list'][1]['replay']);//回复内容
        $this->assertArrayHasKey('replay_time', $result['result']['list'][1]['replay']);//回复时间
        $this->assertArrayHasKey('status', $result['result']['list'][1]['replay']);//暂时没用
    }
}