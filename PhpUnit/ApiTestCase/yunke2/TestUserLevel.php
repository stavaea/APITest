<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestUserLevel extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://dev.gn100.com/interface/user/UserLevel";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['uid']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);

    
    }
}