<?php

class TestFamousList extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/teacher/famouslist";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'page'=>'1',
            'condition'=>'0,7,3',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertArrayHasKey('teacherName', $result['result'][0]['teachers'][0]);
        $this->assertArrayHasKey('imageUrl', $result['result'][0]['teachers'][0]);
        $this->assertArrayHasKey('lessons', $result['result'][0]['teachers'][0]);
        $this->assertArrayHasKey('counts', $result['result'][0]['teachers'][0]);
        $this->assertArrayHasKey('score', $result['result'][0]['teachers'][0]);
    }
    
    
    //缺少参数
    public function testParamsIsNull()
    {
         $this->postData['params'] = [
            'page'=>'1',
            'condition'=>'',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertNotEmpty($result['result']);
    }
}