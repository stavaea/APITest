<?php

class TestLive extends PHPUnit_Framework_TestCase
{
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/plan/latelyLiveTop";
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
            'userId'=>''
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals(0, $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('days', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('cateList', $result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
    //校验cateList信息
    public function testCateList()
    {
        $this->postData['params'] = [
            'userId'=>''
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals(0, $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData)); 
        $this->assertEquals('全部', $result['result']['cateList'][0]['cateName'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('小学', $result['result']['cateList'][1]['cateName'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('初中', $result['result']['cateList'][2]['cateName'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('高中', $result['result']['cateList'][3]['cateName'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    
    //判断返回的日期是否本周的所有日期
     public function testDateIsWeek()
    {
        $this->postData['params'] = [
            'userId'=>''
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        for($i=0;$i<=5;$i++)
        {
            $days=(strtotime(date('Y-m-d'))-strtotime($result['result']['days'][$i]['dayTime']))/(3600*24);
            if(abs($days)<=6)
            {
                $aa='是这个周的';
                $this->assertEquals('是这个周的', $aa,'url:'.$this->url.'   Post data:'.json_encode($this->postData));
            }
            else 
            {
                $this->assertEquals('是这个周的', $aa,'url:'.$this->url.'   Post data:'.json_encode($this->postData));
            }
            
        }
    }
     
    
}