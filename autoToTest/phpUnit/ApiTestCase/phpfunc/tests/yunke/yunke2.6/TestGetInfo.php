<?php

class TestGetInfo extends PHPUnit_Framework_TestCase
{
     protected function setUp()
       {
        //云课收货地址
        $this->url="http://test.gn100.com/interface/user/GetInfo";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'1',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
       }
    
    //参数正确，返回结果
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //var_dump($result);
        $this->assertEquals('杨明娟老师', $result['result']['nickName']);
        $this->assertEquals('http://testf.gn100.com/5,cf0e19ade357', $result['result']['image']);
        $this->assertEquals('15510720812', $result['result']['mobile']);
        $this->assertEquals('杨明娟老师', $result['result']['realName']);
        $this->assertEquals('女', $result['result']['sex']);
        $this->assertEquals('北京市,东城区', $result['result']['address']);
        $this->assertEquals('1,36,0', $result['result']['addressId']);
        $this->assertEquals('1', $result['result']['schoolType']);
        $this->assertEquals('北京市东城区北官厅小学', $result['result']['school']);
        $this->assertEquals('3', $result['result']['schoolId']);
        $this->assertEquals('五年级', $result['result']['grade']);
        $this->assertEquals('1005', $result['result']['gradeId']);
        $this->assertEquals('1991-07-25', $result['result']['birthday']);
        $this->assertEquals('32', $result['result']['addressInfo']['addressId']);
        $this->assertEquals('杨明娟', $result['result']['addressInfo']['receiverUser']);
        $this->assertEquals('15510720812', $result['result']['addressInfo']['tel']);
        $this->assertEquals('重庆市', $result['result']['addressInfo']['province']);
        $this->assertEquals('大渡口区', $result['result']['addressInfo']['city']);
        $this->assertEquals('', $result['result']['addressInfo']['country']);
        $this->assertEquals('唱歌喝酒呢', $result['result']['addressInfo']['address']);
        $this->assertEquals('哥哥哥哥', $result['result']['addressInfo']['remark']);//备注
        
        
    }
    
    //传参正确，未填收货地址
    public function testAddressIsNull()
    {
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'1000088',
            'time'=> strtotime(date('Y-m-d H:i:s'))
            ];
        $this->postData['params'] = [
            'uid'=>'1000088'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
       
        $this->assertEmpty($result['result']['addressInfo']);//收货地址为空
    }
    
    
    public function testAddAddressInfo($uid='')
    {
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'',
            'time'=> strtotime(date('Y-m-d H:i:s'))
            ];
        $this->postData['params'] = [
            'uid'=>''
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        
        $this->assertEquals('1022', $result['code']);//参数类型不合法
    }
}