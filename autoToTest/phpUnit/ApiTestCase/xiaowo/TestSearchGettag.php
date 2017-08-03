<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
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
        $this->http = new HttpClass();
    }

    //传参正确，返回数据节点是否正确
    public function testSearchGetTagHttpCode($oid=116)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $this->assertEquals("200", $this->http->HttpPostCode($this->url, json_encode($postdata)),'url:'.$this->url.'   Post data:'.json_encode($postdata));  
    }
    
  
    //错误参数，返回,报Notice
    public function testSearchGetTagParamsError($oid=116)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['param']="";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1002", $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

    //机构id参数不存在，返回
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
        $this->assertEquals("1000", $result['code'],"errorcode wrong!");
    }
  

   //传参为空
    public function testSearchGetTagNoOid($oid="")
    {
      $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1000", $result['code'],"errorcode wrong!");
    }

    //一个一级分类字段校验
    public function testAllCateVerifyOneCateOid($oid="214")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1", count(array_column($result['result'],'id')),'url:'.$this->url.'   Post data:'.json_encode($postdata));
       $this->assertEquals("生活/兴趣", $result['result'][0]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals("24", $result['result'][0]['data'][0]['id'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals("兴趣运动", $result['result'][0]['data'][0]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals("170", $result['result'][0]['data'][0]['data'][0]['id'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals("瑜伽", $result['result'][0]['data'][0]['data'][0]['name'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //三个一级分类字段校验
    public function testAllCateVerifyThreeCateOid($oid="116")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3", count(array_column($result['result'],'id')),'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //机构无课程数据
    public function testAllCateVerifyNoCourseOid($oid="226")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
       $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEmpty($result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

}

