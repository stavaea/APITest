<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestHome extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $oid;
    
    
    protected function setUp()
    {
        //小沃1.5首页
        $this->url = "http://test.gn100.com/interface/orgfront/home";
        $this->http = new HttpClass();
    
    }
    
   public function testDataIsOK($oid="227")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['uid']= "23339";
        $postdata['params']['condition']= "1,7,30";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //$this->assertEquals('http://devf.gn100.com/3,73e4d544900d', $result['result']['banners'][0]['imgurl']);
        //$this->assertEquals('http://devf.gn100.com/7,73e8592d12c3', $result['result']['specials'][0]['specialImg']);
        //$this->assertEquals('学前', $result['result']['types'][0]['name']);
        
        for($i=0;$i<count($result['result']['lives']);$i++)
        {
            $num = $num+count($result['result']['lives'][$i]['list']);
        }//从当前时间往后未来的未开课的、正在上课、可回看的6节课
        
        $this->assertEquals('6', $num);
        $this->assertArrayHasKey('stime', $result['result']['lives'][0]['list'][0]);
        $this->assertArrayHasKey('isSign', $result['result']['lives'][0]['list'][0]);
        $this->assertArrayHasKey('sectionName', $result['result']['lives'][0]['list'][0]);
        $this->assertArrayHasKey('trySee', $result['result']['lives'][0]['list'][0]);
        $this->assertArrayHasKey('courseName', $result['result']['lives'][0]['list'][0]);
        $this->assertArrayHasKey('imgurl', $result['result']['lives'][0]['list'][0]);
        $this->assertArrayHasKey('recommends', $result['result']);
        $this->assertArrayHasKey('selectCourses', $result['result']);
        if($result['result']['teachers']!=null)
        {
            $this->assertArrayHasKey('teacherName', $result['result']['teachers'][0]);
            $this->assertArrayHasKey('teahcerImg', $result['result']['teachers'][0]);
            $this->assertArrayHasKey('totalTime', $result['result']['teachers'][0]);
            $this->assertArrayHasKey('comment', $result['result']['teachers'][0]);
            $this->assertArrayHasKey('subject_name', $result['result']['teachers'][0]);
            $this->assertArrayHasKey('province', $result['result']['teachers'][0]);
        }
        if($result['result']['recommends']!=null)
        {
            $this->assertArrayHasKey('courseName', $result['result']['recommends'][0]['list']['0']);
            $this->assertArrayHasKey('imgUrl', $result['result']['recommends'][0]['list']['0']);
            $this->assertArrayHasKey('userTotal', $result['result']['recommends'][0]['list']['0']);
            $this->assertArrayHasKey('isMember', $result['result']['recommends'][0]['list']['0']);
            $this->assertArrayHasKey('courseType', $result['result']['recommends'][0]['list']['0']);
            $this->assertArrayHasKey('planTime', $result['result']['recommends'][0]['list']['0']);
            $this->assertArrayHasKey('planName', $result['result']['recommends'][0]['list']['0']);
            $this->assertArrayHasKey('status', $result['result']['recommends'][0]['list']['0']);
            
        }
        
    }


    //返回自动推荐课程中最多显示8条数据
    public function testHomeCourseList($oid='227')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['uid']= "23339";
        $postdata['params']['condition']= "1,7,30";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertLessThanOrEqual('8', count($result['result']['recommends'][2]['list']));
        $this->assertLessThanOrEqual('8', count($result['result']['recommends'][1]['list']));
    }
    
    
    //分销课程显示 分销模板返回课程不为空
    public function testHomeResellCourse($oid='227')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['uid']= "23339";
        $postdata['params']['condition']= "1,7,30";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $templateName=array_column($result['result']['recommends'],'name');
        foreach($templateName as $key =>$value)
        {
            if ($value=="分销课")
                $this->assertNotEquals(0,count($result['result']['recommends'][$key]['list']),"Fail! resell course should be hided".' Post data:'.json_encode($postdata));
        }
        
    }
}