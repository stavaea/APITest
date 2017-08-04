<?php

class TestUpdateAddress extends PHPUnit_Framework_TestCase
{
     protected function setUp()
       {
        
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'1000087',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
       }
    
    
    public function testDataIsOK()
    {
        $url = "http://test.gn100.com/interface/user/updateAddress";
        $this->postData['params'] = [
            'userId'=>'1000087',
            'receiverUser'=>'18810000024',
            'tel'=>'18810000024',
            'addressStr'=>'我改了一下地址',
            'address'=>'我改了一下地址',
            'remark'=>'我改了一下地址哦',
            'addressId'=>'50'
        ];
        $result = interfaceFunc::getPostTokenData($url, $this->postData);
        
    }
    
    public function testGetInfo()
    {
        $url = "http://test.gn100.com/interface/user/GetInfo";
        $this->postData['params'] = [
            'uid'=>'1000087'
        ];
        $result = interfaceFunc::getPostTokenData($url, $this->postData);
        print_r($result);
        $this->assertEquals('我改了一下地址', $result['result']['addressInfo']['address']);
        $this->assertEquals('我改了一下地址哦', $result['result']['addressInfo']['remark']);
    }
}