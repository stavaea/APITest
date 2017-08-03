<?php

class TestTeacherPoint extends PHPUnit_Framework_TestCase
{
protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/video/GetTeacherPoint";
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
            'planId'=>'741',
            'rtime'=>'0'//无缓存
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('32', $result['result']['items'][0]['pTime']);
        $this->assertEquals('视频打点1', $result['result']['items'][0]['content']);
        $this->assertEquals('32', $result['result']['items'][0]['playTimeTmpHandle']);
        $this->assertEquals('00:00:32', $result['result']['items'][0]['playTimeFormat']);
        
    }
    
    //planId为空，返回值
    public function testPlanIdIsNull()
    {
        $this->postData['params'] = [
            'planId'=>'',
            'rtime'=>'0'//无缓存
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    }
    
    //planId不存在，返回值
    public function testPlanIdIsNotExist()
    {
        $this->postData['params'] = [
            'planId'=>'00000',
            'rtime'=>'0'//无缓存
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    }
    
    
    //被剪辑后视频打点信息,视频被剪辑掉了前3分钟
    public function testVideoEdit()
    {
        $this->postData['params'] = [
            'planId'=>'741',
            'rtime'=>'0'//无缓存
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('32', $result['result']['items'][0]['pTime']);
        $this->assertEquals('视频打点1', $result['result']['items'][0]['content']);
        $this->assertEquals('269', $result['result']['items'][1]['playTimeTmpHandle']);
        $this->assertEquals('00:04:29', $result['result']['items'][1]['playTimeFormat']);
    }
    
    
}