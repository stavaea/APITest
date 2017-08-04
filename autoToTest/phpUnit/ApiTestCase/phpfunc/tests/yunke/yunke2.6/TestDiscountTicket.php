<?php

class TestDiscountTicket extends PHPUnit_Framework_TestCase
{
     protected function setUp()
       {
          //该课程下可用的优惠码
        $this->url = "http://test.gn100.com/interface/discountcode/DiscountTicket";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'1',
            'oid'=>'28',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
       }
    
    //参数正确，返回结果
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'userId'=>'1000107',
            'objectId'=>'87'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        var_dump($result);
        $this->assertLessThanOrEqual('10', $result['result']['codeList'][0]['priceOld']);
    }
    
    
    //必传参数为空，返回结果
    public function testParamsIsNull()
    {
        $this->postData['params'] = [
            'userId'=>'',
            'objectId'=>'5295'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        $this->assertEquals('1000',$result['code']);
    }
    
    //课程无可用优惠券，返回结果
    public function testNotTicket()
    {
        $this->postData['params'] = [
            'userId'=>'1',
            'objectId'=>'5299'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //print_r($result);
        $this->assertEquals('30000',$result['code']);//无可用的优惠券
    }
}