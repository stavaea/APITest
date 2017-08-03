<?php

class TestExchangeCode extends PHPUnit_Framework_TestCase
{
     protected function setUp()
       {
        $this->url = "http://test.gn100.com/interface/discountcode/ExchangeCode";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'oid'=>'28',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
       }
    //传参正确，返回数据结果
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'userId'=>'1',
            'code'=>'2fnqg'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        //$this->assertEquals('-1', $result['code']);//已经兑换过了
    }
    //code不存在
    public function testCodeIsCorrect()
    {
        $this->postData['params'] = [
            'userId'=>'1',
            'code'=>'aa'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('-1', $result['code']);//请输入有效的优惠码
    }
    
    //userId为空，返回结果
    public function testParamsIsNull()
    {
        $this->postData['params'] = [
            'userId'=>'',
            'code'=>'768ys'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1000', $result['code']);//
    }
}