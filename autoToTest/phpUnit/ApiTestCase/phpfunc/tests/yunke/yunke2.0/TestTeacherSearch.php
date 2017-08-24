<?php

class TestTeacherSearch extends PHPUnit_Framework_TestCase
{
protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/search/teacher";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }
        
        //参数正确，返回数据节点是否正确
        public function testDataIsOK($oid='0')
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'condition'=>'0,0,0',
                'sort'=>'0'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            //课程总时长
            $this->assertArrayHasKey("courseTotalTime", $result['result']['data']['teacher'][0]);
            //报名总人数
            $this->assertArrayHasKey("userTotal", $result['result']['data']['teacher'][0]);
            //评分
            $this->assertArrayHasKey("score", $result['result']['data']['teacher'][0]);
            //机构名称
            $this->assertArrayHasKey("orgName", $result['result']['data']['teacher'][0]);
            
        }
        
        
        //参数正确，学前老师数据
        public function testPreschoolTeacher()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'condition'=>'0,0,0',
                'sort'=>'2000'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            $this->assertEquals('2', $result['result']['data']['teacher'][0]['teacherId']);
            $this->assertEquals('高能100', $result['result']['data']['teacher'][0]['orgName']);
            $this->assertEquals('马静', $result['result']['data']['teacher'][0]['name']);
            $this->assertEquals('4.1', $result['result']['data']['teacher'][0]['score']);
            $this->assertEquals('9', $result['result']['data']['teacher'][0]['comment']);
            $this->assertEquals('20', $result['result']['data']['teacher'][0]['courseCount']);  
        }
        
        
        //参数正确，学前科目
        public function testPreschoolSubject()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'condition'=>'4000,0',
                'sort'=>'0'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            //length为空，默认长度为20
            $this->assertContains('全部', array_column($result['result']['data']['attr'],'name'));
        }
        
        
        //参数正确，返回分类
        public function testCate()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'',
                'condition'=>'4000,0',
                'sort'=>'0'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            //length为空，默认长度为20
            $this->assertEquals('0', $result['result']['data']['cate'][0]['id']);
            $this->assertEquals('全部', $result['result']['data']['cate'][0]['name']);
            $this->assertEquals('4000', $result['result']['data']['cate'][1]['id']);
            $this->assertEquals('学前', $result['result']['data']['cate'][1]['name']);
            $this->assertEquals('1000', $result['result']['data']['cate'][2]['id']);
            $this->assertEquals('小学', $result['result']['data']['cate'][2]['name']);
            $this->assertEquals('2000', $result['result']['data']['cate'][3]['id']);
            $this->assertEquals('初中', $result['result']['data']['cate'][3]['name']);
            $this->assertEquals('3000', $result['result']['data']['cate'][4]['id']);
            $this->assertEquals('高中', $result['result']['data']['cate'][4]['name']);
        }
        
        //参数正确，length为空
        public function testLengthIsNull()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'',
                'condition'=>'0,0,0',
                'sort'=>'0'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            //length为空，默认长度为20
            $this->assertEquals('9', $result['result']['teacherCount']);
        }
        
        //按评分排序 sort：1000
        public function  testScoreSort()
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'condition'=>'0,0,0',
                'sort'=>'1000'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            $this->assertGreaterThanOrEqual($result['result']['data']['teacher'][1]['score'], $result['result']['data']['teacher'][0]['score']);
        }
        
        
       //按学生排序 sort：2000
        public function  testUserTotalSort($oid='0')
        {
            $this->postData['params'] = [
                'page'=>'1',
                'length'=>'20',
                'condition'=>'0,0,0',
                'sort'=>'2000'
            ];
            $result = interfaceFunc::getPostData($this->url, $this->postData);
            $this->assertGreaterThanOrEqual($result['result']['data']['teacher'][1]['userTotal'], $result['result']['data']['teacher'][0]['userTotal']);
        }
        
    
}