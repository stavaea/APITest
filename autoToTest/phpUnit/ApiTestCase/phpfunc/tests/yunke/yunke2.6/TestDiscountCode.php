<?php

class TestDiscountCode extends PHPUnit_Framework_TestCase
{
     protected function setUp()
       {
        $this->url = "http://test.gn100.com/interface/discountcode/DiscountCode";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'1000107',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
       }
    
    //参数正确，未使用(有objectId返回该课程下可使用的优惠券)
    public function testDataNotUsed()
    {
        $this->postData['params'] = [
            'userId'=>'1000107',
            'page'=>'1',
            'status'=>'0'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //print_r($result);
        $this->assertArrayHasKey('discount_value', $result['data']['items'][0]);
        $this->assertArrayHasKey('min_fee', $result['data']['items'][0]);
        $this->assertArrayHasKey('left_num', $result['data']['items'][0]);//剩余次数
        $this->assertArrayHasKey('org_name', $result['data']['items'][0]);
        $this->assertArrayHasKey('range_name', $result['data']['items'][0]);
        $this->assertArrayHasKey('time_limit', $result['data']['items'][0]);
    }
    
    //必传参数为空，返回结果
    public function testParamIsNull()
    {
        $this->postData['params'] = [
            'userId'=>'',
            'page'=>'1',
            'status'=>'0'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //print_r($result);
        $this->assertEquals('1000', $result['code']);
    }
    
    //参数正确，无可用优惠券
    public function testNoDiscountCode()
    {
        $this->postData['params'] = [
            'userId'=>'1000064',
            'page'=>'1',
            'status'=>'0'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //print_r($result);
        $this->assertEquals('4005', $result['code']);//没有优惠券
    }
    
    
    
    
}