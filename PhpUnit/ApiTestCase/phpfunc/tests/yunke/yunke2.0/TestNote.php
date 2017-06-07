<?php

class TestNote extends PHPUnit_Framework_TestCase
{  
    
    protected function setUp()
    {
        //笔记添加
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
        
    }
    
 //---------------------笔记增删改查功能---------------------------------------
       
       public function testAdd()
       {
           $url = "http://test.gn100.com/interface/note/NoteAdd";
           $this->postData['params'] = [
               'uId'=>'1',
               'planId'=>'741',
               'videoStatus'=>'2',
               'content'=>'1：55',
               'playTimeTmp'=>'123'
           ];
           $result = interfaceFunc::getPostData($url, $this->postData);
           $this->assertEquals('0',$result['code']);
           $this->assertArrayHasKey('noteId',$result['result']);
           $this->assertArrayHasKey('playTimeFormat',$result['result']);
           $this->assertArrayHasKey('playTimeTmpHandle',$result['result']);
           return $result['result']['noteId'];
       }   
       
       //查询笔记列表
       public function testListDataIsOK()
       {
           $url = "http://test.gn100.com/interface/note/NoteList";
           $this->postData['params'] = [
               'uId'=>'1',
               'planId'=>'741',
               'videoStatus'=>'2'
           ];
           $result = interfaceFunc::getPostData($url, $this->postData);
           $this->assertEquals('0', $result['code']);
           $this->assertArrayHasKey('courseId', $result['result']['items'][0]);
           $this->assertArrayHasKey('planId', $result['result']['items'][0]);
           $this->assertArrayHasKey('userId', $result['result']['items'][0]);
           $this->assertArrayHasKey('status', $result['result']['items'][0]);
           return $result['result'];
       }
       
       
       /**
        * @depends testAdd
        * @depends testListDataIsOK
        */
       public function testAddAfterCheckList($noteId, $noteList){
           $this->assertEquals($noteId, $noteList['items'][0]['id']);
           $this->assertEquals('1：55', $noteList['items'][0]['content']);
           $this->assertEquals('123', $noteList['items'][0]['playTimeTmp']);
           $this->assertEquals('00:02:03', $noteList['items'][0]['playTimeFormat']);
       }
       
       
       /**
        * @depends testAdd
        */
       //更新笔记
       public function testUpdate($noteId){
           $url = "http://test.gn100.com/interface/note/UpdateNote";
           $this->postData['params'] = [
               'planId'      => '741',
               'videoStatus' => '2',
               'noteId'      => $noteId,
               'content'     => '2:55',
               'uId'         => '1'
           ];
           $result = interfaceFunc::getPostData($url, $this->postData);
           
           $this->assertEquals(0, $result['code']);
           return $noteId;
       }
       
       public function testList()
       {
           $url = "http://test.gn100.com/interface/note/NoteList";
           $this->postData['params'] = [
               'uId'=>'1',
               'planId'=>'741',
               'videoStatus'=>'2'
           ];
           $result = interfaceFunc::getPostData($url, $this->postData);
           return $result['result'];
       }
       
       /**
        * @depends testUpdate
        * @depends testList
        * 
        */
       public function testUpdateAfterCheckList($noteId, $noteList){
           var_dump($noteId);
           var_dump($noteList);
           $this->assertEquals($noteId, $noteList['items'][0]['id']);
           $this->assertEquals('2:55', $noteList['items'][0]['content']);
           $this->assertEquals('123', $noteList['items'][0]['playTimeTmp']);
           $this->assertEquals('00:02:03', $noteList['items'][0]['playTimeFormat']);
       }
       
       /**
        * @depends testAdd
        */
       //删除笔记
       public function testDel($noteId){
           $url  = "http://test.gn100.com/interface/note/delNote";
           $this->postData['params'] = [
            'uId'=>'1',
            'planId'=>'741',
            'videoStatus'=>'2',
            'noteId'=>$noteId
        ];
           $result = interfaceFunc::getPostData($url, $this->postData);
           $this->assertEquals(0, $result['code']);
       }
       
       //参数content为空，返回值
        public function testContentIsNull()
       {
           $url = "http://test.gn100.com/interface/note/NoteAdd";
           $this->postData['params'] = [
               'uId'=>'1',
               'planId'=>'741',
               'videoStatus'=>'2',
               'content'=>'',
               'playTimeTmp'=>'150'
           ];
           $result = interfaceFunc::getPostData($url, $this->postData);
           $this->assertEquals('1001',$result['code']);//缺少参数
  
       } 
        
       
       //必填参数为空，返回值
        public function testAddParamsIsNull()
       {
           $url = "http://test.gn100.com/interface/note/NoteAdd";
           $this->postData['params'] = [
               'uId'=>'',
               'planId'=>'741',
               'videoStatus'=>'2',
               'content'=>'我们啊',
               'playTimeTmp'=>'140'
           ];
           $result = interfaceFunc::getPostData($url, $this->postData);  
           $this->assertEquals('1001',$result['code']);//缺少必传参数
           
       } 
    
    //content字数限制--汉字
      
    public function testContentChineseNum()
    {
        $url = "http://test.gn100.com/interface/note/NoteAdd";
        $this->postData['params'] = [
               'uId'=>'1',
               'planId'=>'741',
               'videoStatus'=>'2',
               'content'=>'一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一',
               'playTimeTmp'=>'140'
           ];
           $result = interfaceFunc::getPostData($url, $this->postData);  
           $this->assertEquals('2054',$result['code']);
    }
    
    
    //content字数限制--字符
     public function testContentEngNum()
    {
        $url = "http://test.gn100.com/interface/note/NoteAdd";
        $this->postData['params'] = [
               'uId'=>'1',
               'planId'=>'741',
               'videoStatus'=>'2',
               'content'=>'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
               'playTimeTmp'=>'140'
           ];
        $result = interfaceFunc::getPostData($url, $this->postData);  
        $this->assertEquals('2054',$result['code']);
    } 
    
    
}