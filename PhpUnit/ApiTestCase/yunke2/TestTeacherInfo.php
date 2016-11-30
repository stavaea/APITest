<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestTeacherInfo extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    public  $GetToken;
    
    protected function  setUp()
    {
       // $this->url = "http://dev.gn100.com/interface/teacher/detail";
        $this->url = "http://test.gn100.com/interface/teacher/detail";
        $this->http = new HttpClass();
        $this->GetToken =new TestUserToken();
    }
    
    public function testTeacherInfoIsOk($uid=0,$teacherId='23402')
    {   
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['teacherId']=$teacherId;
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        
    }
    
    //参数正确，返回数据节点是否正确
    /*
    public function testDataIsOK($oid='469',$uid='3596')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid; 
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['teacherId']='3596'; 
        $token=$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result['code']);
        $this->assertEquals('0', $result['code']);
        //老师id
        $this->assertEquals('3596', $result['result']['info']['teacherId']);
        //老师教龄
        $this->assertEquals('1', $result['result']['info']['years']);
        //课程数
        $this->assertArrayHasKey('courseCount', $result['result']['info']);
        //学生总数
        $this->assertArrayHasKey('userTotal', $result['result']['info']);
        //课程信息
        $this->assertArrayHasKey('plan', $result['result']);
        $this->assertArrayHasKey('course', $result['result']);
//         var_dump(json_encode($result['result']['plan']));
//         var_dump(json_encode($result['result']['course']['list'][0]));
    }
    */
    
    //必传参数为空，返回值
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
    
    //
}