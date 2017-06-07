<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestVipMember extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    public $Token;
    static  $u="i";
    static  $v="2";
    
    protected function setUp()
    {
        //小沃会员中心
        $this->url="http://dev.gn100.com/interface/member";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
    }
    
    public function testDataIsOK($oid='842')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $token =$this->Token->testUserTokenGenIsSuccess('3596');
        $postdata['token']=$token;
        $postdata['params']['userId']= "3596";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertArrayHasKey('userInfo', $result['result']);
        if($result['result']['userInfo']!=NULL)
        {
            $this->assertArrayHasKey('memberName', $result['result']['userInfo'][0]);
            $this->assertArrayHasKey('endTime', $result['result']['userInfo'][0]);
            $this->assertArrayHasKey('remainder', $result['result']['userInfo'][0]);   
        }
        $this->assertEquals('小沃高级会员', $result['result']['memberList'][0]['memberName']);
        $this->assertEquals('高级会员课程', $result['result']['memberList'][0]['descript']);
        $this->assertEquals('0.01元/30天', $result['result']['memberList'][0]['days'][0]['day']);
        $this->assertEquals('30', $result['result']['memberList'][0]['days'][0]['memberDay']);
    }
    //参数为空，返回值
    public function testParamsIsNull($oid='842')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $token =$this->Token->testUserTokenGenIsSuccess('3596');
        $postdata['token']=$token;
        $postdata['params']['userId']= "";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        var_dump($result);
        $this->assertEquals('1000', $result['code']);//请求参数为空
    }
}