<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestCoursefilter extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $oid;
    
    
    protected function setUp()
    {
        //小沃1.5课程筛选
        $this->url = "http://dev.gn100.com/interface.search.coursefilter";
        $this->http = new HttpClass();
    
    }
    
    public function testDataIsOK($oid='1')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']= "1";
        $postdata['params']['length']= "20";
        $postdata['params']['type']= "2";//录播
        $postdata['params']['sort']= "2000,4000";
        $postdata['params']['condition']= "9,41,";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        if($result['result']['data']['course']!=null)
        {
            for($i=0;$i<count($result['result']['data']['course']);$i++)
            {
                $this->assertEquals('2', $result['result']['data']['course'][$i]['courseType']);
            }
        }
    }
}