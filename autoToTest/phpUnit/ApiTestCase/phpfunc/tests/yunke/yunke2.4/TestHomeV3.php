<?php

class TestHomeV3 extends PHPUnit_Framework_TestCase
{
    protected function setUp()
       {
        $this->url = "http://test.gn100.com/interface/main/homev3";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
       }
    
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'uid'=>'1',
            'condition'=>'1,7,29'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertArrayHasKey('banner', $result['result']);
        $this->assertEquals('3', count($result['result']['subject']));
        $this->assertEquals('直播课', $result['result']['types'][0]['name']);
        $this->assertEquals('录播课', $result['result']['types'][1]['name']);
        $this->assertEquals('免费课', $result['result']['types'][2]['name']);
        $this->assertArrayHasKey('userWillPlan', $result['result']);
        $this->assertArrayHasKey('courseName', $result['result']['trySeeList'][0]['list'][0]);
        $this->assertArrayHasKey('stime', $result['result']['trySeeList'][0]['list'][0]);
        $this->assertArrayHasKey('sectionName', $result['result']['trySeeList'][0]['list'][0]);
        if(count($result['result']['trySeeList'])!=0)
        {
            for($i=0;$i<count($result['result']['trySeeList'])-1;$i++)
            {
                   $this->assertGreaterThanOrEqual(strtotime($result['result']['trySeeList'][$i+1]['time']), strtotime($result['result']['trySeeList'][$i]['time']));
            }
        } 
        $this->assertArrayHasKey('courseName', $result['result']['courseList'][0]);
        $this->assertArrayHasKey('subname', $result['result']['courseList'][0]);
        if(count($result['result']['courseList'])!=0)
        {
            $this->assertArrayHasKey('courseName', $result['result']['courseList'][0]);
            $this->assertArrayHasKey('subname', $result['result']['courseList'][0]);
            for($j=0;$j<count($result['result']['courseList'])-1;$j++)
            {
                  $this->assertGreaterThanOrEqual($result['result']['courseList'][$j+1]['userTotal'], $result['result']['courseList'][$j]['userTotal']);
            }
        }
        
        
        
    }
    
    
}