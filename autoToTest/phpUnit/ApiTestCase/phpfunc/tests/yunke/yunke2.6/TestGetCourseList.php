<?php

class TestGetCourseList extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        //机构课程列表
        $this->url = "http://test.gn100.com/interface/discountcode/GetCourseList";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'3596',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    
     //参数正确，返回结果(分类)
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'orgId'=>'2',
            'fc'=>'1',
            'sc'=>'6',
            'tc'=>'27',
            'cid'=>'',
            'page'=>'1'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //print_r($result);
        $this->assertArrayHasKey('price', $result['result']['data'][0]);
        $this->assertArrayHasKey('title', $result['result']['data'][0]);
        $this->assertArrayHasKey('thumbBig', $result['result']['data'][0]);
        $this->assertArrayHasKey('userTotal', $result['result']['data'][0]);
        $this->assertArrayHasKey('orgSubname', $result['result']['data'][0]);
    }
    
    //参数正确，指定课程
    public function testSomeCourse()
    {
        $this->postData['params'] = [
            'orgId'=>'2',
            'fc'=>'',
            'sc'=>'',
            'tc'=>'',
            'cid'=>'5087',
            'page'=>'1'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //print_r($result);
        $this->assertEquals('5087', $result['result']['data'][0]['courseId']);
        $this->assertEquals('1', $result['result']['total']);
    }
     
    
    //参数正确，全部课程
    public function testAllCourse()
    {
        $this->postData['params'] = [
            'orgId'=>'2',
            'fc'=>'',
            'sc'=>'',
            'tc'=>'',
            'cid'=>'',
            'page'=>'1'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        //print_r($result);
        $this->assertNotEmpty($result['result']['data']);
    }
    
    //分类不存在，返回结果
   /*  public function  testClassNotExist()
    {
        $this->postData['params'] = [
            'orgId'=>'469',
            'fc'=>'11',
            'sc'=>'11',
            'tc'=>'11',
            'cid'=>'',
            'page'=>'1'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        $this->assertEquals('3000', $result['code']);//数据为空
    }   

    
    //必传参数为空，返回结果
    public function testParamsIsNull()
    {
        $this->postData['params'] = [
            'orgId'=>'',
            'fc'=>'',
            'sc'=>'',
            'tc'=>'',
            'cid'=>'',
            'page'=>'1'
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        $this->assertEquals('1000', $result['code']);
    } */
}