<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestTeacherSearch extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function  setUp()
    {
        $this->url = "http://test.gn100.com/interface/search/teacher";
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
            $postdata['params']['keywords']='';
            $postdata['params']['condition']='0,0,0';//新云课不需要此字段，但由于新老接口公用一个所以不去掉
            $postdata['params']['sort']='0';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
            $result2=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //课程总时长
            $this->assertArrayHasKey("courseTotalTime", $result2['result']['data']['teacher'][0]);
            //报名总人数
            $this->assertArrayHasKey("userTotal", $result2['result']['data']['teacher'][0]);
            //评分
            $this->assertArrayHasKey("score", $result2['result']['data']['teacher'][0]);
            //机构名称
            $this->assertArrayHasKey("orgName", $result2['result']['data']['teacher'][0]);
            
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
            $postdata['params']['condition']='0,0,0';
        
            $postdata['params']['sort']='0';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //length为空，默认长度为20
            $this->assertEquals('20', $result['result']['teacherCount']);
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
            $postdata['params']['condition']='0,0,0';      
            $postdata['params']['sort']='0';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
            //var_dump($result['result']['data']['teacher'][0]['teacherId']);
            $this->assertEquals('183', $result['result']['data']['teacher'][0]['teacherId']);
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
            $postdata['params']['condition']='0,0,0';
            $postdata['params']['sort']='0';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
            var_dump($result['result']['data']['teacher'][0]['teacherId']);
            $this->assertEquals('23317', $result['result']['data']['teacher'][0]['teacherId']);
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
            $postdata['params']['condition']='0,0,0';
            $postdata['params']['sort']='0';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
            $this->assertEquals('0', count($result['result']['data']['teacher']));
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
            //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
            $this->assertGreaterThanOrEqual($result['result']['data']['teacher'][0]['score'], $result['result']['data']['teacher'][1]['score']);
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
            //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
            var_dump($result['result']['data']['teacher'][0]['userTotal']);
            var_dump($result['result']['data']['teacher'][1]['userTotal']);
            $this->assertGreaterThanOrEqual($result['result']['data']['teacher'][1]['userTotal'], $result['result']['data']['teacher'][0]['userTotal']);
        }
    
}