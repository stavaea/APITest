<?php

class TestTeacherComment extends PHPUnit_Framework_TestCase
{
protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/teacher/commentv2";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
    
    
 
    //参数正确，返回字段是否正确
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'teacherId'=>'2',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('20', $result['result']['total']);
        $this->assertEquals('1', $result['result']['totalPage']);
        $this->assertEquals('1', $result['result']['page']);
        $this->assertEquals('0', $result['result']['data'][3]['userId']);
        $this->assertEquals("冯佳欣", $result['result']['data'][3]['userName']);
        $this->assertArrayHasKey("userImage", $result['result']['data'][3]);
        $this->assertContains("学习完", $result['result']['data'][3]['content']);
        $this->assertEquals('5', $result['result']['data'][3]['score']);
        $this->assertEquals("2017-08-05 17:37:49", $result['result']['data'][3]['time']);
        $this->assertEquals("测试环境-录播课", $result['result']['data'][3]['course']);
        $this->assertEquals("1班", $result['result']['data'][3]['class']);
        $this->assertEquals("第1课时", $result['result']['data'][3]['section']);
    }
    
    //参数正确，评论为空
    public function testCommentIsEmpty()
    {
        $this->postData['params'] = [
            'teacherId'=>'11',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('3002', $result['code']);
    }
    
    //参数正确，翻页
    /* public function testCommentPage($tid='35655')
    {
        $this->postData['params'] = [
            'teacherId'=>'1',
            'page'=>'2',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertNotEmpty($result['result']['data']);
    } */
    
    //必填参数为空，返回值
    public function testParamsIsNull()
    {
        $this->postData['params'] = [
            'teacherId'=>'',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1000', $result['code']);//请求参数为空
    }
    
    //参数不存在，返回值
    public function testParamsIsNotExist()
    {
        $this->postData['params'] = [
            'teacherId'=>'aa',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('3002', $result['code']);//获取数据失败
    }
    
   
    //按评分高低排序
    public function testTimeSort()
    {
        $this->postData['params'] = [
            'teacherId'=>'2',
            'page'=>'1',
            'length'=>'20'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        if($result['result']['total']>=2)
        {
            $this->assertGreaterThanOrEqual($result['result']['data'][1]['score'], $result['result']['data'][0]['score']);
        }
        
    }
    
}