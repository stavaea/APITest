<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../func/seek.php';

class TestTeacherSearch extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    private $seek;
    
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
            $postdata['params']['condition']='0,0,0';//新云课不需要此字段，但由于新老接口公用一个所以不去掉
            $postdata['params']['sort']='0';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
            $result2=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //课程总时长
            $this->assertArrayHasKey("courseTotalTime", $result2['result']['data']['teacher'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            //报名总人数
            $this->assertArrayHasKey("userTotal", $result2['result']['data']['teacher'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            //评分
            $this->assertArrayHasKey("score", $result2['result']['data']['teacher'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            //机构名称
            $this->assertArrayHasKey("orgName", $result2['result']['data']['teacher'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            
        }
        
        
        //参数正确，学前老师数据
        public function testPreschoolTeacher($oid='0')
        {
            $q=array("teacher_status"=>1,"visiable"=>1,"subject_id"=>"2","course_count"=>'1,5000');
            $ob =array("student_count"=>"desc");
            $f=array("teacher_id","name","real_name","thumb_big","subject_id","org_teacher","totaltime","student_count","avg_score","grade","subject","course_count","comment");
            $p=1;
            $pl=1;
            $this->seek = new seek();
            $seekData=$this->seek->TeacherSeek($f, $q, $ob, $p, $pl);
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']=1;
            $postdata['params']['condition']='0,2';
            $postdata['params']['sort']='2000'; //按学生排序
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true); 
            $this->assertEquals($seekData['data'][0]['teacher_id'], $result['result']['data']['teacher'][0]['teacherId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals($seekData['data'][0]['org_teacher'][0]['subname'], $result['result']['data']['teacher'][0]['orgName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals($seekData['data'][0]['real_name'], $result['result']['data']['teacher'][0]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertContains($seekData['data'][0]['thumb_big'], $result['result']['data']['teacher'][0]['thumbMed'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals(round($seekData['data'][0]['avg_score'],1), $result['result']['data']['teacher'][0]['score'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals($seekData['data'][0]['comment'], $result['result']['data']['teacher'][0]['comment'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals($seekData['data'][0]['course_count'], $result['result']['data']['teacher'][0]['courseCount'],'url:'.$this->url.'   Post data:'.json_encode($postdata));  
        }
        
        
        //参数正确，学前科目
        public function testPreschoolSubject($oid='0')
        {
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']=1;
            $postdata['params']['condition']='4000,0';
            $postdata['params']['sort']='0';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //length为空，默认长度为20
            $this->assertContains('全部', array_column($result['result']['data']['attr'],'name'),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
        
        
        //参数正确，返回分类
        public function testCate($oid='0')
        {
            $postdata['time']=strtotime(date('Y-m-d H:i:s'));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']=$oid;
            $postdata['params']['page']=1;
            $postdata['params']['length']='';
            $postdata['params']['condition']='4000,0';
            $postdata['params']['sort']='0';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //length为空，默认长度为20
            $this->assertEquals('0', $result['result']['data']['cate'][0]['id'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('全部', $result['result']['data']['cate'][0]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('4000', $result['result']['data']['cate'][1]['id'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('学前', $result['result']['data']['cate'][1]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('1000', $result['result']['data']['cate'][2]['id'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('小学', $result['result']['data']['cate'][2]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('2000', $result['result']['data']['cate'][3]['id'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('初中', $result['result']['data']['cate'][3]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('3000', $result['result']['data']['cate'][4]['id'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
            $this->assertEquals('高中', $result['result']['data']['cate'][4]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
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
            $postdata['params']['condition']='0,0,0';
            $postdata['params']['sort']='0';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //length为空，默认长度为20
            $this->assertEquals('20', $result['result']['teacherCount'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
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
            $postdata['params']['condition']='0,0,0';          
            $postdata['params']['sort']='1000';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
            $this->assertGreaterThanOrEqual($result['result']['data']['teacher'][0]['score'], $result['result']['data']['teacher'][1]['score'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
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
            $postdata['params']['condition']='0,0,0';
            $postdata['params']['sort']='2000';
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            $this->assertGreaterThanOrEqual($result['result']['data']['teacher'][1]['userTotal'], $result['result']['data']['teacher'][0]['userTotal'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
        
    
}