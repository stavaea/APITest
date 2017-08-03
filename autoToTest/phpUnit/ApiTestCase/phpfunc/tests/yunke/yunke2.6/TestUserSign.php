<?php

class TestUserSign extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/user/Sign";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'1',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
    }
    
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        print_r($result);
    }
}