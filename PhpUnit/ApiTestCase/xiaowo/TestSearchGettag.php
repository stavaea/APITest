<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';
/**
 * test case.
 */
class TestSearchGettag extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    static  $u="i";
    static  $v="2";
    
    protected function setUp()
    {
        $this->url="test.gn100.com/interface.search.getAllCate";
       // $this->url="dev.gn100.com/interface.search.Gettag";
        $this->http = new HttpClass();
    }
   /* 
    public function testSearchGetTagHttpCode($oid=116)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $this->assertEquals("200", $this->http->HttpPostCode($this->url, json_encode($postdata)));
    }
    
    public function testSearchGetTagParamsError($oid=116)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['paramsE']="23，234";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1002", $result['code']);
    }
    
    public function testSearchGetTagOidNotExist($oid=110036)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
       $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002", $result['code'],"errorcode wrong!");
    }
    
    public function testSearchGetTagNoOid($oid="216")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result= $this->assertEquals("200", $this->http->HttpPostCode($this->url, json_encode($postdata)));
        $this->assertEquals("6", $result['result']['data'][0]['id']);
        $this->assertEquals("2", $result['result']['data'][1]['id']);
        $this->assertEquals("27", $result['result']['data'][0]['data'][0]['id']);
    }
    */
    
    public function testAllCateVerifyOneCateOid($oid="214")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
        
        //$this->assertEquals("6", $result['result']['data'][0]['id']);
        //$this->assertEquals("2", $result['result']['data'][1]['id']);
        //$this->assertEquals("27", $result['result']['data'][0]['data'][0]['id']);
    }
    
    public function testAllCateVerifyThreeCateOid($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //$this->assertEquals("6", $result['result']['data'][0]['id']);
        //$this->assertEquals("2", $result['result']['data'][1]['id']);
        //$this->assertEquals("27", $result['result']['data'][0]['data'][0]['id']);
    }
    
    public function testAllCateVerifyNoCourseOid($oid="226")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        $this->assertEmpty($result['result']);
    }
    
}

