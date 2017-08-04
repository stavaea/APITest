<?php

class TestStudentTaskList extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/studentTask/StudentTaskList";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    //参数正确，返回节点是否正确
    public function testGetUncommitTaskNum($uid='1')
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'page'=>'1',
            'status'=>'0'//未提交
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        return $result['result']['page']['total'];
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK($uId='1')
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'page'=>'1',
            'status'=>'0'//未提交
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        $this->assertArrayHasKey('page', $result['result']);
        $this->assertArrayHasKey('data', $result['result']);
    }
    
    //未提交作业，排序按发布作业日期
    public function testNotCommitSort()
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'page'=>'1',
            'status'=>'0'//未提交
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
		if($result['result']['page']['total']>1)
        {
           $this->assertGreaterThanOrEqual($result['result']['data'][1]['day'], $result['result']['data'][0]['day']);
        }
        
    }
    
    //已批改作业，排序按提交作业日期
    public function testNReplySort()
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'page'=>'1',
            'status'=>'2'//未批改
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        if($result['result']['page']['total']>1)
        {
            $this->assertGreaterThanOrEqual($result['result']['data'][1]['days'][0]['reply_time'], $result['result']['data'][0]['days'][0]['reply_time']);
        }
    
    }
    
    //必填参数为空，返回值
    public function testParamsIsNull()
    {
        $this->postData['params'] = [
            'uId'=>'',
            'page'=>'1',
            'status'=>'0'//未提交
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1001', $result['code']);//缺少必填参数
        
    }
    
    //status为空，返回值,默认是status=0
    public function testStatusIsNull()
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'page'=>'1',
            'status'=>''//默认0
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('4', $result['result']['data'][0]['days'][0]['student_status']);
    }
    
    //page参数很大，返回值
    public function testPageIsBig()
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'page'=>'111111111111111',
            'status'=>'0'//未提交
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1054', $result['code']);//作业列表为空
    }
    
    //status不存在时，返回值
    public function testStatusIsNotExist()
    {
        $this->postData['params'] = [
            'uId'=>'1',
            'page'=>'1',
            'status'=>'5'//不存在的状态值
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        $this->assertEmpty($result['result']['data']);
    }
    
   
}