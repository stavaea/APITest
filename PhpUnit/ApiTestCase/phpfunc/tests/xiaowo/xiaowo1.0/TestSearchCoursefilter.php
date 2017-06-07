<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

/**
 * test case.
 */
class TestSearchCoursefilter extends PHPUnit_Framework_TestCase
{

    protected $url;
    public  $http;
    static  $u="i";
    static  $v="2";
    
    protected function setUp()
    {
        $this->url="dev.gn100.com/interface.search.coursefilter";
        $this->http = new HttpClass();
    }
    /*
    public function testSearchCourseFilterIsSuccess($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="3";
        $postdata['params']['condition']="6,27,0";
        $postdata['params']['sort']="1000,4000";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
        
        //$this->assertEquals("6", $result['result']['data'][0]['id']);
        //$this->assertEquals("2", $result['result']['data'][1]['id']);
        //$this->assertEquals("27", $result['result']['data'][0]['data'][0]['id']);
    }
    
    
   
   
    public function testSearchCourseFilterIsSuccess($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['condition']="6,27,3";
        $postdata['params']['sort']="0,3000";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //$this->assertEquals("6", $result['result']['data'][0]['id']);
        //$this->assertEquals("2", $result['result']['data'][1]['id']);
        //$this->assertEquals("27", $result['result']['data'][0]['data'][0]['id']);
    }
    public function testSearchCourseFilterIsSuccess($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['condition']="6,27,3";
        $postdata['params']['sort']="2000,3000";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //$this->assertEquals("6", $result['result']['data'][0]['id']);
        //$this->assertEquals("2", $result['result']['data'][1]['id']);
        //$this->assertEquals("27", $result['result']['data'][0]['data'][0]['id']);
    }
        public function testSearchCourseFilterIsSuccess($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['condition']="6,27,5";
        $postdata['params']['sort']="1000,4000";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //$this->assertEquals("6", $result['result']['data'][0]['id']);
        //$this->assertEquals("2", $result['result']['data'][1]['id']);
        //$this->assertEquals("27", $result['result']['data'][0]['data'][0]['id']);
    }
    
     public function testSearchCourseFilterVerifyPage($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="2";
        $postdata['params']['length']="20";
        $postdata['params']['condition']="6,27,5";
        $postdata['params']['sort']="1000,4000";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //$this->assertEquals("6", $result['result']['data'][0]['id']);
        //$this->assertEquals("2", $result['result']['data'][1]['id']);
        //$this->assertEquals("27", $result['result']['data'][0]['data'][0]['id']);
    }
     */
    
    public function testSearchCourseFilterParamsError($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['condition']="6,27,0";
        $postdata['params']['sort']="1000,3000";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //$this->assertEquals("6", $result['result']['data'][0]['id']);
        //$this->assertEquals("2", $result['result']['data'][1]['id']);
        //$this->assertEquals("27", $result['result']['data'][0]['data'][0]['id']);
    }

}

