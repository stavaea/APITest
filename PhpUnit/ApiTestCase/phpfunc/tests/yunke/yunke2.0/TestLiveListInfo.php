<?php

class TestLiveListInfo extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/plan/latelyLiveList";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    //参数正确，返回的数据节点是否正确
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'userId'=>'',
            'sTime'=>'2017-06-06',
            'page'=>'1',
            'length'=>'20',
            'cateId'=>'7'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('isSign', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('courseId', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('planId', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('className', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('classId', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('trys', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('courseName', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('courseImg', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('sectionName', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('status', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('stime', $result['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    

    //参数正确，返回的直播课信息正确
    public function testLiveCourseInfo()
    {
        $this->postData['params'] = [
            'userId'=>'',
            'sTime'=>'2017-06-06',
            'page'=>'1',
            'length'=>'20',
            'cateId'=>'7'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('0', $result['result']['data'][0]['isSign'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('27', $result['result']['data'][0]['courseId'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('521', $result['result']['data'][0]['planId'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1班', $result['result']['data'][0]['className'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('27', $result['result']['data'][0]['classId'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('0', $result['result']['data'][0]['trys'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('5月24日直播课整数', $result['result']['data'][0]['courseName'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('第14课时', $result['result']['data'][0]['sectionName'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1', $result['result']['data'][0]['status'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('10:17', $result['result']['data'][0]['stime'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
    
    //sTime为2016-11-25，没有直播课程
    public function testDataIsNull($oid='0')
    {
        $this->postData['params'] = [
            'userId'=>'',
            'sTime'=>'2016-11-25',
            'page'=>'1',
            'length'=>'20',
            'cateId'=>'9'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('3002', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        
    }
    
}