<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestCustomNav extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v=2;
    protected function setUp()
    {
        $this->url='http://test.gn100.com/interface.org.CustomNav';
        $this->http =new HttpClass();
    }

    public function testCustomNavIsOk($oid=227)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['status']="0";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
    }
  
}

