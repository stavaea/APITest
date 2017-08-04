<?php

class TestGetDetailNoteList extends PHPUnit_Framework_TestCase
{
     protected function setUp()
       {
        $this->url = "http://test.gn100.com/interface/note/GetDetailNoteList";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'userId'=>'1',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
       }
    
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'fkUser'=>'1',
            'page'=>'1',
            'classId'=>'43',
            'planId'=>'740'//634   635
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        $this->assertArrayHasKey('content', $result['result']['items'][0]);
        $this->assertArrayHasKey('hidden', $result['result']['items'][0]);
        $this->assertArrayHasKey('tailor', $result['result']['items'][0]);
        $this->assertArrayHasKey('date', $result['result']['items'][0]);
        $this->assertArrayHasKey('time', $result['result']['items'][0]);
        $this->assertArrayHasKey('playTime', $result['result']['items'][0]);
        $this->assertArrayHasKey('playTimeTmpHandle', $result['result']['items'][0]);
        $this->assertArrayHasKey('playTimeFormat', $result['result']['items'][0]);
        $this->assertArrayHasKey('planId', $result['result']['items'][0]);
        $this->assertArrayHasKey('selectName', $result['result']['items'][0]);
    }
    
    
    //传planId，筛选后的数据
    public function testDataPlanId()
    {
         $this->postData['params'] = [
            'fkUser'=>'1',
            'page'=>'1',
            'classId'=>'40',
            'planId'=>'634'//634   635
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        for($i=0;$i<count($result['result']['items']);$i++)
        {
            $this->assertEquals('634', $result['result']['items'][$i]['planId']);
        }
        
    }
    
    //参数planId不存在，返回值
    public function testPlanIdIsNotExist()
    {
         $this->postData['params'] = [
            'fkUser'=>'1',
            'page'=>'1',
            'classId'=>'40',
            'planId'=>'aaaa'//634   635
        ];
        $result = interfaceFunc::getPostTokenData($this->url, $this->postData);
        $this->assertEquals(NULL,$result['result']);
    }
}