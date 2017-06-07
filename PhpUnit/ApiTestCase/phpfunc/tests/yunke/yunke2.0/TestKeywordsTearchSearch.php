<?php

class TestKeywordsTearchSearch extends PHPUnit_Framework_TestCase
{
protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface.search.teacherSearch";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
        //参数正确，返回数据节点是否正确
        public function testDataIsOK()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'keywords'=>'马静'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            //课程总时长
            $this->assertArrayHasKey("teacherId", $result['result']['data'][0]);
            //报名总人数
            $this->assertArrayHasKey("name", $result['result']['data'][0]);
            //评分
            $this->assertArrayHasKey("thumbMed", $result['result']['data'][0]);
            //机构名称
            $this->assertArrayHasKey("subjectName", $result['result']['data'][0]);
            
        }
        
        //参数正确，length为空
        public function testLengthIsNull()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'',
                'keywords'=>''
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            //length为空，默认长度为20
            $this->assertEquals('9', $result['result']['teacherCount']);
        }
        
        
        //keywords为中文的时候，返回值
        public function testKeywordsIsChinese()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'keywords'=>'杨明娟'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            $this->assertContains('1', array_column($result['result']['data'],'teacherId')); 
        }
        
        //keywords为英文的时候，返回值
        /* public function testKeywordsIsEng()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'keywords'=>'apiTest'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            var_dump(count($result['result']['data']));
            $this->assertContains('10', array_column($result['result']['data'],'teacherId'));
        }
         */
     
        //keywords不存在时，返回值
        public function testKeywordsIsNotExsit()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'keywords'=>'aaaaaaaaaaaaaaa'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            $this->assertEquals('3002', $result['code']);
        }
        
      
        //按评分排序 sort：1000
        public function  testScoreSort()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'keywords'=>'',
                'condition'=>'0,0,0',
                'sort'=>'1000'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            $this->assertGreaterThanOrEqual($result['result']['data'][0]['score'], $result['result']['data'][1]['score']);
        }
        
        
       //按学生排序 sort：2000
        public function  testUserTotalSort($oid='0')
        {
           $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'keywords'=>'',
                'condition'=>'0,0,0',
                'sort'=>'2000'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            $this->assertGreaterThanOrEqual($result['result']['data'][1]['userTotal'], $result['result']['data'][0]['userTotal']);
        }
 
}