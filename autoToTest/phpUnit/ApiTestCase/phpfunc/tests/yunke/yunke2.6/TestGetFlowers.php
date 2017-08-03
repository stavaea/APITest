<?php

class TestGetFlowers extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/gift/GetFlowers";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    public  function testDataIsOK()
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'planId'=>'1019'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        print_r($result);
        $this->assertEquals('0', $result['code']);
    }
    
    public function testParmasIsNull()
    {
        $this->postData['params'] = [
            'uId'=>'',
            'planId'=>'1019'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        //print_r($result);
        $this->assertEquals('1001', $result['code']);
    }
}