<?php


class TestAnnoucement extends PHPUnit_Framework_TestCase
{
      protected function setUp()
       {
           
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
           ];
       }
    //添加公告
     
    public function testAddDataIsOK($fk_plan='741')
    {
        //添加公告
        $url = "http://test.gn100.com/interface/announcement/Announcement";
        $this->postData['params'] = [
            'status'=>'1',
            'fkPlan'=>$fk_plan,
            'content'=>'测试一下公告哦'
        ];
        $result = interfaceFunc::getPostData($url, $this->postData);
        $this->assertEquals('0',$result['code']);
        
        return $fk_plan;
    }
    
    //查询公告
    public function testAnnouceList($fk_plan='741')
    {
        $url="http://test.gn100.com/interface/announcement/GetAnnouncement";
        $this->postData['params'] = [
            'fkPlan'=>$fk_plan
        ];
        $result = interfaceFunc::getPostData($url, $this->postData);
        $this->assertEquals('0',$result['code']);
        $this->assertEquals($fk_plan, $result['result']['fkPlan']);
        $this->assertEquals('测试一下公告哦', $result['result']['content']);
        $this->assertEquals('1', $result['result']['status']);
        return $result['result'];
    }
    
    /**
     * @depends testAddDataIsOK
     * @depends testAnnouceList
     */
    public function testAddAfterCheckList($fk_plan, $AnnouceList)
    {
        $this->assertEquals($fk_plan, $AnnouceList['fkPlan']);
        $this->assertEquals('测试一下公告哦', $AnnouceList['content']);
        $this->assertEquals('1', $AnnouceList['status']);
    }
    
    
    /**
     * @depends testAddDataIsOK
     */
    public function testUpdateAnnouce($fk_plan)
    {
        $url = "http://test.gn100.com/interface/announcement/Announcement";
        $this->postData['params'] = [
            'status'=>'1',
            'fkPlan'=>$fk_plan,
            'content'=>'我更新了公告哦'
        ];
        $result = interfaceFunc::getPostData($url, $this->postData);
        return $fk_plan;
    }
    /**
     * @depends testAddDataIsOK
     */
    //查看公告
    public function testList($fk_plan)
    {
        $url="http://test.gn100.com/interface/announcement/GetAnnouncement";
        $this->postData['params'] = [
            'fkPlan'=>$fk_plan
        ];
        $result = interfaceFunc::getPostData($url, $this->postData);
        return $result['result'];
    }
    
    /**
     * @depends testUpdateAnnouce
     * @depends testList
     */
    public function testUpdateAfterCheckList($fk_plan, $AnnouceList)
    {
        $this->assertEquals($fk_plan, $AnnouceList['fkPlan']);
        $this->assertEquals('我更新了公告哦', $AnnouceList['content']);
        $this->assertEquals('1', $AnnouceList['status']);
    }
    
    /**
     * @depends testAddDataIsOK
     */
    //删除公告
    public function testDelAnnouce($fk_plan)
    {
        $url='http://test.gn100.com/interface/announcement/Announcement';
        $this->postData['params'] = [
            'fkPlan'=>$fk_plan,
            'status'=>'2'
        ];
        $result = interfaceFunc::getPostData($url, $this->postData);
        $this->assertEquals(0, $result['code']);
    }
    
    
    //status不存在，返回值
    
    public function testStatusIsNotExist($fk_plan='741')
    {
        $url = "http://test.gn100.com/interface/announcement/Announcement";
        $this->postData['params'] = [
            'status'=>'3',
            'fkPlan'=>$fk_plan,
            'content'=>'不存在的状态值'
        ];
        $result = interfaceFunc::getPostData($url, $this->postData);
        $this->assertEmpty($result);
    }
    
        //参数content为空，返回值
        public function testContentIsNull($fk_plan='741')
       {
           $url = "http://test.gn100.com/interface/announcement/Announcement";
           $this->postData['params'] = [
            'status'=>'1',
            'fkPlan'=>$fk_plan,
            'content'=>''
            ];
           $result = interfaceFunc::getPostData($url, $this->postData);
           $this->assertEquals('1001',$result['code']);//content为空
            
       }  
       
       
       
       //参数content大于100个汉字，返回值
       public function testContentChineseIsBig($fk_plan='741')
       {
           $url = "http://test.gn100.com/interface/announcement/Announcement";
           $this->postData['params'] = [
               'status'=>'1',
               'fkPlan'=>$fk_plan,
               'content'=>'一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五啊'
           ];
           $result = interfaceFunc::getPostData($url, $this->postData);
           $this->assertEquals('2051',$result['code']);//content大于100个汉字
       
       }
       
       
       //参数content大于200个字符，返回值
       public function testContentEnglishIsBig($fk_plan='3724')
       {
           $url = "http://test.gn100.com/interface/announcement/Announcement";
           $this->postData['params'] = [
               'status'=>'1',
               'fkPlan'=>$fk_plan,
               'content'=>'abcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdew'
           ];
           $result = interfaceFunc::getPostData($url, $this->postData);
           $this->assertEquals('2051',$result['code']);//content大于200个字符
           
       }
       
       
}