<?php

class TestInitClass extends PHPUnit_Framework_TestCase
{
      protected function setUp()
       {
           //初始化上课接口（点击进入详情页拿到所有需要的数据）
            $this->url = "http://test.gn100.com/interface/play/planinfo";
            $this->postData = [
                'u'=>'i',
                'v'=>'2',
                'uid'=>'1',
                'time'=> strtotime(date('Y-m-d H:i:s'))
              ];
       }

    
    //缺少参数，返回结果
    public function testParamsIsNull()
    {
        $this->postData['params'] = [
            'planId'=>''
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1000', $result['code']);//请求参数为空
    }
    
     //参数正确，返回数据节点
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'planId'=>'741'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        var_dump($result);
        $this->assertArrayHasKey('stream', $result['result']);
        $this->assertArrayHasKey('plan', $result['result']);
        $this->assertArrayHasKey('announcement', $result['result']);
        $this->assertArrayHasKey('examInfo', $result['result']);
        $this->assertArrayHasKey('share', $result['result']);
        
    }
    
    
    //参数正确，第一次进入直播页面，无公告，返回结果
    public function testOneLiveNotAnnoucement()
    {
        $this->postData['params'] = [
            'planId'=>'741'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEmpty($result['result']['announcement']);
    }
    
    
    //参数正确，再次进入播放页面，有公告，返回结果
    public function testLiveAnnoucement()
    {
        $this->postData['params'] = [
            'planId'=>'747'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('发布公告呀', $result['result']['announcement']['content']);
    }
    
    
    //参数正确，无备课返回值
    public function testNotQuestion()
    {
        $this->postData['params'] = [
            'planId'=>'741'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEmpty($result['result']['examInfo']);
    }
    
    //参数正确，有备课返回值
    public function testQuestion()
    {
        $this->postData['params'] = [
            'planId'=>'753'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertNotEmpty($result['result']['examInfo']);
    }
     
    
    
}