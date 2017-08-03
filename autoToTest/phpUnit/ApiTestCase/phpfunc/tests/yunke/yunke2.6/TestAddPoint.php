<?php

class TestAddPoint extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/point/AddPoint";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'type'=>'1'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
    }
}