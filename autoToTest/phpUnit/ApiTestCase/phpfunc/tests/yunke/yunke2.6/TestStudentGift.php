<?php

class TestStudentGift extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        //礼物展示
        $this->url = "http://test.gn100.com/interface/gift/getStudentGift";
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
            'planId'=>'516',
            'uId'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        //print_r($result);
        $this->assertArrayHasKey('point', $result['result']);
        $this->assertArrayHasKey('redNameCardStatus', $result['result']);//红名卡使用状态  1使用中  0未使用
        $this->assertArrayHasKey('bubble', $result['result']);//气泡
        $this->assertArrayHasKey('grass', $result['result']);//小草
        $this->assertArrayHasKey('giftSum', $result['result']);//该排课下老师得到的鲜花
        $this->assertArrayHasKey('name', $result['result']['gift'][0]);
        $this->assertArrayHasKey('giftId', $result['result']['gift'][0]);
        $this->assertArrayHasKey('giftCount', $result['result']['gift'][0]);
        
    }
    
    //缺少参数
    public function testParamIsNull()
    {
        $this->postData['params'] = [
            'planId'=>'',
            'uId'=>''
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1001', $result['code']);
    }
    
    //排课信息获取失败
    public function testPlanIdIsError()
    {
        $this->postData['params'] = [
            'planId'=>'aa',
            'uId'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('-103', $result['code']);
    }
}