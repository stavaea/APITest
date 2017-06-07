<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestStudentMyTable extends PHPUnit_Framework_TestCase
{

    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
       $this->url="http://test.gn100.com/interface/student/myTable";
       $this->http=new HttpClass();
    }
    /*
    public function testStudentMyTableVerifySevenDayCourse()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']='214';
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']="";
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result = $this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
    */
    
    public function testStudentMyTableOidIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']='116';
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['startTime']="2016-10-01 00:00:00";
        $postdata['params']['endTime']="2016-10-29 23:59:59";
        $postdata['params']['userId']="22411";
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
       // var_dump(json_encode($postdata));
       $result = $this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }

}

