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
       $this->url="http://test.gn100.com/interface/plan/liveTable";
       $this->http=new HttpClass();
    }
    /*
    public function testliveTableVerifySevenDayCourse()
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
    
    public function testLiveTableOidIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']='116';
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']="5312";
        $key = interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump(json_encode($postdata));
      // $fdresult = $this->http->HttpPost($this->url, json_encode($postdata));
        //var_dump($result);
    }

}

