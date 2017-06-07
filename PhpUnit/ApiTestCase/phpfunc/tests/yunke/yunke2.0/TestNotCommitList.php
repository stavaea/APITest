<?php

class TestNotCommitList extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/studentTask/GetNoCommitList";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK() 
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'taskId'=>'5'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('pk_task', $result['result']['data'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('desc', $result['result']['data'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('仅剩3天', $result['result']['data']['countdown'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('杨明娟', $result['result']['data']['teacherName'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1', $result['result']['data']['fk_user_teacher'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('attach', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('116', $result['result']['thumb'][0]['small_width'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    } 
    
    //参数为空，返回值
    public function testParamsIsNull()
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'taskId'=>''
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1001', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));//缺少必传参数
    }
    
    //参数不存在，返回值
    public function testParamsIsNotExist()
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'taskId'=>'999999'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1051', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));//此作业不存在
    }
    
    
}