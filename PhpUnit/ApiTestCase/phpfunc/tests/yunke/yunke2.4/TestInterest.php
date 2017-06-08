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
        
        $this->assertEquals('小学', $result['result'][0]['data']['name']);
        $this->assertEquals('10', count($result['result'][0]['data']['data']));
        $this->assertEquals('初中', $result['result'][1]['data']['name']);
        $this->assertEquals('6', count($result['result'][1]['data']['data']));
        $this->assertEquals('高中', $result['result'][2]['data']['name']);
        $this->assertEquals('6', count($result['result'][2]['data']['data']));
    }
}