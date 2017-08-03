<?php

class TestOrgTeacherList extends PHPUnit_Framework_TestCase
{
     protected function setUp()
      {
        $this->url = "http://test.gn100.com/interface/org/teacherList";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
      }
    
    //参数正确，返回数据内容
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'orgId'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('20', count($result['result']['data']));
        $this->assertArrayHasKey('name', $result['result']['data'][0]);
        $this->assertArrayHasKey('thumbMed', $result['result']['data'][0]);
        $this->assertArrayHasKey('score', $result['result']['data'][0]);
        $this->assertArrayHasKey('grade', $result['result']['data'][0]);
        $this->assertArrayHasKey('subjectName', $result['result']['data'][0]);
        $this->assertArrayHasKey('courseTotal', $result['result']['data'][0]);
    }
}