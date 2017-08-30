<?php

class TestMain extends PHPUnit_Framework_TestCase
{
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/main/homev2";
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
            'condition'=>'',
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals(0, $result['code']);
        //比对是否存在相应的节点数据
        $this->assertArrayHasKey('ad',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('types',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('lives',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('interests',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertArrayHasKey('recommends',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }


   //传参正确，返回二级分类列表正确，接口写死，返回1000、2000、3000、0
     public function testTypes()
    {
        $arraytype=array("小学","初中","高中","全部");
        $this->postData['params'] = [
            'condition'=>'',
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEmpty(array_diff($arraytype,array_column($result['result']['types'],'name')));          
    }
    
    //传参正确，recommend模块返回
    public function testSc()
    {
        $this->postData['params'] = [
            'condition'=>'',
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('8',count($result['result']['recommends']['1']['list']),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
    //传参正确，直播课堂模块，返回日期和list模块类型和字段正确，array
    public function testLive()
    {
       $this->postData['params'] = [
            'condition'=>'',
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $arrayResult=array_keys($result['result']['lives']);
        $this->assertTrue(is_int($arrayResult[0]),'url:'.$this->url.'   Post data:'.json_encode($this->postData));

    }
      //推荐模块课程信息验证
    public function testRecommendsList()
    {
        $arrayRecommendName=array("小学阶段","初中阶段","高中阶段");
        $this->postData['params'] = [
            'condition'=>'',
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $arrayResult=array_keys($result['result']['recommends']['0']['list']);
        $this->assertTrue(is_int($arrayResult[0]),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEmpty(array_diff($arrayRecommendName,array_column($result['result']['recommends'],'attrName')),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('3',$result['result']['recommends']['1']['list']['1']['type'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $arrayJunior=array_column($result['result']['recommends']['1']['list'],'total');
        $this->assertLessThanOrEqual($arrayJunior[0],$arrayJunior[1],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('39', $result['result']['recommends']['2']['list']['0']['courseId'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('1', $result['result']['recommends']['2']['list']['0']['courseType'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
   //推荐模块验证
    public function testRecommendsCheckTotal()
    {
        $this->postData['params'] = [
            'condition'=>'',
            'uid'=>''
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1',$result['result']['recommends']['0']['list']['0']['type'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertEquals('34',$result['result']['recommends']['0']['list']['0']['total'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }

    
    
    //参数正确，推荐课程最多八门课程
    public function testRecommendsMoreFour()
    {
        $this->postData['params'] = [
            'condition'=>'34,35,36',
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals(0, $result['code'],'url:'.$this->url.'   Post data:'.json_encode($this->postData));
        $this->assertLessThanOrEqual('8', count($result['result']['recommends'][1]['list']),'url:'.$this->url.'   Post data:'.json_encode($this->postData));
    }
   
}