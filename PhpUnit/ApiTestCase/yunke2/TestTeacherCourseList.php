<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestTeacherCourseList extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://dev.gn100.com/interface/teacher/teachercourse";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回数据节点是否正确
    public function testDataIsOK($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';//每页显示条数
        $postdata['params']['teacherId']='155';//教师ID
        $postdata['params']['uid']='3596';//用户ID 
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('test222', $result['result']['data'][0]['title']);
        $this->assertEquals('0', $result['result']['data'][0]['feeTyep']);
        
        
    }
    
    //teacherId为空，返回值
    public function testTeacherIdIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';//每页显示条数
        $postdata['params']['teacherId']='';//教师ID
        $postdata['params']['uid']='3596';//用户ID
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1000', $result['code']);//请求参数为空

    }
    //teacherId不存在，返回值
    public function testTeacherIdNotExist($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';//每页显示条数
        $postdata['params']['teacherId']='1111111111';//教师ID
        $postdata['params']['uid']='3596';//用户ID
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('3002', $result['code']);//获取数据失败

    }
    //page为空，返回值
    public function testPageIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='';
        $postdata['params']['length']='20';//每页显示条数
        $postdata['params']['teacherId']='155';//教师ID
        $postdata['params']['uid']='3596';//用户ID
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('1', $result['result']['page']);//为空，默认为1
    }
    //有录播课程为试看的，需有分类
    public function testCourseTrySee($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='';
        $postdata['params']['length']='20';//每页显示条数
        $postdata['params']['teacherId']='3596';//教师ID
        $postdata['params']['uid']='3596';//用户ID
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
       // var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //$this->assertEquals('0', $result['code']);
    }
    
    //课程列表展示的时间最新的排在最上
    public function testCourseTimeSort($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='';
        $postdata['params']['length']='20';//每页显示条数
        $postdata['params']['teacherId']='3596';//教师ID
        $postdata['params']['uid']='3596';//用户ID
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertLessThan($result['result']['data'][0]['startTime'], $result['result']['data'][1]['startTime']);
    }
    //多班情况，显示最早开班的课程
    public function testCourseMore($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='';
        $postdata['params']['length']='20';//每页显示条数
        $postdata['params']['teacherId']='3596';//教师ID
        $postdata['params']['uid']='3596';//用户ID
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        for($i=0 ;$i<=$result['result']['total'];$i++)
        {
            if($result['result']['data'][$i]['courseId']=='4096')
            {
                $this->assertEquals('3', $result['result']['data'][$i]['courseStatus']);
            }
        }
    }
    
}