<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestSearchCourse  extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u ="i";
    static $v ="2";
    
    protected function setUp()
    {
        
        $this->url = "http://test.gn100.com/interface/search/courseSearch";
        $this->http = new HttpClass();
       
    }
    /*
      public function testDataIsOK($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='1';
        $postdata['params']['condition']='';
        $postdata['params']['keywords']='录播课测试';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(0, $result['code']);
        $this->assertEquals("486",$result['result']['data'][0]['courseId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));    
        $this->assertNotEmpty($result['result']['data'][0]['teachers'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//是否有老师   
    }  
    

    //关键字为汉字(绝对搜索)
  public function testKeywordsIsChinese($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='2';
        $postdata['params']['condition']='';
        $postdata['params']['keywords']='泠嘻老师身份创建课';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("泠嘻老师身份创建课", $result['result']['data'][0]['title']);
        
    } 
    
    //关键字为英文(绝对搜索)
public function testKeywordsIsEnglish($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['condition']='';
        $postdata['params']['keywords']='lubo';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("lubo", $result['result']['data'][0]['title']);
    } 
     
    //关键字包含符号(绝对搜索)-*是一个特殊字符，可以模糊查询
 public function testKeywordsIsSymbol($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['condition']='';
        $postdata['params']['keywords']='ceshizhi*';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("ceshizhibo", $result['result']['data'][0]['title']);
    } 
    
    //评分
 public function testScore($oid="116")
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
        $this->assertEquals("0", $result['result']['data'][1]['score']);
    }   
    
    //排序
 public function testSort($oid="214")
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
        $this->assertGreaterThanOrEqual($result['result']['data'][1]['userTotal'], $result['result']['data'][0]['userTotal']);
       // var_dump($result->result->data[0]->userTotal);两种方式，此种不用写true
    } 

    //type 1-直播  2-录播  3-线下
  public function testType($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';
        $postdata['params']['length']='2';
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['keywords']='';
        $postdata['params']['sort']='4';
        $postdata['params']['type']='2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("2", $result['result']['data'][0]['courseType']);
    }
    */ 
 
    //page和length修改
    public function testPageAndLength($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='2';
        $postdata['params']['length']='1';
        $postdata['params']['condition']='';
        $postdata['params']['keywords']='测试';
        $postdata['params']['sort']='1';
        $postdata['params']['type']='1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1", count($result['result']['data']));
        
    }  
    
    
    //缺少必填参数
     public function testParams($oid="214")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;//为空，3001，系统salt未设置
        $postdata['v']=self::$v;//为空，无影响
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';//默认为1
        $postdata['params']['length']='10';//默认为1
        $postdata['params']['condition']='6,27,3';
        $postdata['params']['sort']='';//默认观看多少排序
        $postdata['params']['type']='1';//为空，默认全部
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002",$result['code']);
    }  
   
    
    //课程status确认
     public function testVerifyStatus($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['page']='1';//默认为1
        $postdata['params']['length']='10';//默认为1
        $postdata['params']['condition']='';
        $postdata['params']['keywords']='0112直播测试';//status为3
        $postdata['params']['sort']='';//默认观看多少排序
        $postdata['params']['type']='1';//为空，默认全部
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3", $result['result']['data'][0]['status']);
    } 
  
} 