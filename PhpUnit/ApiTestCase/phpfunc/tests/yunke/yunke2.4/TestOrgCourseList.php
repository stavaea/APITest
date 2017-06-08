<?php

class TestOrgCourseList extends PHPUnit_Framework_TestCase
{
     protected function setUp()
      {
        $this->url = "http://test.gn100.com/interface/org/courseList";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
      }
    
    //参数正确，返回数据
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'orgId'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertArrayHasKey('title', $result['result']['data'][0]);
        $this->assertArrayHasKey('thumbMed', $result['result']['data'][0]);
        $this->assertArrayHasKey('subject', $result['result']['data'][0]);
        $this->assertArrayHasKey('userTotal', $result['result']['data'][0]);
        $this->assertArrayHasKey('price', $result['result']['data'][0]);
        $this->assertArrayHasKey('courseType', $result['result']['data'][0]);
        $this->assertArrayHasKey('title', $result['result']['data'][0]);
        
    }
}