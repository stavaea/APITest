<?php

class TestInterest extends PHPUnit_Framework_TestCase
{
     protected function setUp()
       {
        $this->url = "http://test.gn100.com/interface/config/interest";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'oid'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
       }

    public function testDataIsOK()
    {
        $this->postData['params'] = [  
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('学前', $result['result'][0]['data'][0]['name']);
        $this->assertEquals('2', count($result['result'][0]['data'][0]['data']));
        $this->assertEquals('小学', $result['result'][0]['data'][1]['name']);
        $this->assertEquals('5', count($result['result'][0]['data'][1]['data']));
        $this->assertEquals('初中', $result['result'][0]['data'][2]['name']);
        $this->assertEquals('3', count($result['result'][0]['data'][2]['data']));
        $this->assertEquals('高中', $result['result'][0]['data'][3]['name']);
        $this->assertEquals('2', count($result['result'][0]['data'][3]['data']));
    }
}