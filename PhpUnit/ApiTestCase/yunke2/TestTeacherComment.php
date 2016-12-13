<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestTeacherComment extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    private $Token;
    static $u="i";
    static $v="2";
    
    protected function  setUp()
    {
        $this->url = "http://test.gn100.com/interface/teacher/commentv2";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
    }
    
    //参数正确，返回字段是否正确
    public function testDataIsOK($tid='35655')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['teacherId']=$tid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $token=$this->Token->testUserTokenGenIsSuccess($tid);
        $postdata['params']['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('2', $result['result']['total']);
        $this->assertEquals('1', $result['result']['totalPage']);
        $this->assertEquals('1', $result['result']['page']);
        $this->assertEquals('22410', $result['result']['data'][1]['userId']);
        $this->assertEquals("泠嘻", $result['result']['data'][1]['userName']);
        $this->assertEquals("http://testf.gn100.com/2,027984aae283", $result['result']['data'][1]['userImage']);
        $this->assertEquals("老师讲的很好", $result['result']['data'][1]['content']);
        $this->assertEquals('5', $result['result']['data'][1]['score']);
        $this->assertEquals("2016-12-13", $result['result']['data'][1]['time']);
        $this->assertEquals("老师评价测试课程-勿评价", $result['result']['data'][1]['course']);
        $this->assertEquals("1班", $result['result']['data'][1]['class']);
        $this->assertEquals("第1课时", $result['result']['data'][1]['section']);
    }
    
    //参数正确，评论为空
    public function testCommentIsEmpty($tid='22485')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['teacherId']=$tid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $token=$this->Token->testUserTokenGenIsSuccess($tid);
        $postdata['params']['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('3002', $result['code']);
    }
    
    //参数正确，翻页
    public function testCommentPage($tid='35655')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['teacherId']=$tid;
        $postdata['params']['page']='2';
        $postdata['params']['length']='1';
        $token=$this->Token->testUserTokenGenIsSuccess($tid);
        $postdata['params']['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('22410', $result['result']['data'][0]['userId']);
    }
    
    //必填参数为空，返回值
    public function testParamsIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['teacherId']='';
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1000', $result['code']);//请求参数为空
        
    
    }
    
    //参数不存在，返回值
    public function testParamsIsNotExist($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['teacherId']='aa';
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('3002', $result['code']);//获取数据失败
    }
    
    //时间顺序，倒叙排列
    public function testTimeSort($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['teacherId']='3596';
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        if($result['result']['total']>=2)
        {
            $this->assertGreaterThanOrEqual($result['result']['data'][1]['time'], $result['result']['data'][0]['time']);
        }
    }
}