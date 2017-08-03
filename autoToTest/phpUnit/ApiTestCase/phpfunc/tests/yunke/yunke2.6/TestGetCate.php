<?php

class TestGetCate extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        //机构课程分类
        $this->url = "http://dev.gn100.com/interface/discountcode/GetCate";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'3596',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    
    //参数正确，返回结果
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'orgId'=>'469'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //print_r($result);
        $this->assertEquals('3', count($result['result']['cateList']));
        $this->assertEquals('学前/升学', $result['result']['cateList'][0]['name']);
        $this->assertEquals('大学/考研', $result['result']['cateList'][1]['name']);
        $this->assertEquals('生活/兴趣', $result['result']['cateList'][2]['name']);
        $this->assertEquals('4', count($result['result']['cateList'][0]['child']['cateList']));
        $this->assertEquals('5', count($result['result']['cateList'][1]['child']['cateList']));
        $this->assertEquals('3', count($result['result']['cateList'][2]['child']['cateList']));
    }
    
    //参数为空，返回结果
    public function testParamIsNull()
    {
        $this->postData['params'] = [
            'orgId'=>''
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        $this->assertEquals('1000', $result['code']);
    }
    
    //参数不存在，返回结果
    public function testOrgIsNotExist()
    {
        $this->postData['params'] = [
            'orgId'=>'555555'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        print_r($result);
        $this->assertEquals('3000', $result['code']);
    }
}