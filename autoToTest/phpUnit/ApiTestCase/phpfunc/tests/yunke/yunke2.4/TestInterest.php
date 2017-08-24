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
        $this->assertEquals('6', count($result['result'][0]['data'][0]['id']));
        $this->assertEquals('小学', $result['result'][0]['data'][1]['name']);
        $this->assertEquals('7', count($result['result'][0]['data'][1]['id']));
        $this->assertEquals('初中', $result['result'][0]['data'][2]['name']);
        $this->assertEquals('8', count($result['result'][0]['data'][2]['id']));
        $this->assertEquals('高中', $result['result'][0]['data'][3]['name']);
        $this->assertEquals('9', count($result['result'][0]['data'][3]['id']));
    }
}