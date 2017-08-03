<?php

class TestAddAddress extends PHPUnit_Framework_TestCase
{
      protected function setUp()
       {
        //云课添加收获地址
        $this->url="http://test.gn100.com/interface/user/addAddress";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'1000087',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
       }
    
    //参数正确，返回值
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'userId'=>'1000087',
            'receiverUser'=>'18810000024',
            'tel'=>'18810000024',
            'addressStr'=>'五道口',
            'address'=>'1,38,0',
            'remark'=>'发顺丰'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //print_r($result);
        $this->assertEquals('0', $result['code']);
    }
    
    //缺少参数
    public function testParamIsNull()
    {
        $this->postData['params'] = [
            'userId'=>'1000087',
            'receiverUser'=>'18810000024',
            'tel'=>'18810000024',
            'addressStr'=>'五道口',
            'address'=>'',
            'remark'=>'发顺丰'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        $this->assertEquals('1000', $result['code']);
    }
    
}