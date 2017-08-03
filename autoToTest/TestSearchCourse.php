<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestSearchCourse  extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u ="i";
    static $v ="2";
    
    protected function setUp()
    {
        
        $this->url = "http://dev.gn100.com/interface/search/CourseSearch";
        $this->http = new HttpClass();
       
    }
    /*      public function testDataIsOK($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['keywords']='';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals(0, $result['code']);
        $this->assertEquals("3040",$result['result']['data'][0]['courseId']);    
        $this->assertNotEmpty($result['result']['data'][0]['teachers']);//是否有老师
        
    }  */
    //关键字为汉字(绝对搜索)
     /*   public function testKeywordsIsChinese($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['keywords']='我的第一节课';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals("我的第一节课", $result['result']['data'][0]['title']);
        
    } */
     
    //关键字为英文(绝对搜索)
   /*   public function testKeywordsIsEnglish($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['condition']='';
        $postdata['params']['keywords']='sssyq';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals("sssyq-删除测试", $result['result']['data'][0]['title']);
    } */
     
    //关键字包含符号(绝对搜索)-*是一个特殊字符，可以模糊查询
    /*  public function testKeywordsIsSymbol($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['condition']='';
        $postdata['params']['keywords']='ss*';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals("sssyq-删除测试", $result['result']['data'][0]['title']);
    }  */
    
    //评分
    /* public function testScore($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['keywords']='';
        $postdata['params']['sort']='5';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals("0", $result['result']['data'][1]['score']);
    }   */
    
    //排序
    /*  public function testSort($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['keywords']='';
        $postdata['params']['sort']='4';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        var_dump($result['result']['data'][0]['userTotal']);
        var_dump($result['result']['data'][1]['userTotal']);
        $this->assertGreaterThanOrEqual($result['result']['data'][1]['userTotal'], $result['result']['data'][0]['userTotal']);
       // var_dump($result->result->data[0]->userTotal);两种方式，此种不用写true
    } 
    */
    
    
    //type 1-直播  2-录播  3-线下
    /*  public function testType1($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['keywords']='';
        $postdata['params']['sort']='4';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals("2", $result['result']['data'][0]['courseType']);
    } 
     */
    
    
    
    //page和length修改
    /*    public function testPageAndLength($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='2';
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['keywords']='';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals("5", $result['result']['pageTotal']);
        
    }  */
    
    
    //缺少必填参数
       /*  public function testParams($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;//为空，3001，系统salt未设置
        $postdata['v']=self::$v;//为空，无影响
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';//默认为1
        $postdata['params']['length']='10';//默认为1
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['keywords']='';
        $postdata['params']['sort']='';//默认观看多少排序
        $postdata['params']['type']='1';//为空，默认全部
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals("3040",$result['result']['data'][0]['courseId']);
    }   */
   
    
    //课程status确认
     public function testVerifyStatus($oid="469")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';//默认为1
        $postdata['params']['length']='10';//默认为1
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['keywords']='0512直播免费';//status为3
        $postdata['params']['sort']='';//默认观看多少排序
        $postdata['params']['type']='1';//为空，默认全部
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals("3", $result['result']['data'][0]['status']);
    } 
} 