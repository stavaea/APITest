<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestKeywordsTearchSearch extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function  setUp()
    {
        $this->url = "http://test.gn100.com/interface.search.teacherSearch";
        $this->http = new HttpClass();
    }    
        
        //参数正确，返回数据节点是否正确
        public function testDataIsOK($oid='0')
        {
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']=20;
            $postdata['params']['keywords']='测试';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result2=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //课程总时长
            $this->assertArrayHasKey("teacherId", $result2['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            //报名总人数
            $this->assertArrayHasKey("name", $result2['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            //评分
            $this->assertArrayHasKey("thumbMed", $result2['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            //机构名称
            $this->assertArrayHasKey("subjectName", $result2['result']['data'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            
        }
        
        //参数正确，length为空
        public function testLengthIsNull($oid='0')
        {
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']='';
            $postdata['params']['keywords']='';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //length为空，默认长度为20
            $this->assertEquals('20', $result['result']['teacherCount'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
        
        
        //keywords为中文的时候，返回值
        public function testKeywordsIsChinese($oid='0')
        {
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']='20';
            $postdata['params']['keywords']='马静';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            $this->assertContains('183', array_column($result['result']['data'],'teacherId'),'url:'.$this->url.'   Post data:'.json_encode($postdata)); 
        }
        
        //keywords为英文的时候，返回值
        public function testKeywordsIsEng($oid='0')
        {
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']='20';
            $postdata['params']['keywords']='apitest';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            $this->assertContains('23317', array_column($result['result']['data'],'teacherId'),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
        
     
        //keywords不存在时，返回值
        public function testKeywordsIsNotExsit($oid='0')
        {
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']='20';
            $postdata['params']['keywords']='sdkjfskdfjaksdfja';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true); 
            $this->assertEquals('3002', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
        
      
        //按评分排序 sort：1000
        public function  testScoreSort($oid='0')
        {
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']='20';
            $postdata['params']['keywords']='';
            $postdata['params']['condition']='0,0,0';
            
            $postdata['params']['sort']='1000';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            $this->assertGreaterThanOrEqual($result['result']['data'][0]['score'], $result['result']['data'][1]['score'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
        
        
       //按学生排序 sort：2000
        public function  testUserTotalSort($oid='0')
        {
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']='20';
            $postdata['params']['keywords']='';
            $postdata['params']['condition']='0,0,0';
            $postdata['params']['sort']='2000';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            $this->assertGreaterThanOrEqual($result['result']['data'][1]['userTotal'], $result['result']['data'][0]['userTotal'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
 
}