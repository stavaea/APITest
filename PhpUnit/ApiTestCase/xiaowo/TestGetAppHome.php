<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';
/**
 * test case.
 */
class TestGetAppHome extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    static  $u="i";
    static  $v="2";
    
    protected function setUp()
    {
        $this->url="test.gn100.com/interface/org/getapphome";
       // $this->url="dev.gn100.com/interface/org/getapphome";
        $this->http = new HttpClass();
    }
    

    //接口返回数据节点正确
    public function testGetAppHomeHttpCode($oid=1)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['secondId']="34,35,36";
        $postdata['params']['thirdId']="121,321,34";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
       $this->assertEquals("200", $this->http->HttpPostCode($this->url, json_encode($postdata)),'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
  
     
    //接口返回数据节点。
    public function testGetAppHomeGetNodeRight($oid=214)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="169";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url,json_encode($postdata)),true);
        $this->assertEquals(0, $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('ad',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('secondIds',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('thirdIds',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('special',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('recommends',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
   

 //正确返回ad轮播图模块数据，imgurl,url,title
    public function testGetAppHomeVerifyBannerDataSmallImg($oid=214)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="121,321,34";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $postdata['dinfo']['rw']="414.000000";
        $postdata['dinfo']['o']="2";
        $postdata['dinfo']['imsi']="";
        $postdata['dinfo']['p']="iphone";
        $postdata['dinfo']['m']="Xiaomi";
        $postdata['dinfo']['mac']="02:00:00:00:00:00";
        $postdata['dinfo']['p']="MI PAD";
        $postdata['dinfo']['os']="a";
        $postdata['dinfo']['osv']="9.3.2";
        $postdata['dinfo']['osvc']="17";
        $postdata['dinfo']['phone']="";
        $postdata['dinfo']['cvc']='14';
        $postdata['dinfo']['jb']="0";
        $postdata['dinfo']['os']="i";
        $postdata['dinfo']['d']="";
        $postdata['dinfo']['ip']="192.168.2.109";
        $postdata['dinfo']['imei']="";
        $postdata['dinfo']['rh']="736.000000";
        $postdata['dinfo']['m']="iPhone8,2";
        $postdata['dinfo']['cv']="0";
        $postdata['dinfo']['n']="5";
        $postdata['dinfo']['udid']="125FBA13-2ED7-492B-9E30-A0DB1297E97F";
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('http://testf.gn100.com/6,493f195946dc',$result['result']['ad'][0]['imgurl']);
        $this->assertEquals('https://jira.gn100.com/browse/WEB-6446',$result['result']['ad'][0]['url']);
        $this->assertEquals('',$result['result']['ad'][0]['name']);
    }
    
    //正确返回ad\special大图（ipad尺寸）
     public function testGetAppHomeVerifyBanneBigImg($oid=214)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="121,321,34";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $postdata['dinfo']['cv']="0.9.0";
        $postdata['dinfo']['udid']="";
        $postdata['dinfo']['d']="mocha";
        $postdata['dinfo']['ip']="192.168.2.137";
        $postdata['dinfo']['m']="Xiaomi";
        $postdata['dinfo']['mac']="0c:1d:af:58:a6:fc";
        $postdata['dinfo']['p']="MI PAD";
        $postdata['dinfo']['os']="a";
        $postdata['dinfo']['osv']="4.4.4";
        $postdata['dinfo']['osvc']=19;
        $postdata['dinfo']['o']=-1;
        $postdata['dinfo']['n']=1;
        $postdata['dinfo']['rh']=2048;
        $postdata['dinfo']['rw']=1536;
        $postdata['dinfo']['jb']=0;
        $postdata['dinfo']['cvc']=1;
        $postdata['dinfo']['uid']=23353;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('http://testf.gn100.com/3,494041b1a5c8',$result['result']['ad'][0]['imgurl']);
        $this->assertEquals('https://jira.gn100.com/browse/WEB-6446',$result['result']['ad'][0]['url']);
        $this->assertEquals('http://testf.gn100.com/4,4a5885f7f4a1', $result['result']['special'][0]['specialImg']);
    }

    //无banner，返回ad为空
    public function testGetAppHomeVerifyBannerIsNull($oid=216)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="121,321,34";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0',count($result['result']['ad']));
    }
    
    //机构设置二级分类，正确返回机构多个二级分类字段验证，name\id\
     public function testGetAppHomeVerifySecondIdsData($oid=214)
     {
     $postdata['time']=strtotime(date('Y-m-d H:i:s'));
     $postdata['oid']=$oid;
     $postdata['u']=self::$u;
     $postdata['v']=self::$v;
     $postdata['params']['thirdId']="34";
     $key=interface_func::GetAppKey($postdata);
     $postdata['key']=$key;
     $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
     $this->assertEquals("兴趣运动", $result['result']['secondIds'][0]['name']);
     $this->assertEquals("生活百科", $result['result']['secondIds'][1]['name']);
     }
     
      
     //机构未设置二级分类，三级分类传值包含二级分类，secondIds节点返回空
     public function testGetAppHomeVerifySecondIdsIsEmpty($oid=216)
     {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
         $postdata['oid']=$oid;
         $postdata['u']=self::$u;
         $postdata['v']=self::$v;
         $postdata['params']['thirdId']="169,6";
         $key=interface_func::GetAppKey($postdata);
         $postdata['key']=$key;
         $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
         $this->assertEmpty($result['result']['secondIds']);
     }
   
     //正确返回机构多个三级分类字段，课程字段验证
     public function testGetAppHomeVerifyThirdIdsData($oid=214)
     {
     static $testResult;
     $postdata['time']=strtotime(date('Y-m-d H:i:s'));
     $postdata['oid']=$oid;
     $postdata['u']=self::$u;
     $postdata['v']=self::$v;
     $postdata['params']['thirdId']="170";
     $key=interface_func::GetAppKey($postdata);
     $postdata['key']=$key;
     $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
     $this->assertEquals('瑜伽', $result['result']['thirdIds'][0]['name']);
     $this->assertEquals('170', $result['result']['thirdIds'][0]['id']);
     $this->assertEquals('24', $result['result']['thirdIds'][0]['pId']);
     if (empty($result['result']['thirdIds'][0]['list']))
         $this->assertFalse('true',"Fail, list is empty!");
     else
     { 
         foreach ($result['result']['thirdIds'][0]['list'] as $key => $Value)
        {
                  if($Value['courseId']==686)
                  { 
                      $testResult=1;
                      $this->assertEquals('686', $Value['courseId']);
                      $this->assertEquals('勿动-黄金会员课程2', $Value['courseName']);
                      $this->assertEquals('http://testf.gn100.com/5,439078e1bc02', $Value['imgurl']);
                      $this->assertEquals('1', $Value['userTotal']);
                  }          
            
          }
          if ($testResult!=1)
              $this->assertFalse('true','course 686 should be in result!');
     }
          
     }
 
 
     //special为数组类型，  正确返回机构专题字段验证
     public function testGetAppHomeVerifySpecialData($oid=214)
     {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
         $postdata['oid']=$oid;
         $postdata['u']=self::$u;
         $postdata['v']=self::$v;
         $postdata['params']['thirdId']="27";
         $key=interface_func::GetAppKey($postdata);
         $postdata['key']=$key;
         $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
         $specialKeys=array_keys($result['result']['special']);
         $this->assertTrue(is_int($specialKeys[0]));
         $this->assertEquals('http://testf.gn100.com/5,494853240e81', $result['result']['special'][0]['specialImg']);
         $this->assertEquals('https://www.yunke.com/', $result['result']['special'][0]['specialUrl']);
     }
     
   
   //无专题模块，数据返回
        public function testGetAppHomeVerifySpecialIsNull($oid=216)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="121,321,34";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0',count($result['result']['special']));
    }

   
    //三级分类为空，机构用户选择兴趣无数据，三级分类节点返回空
    public function testGetAppHomeNoThirdIds($oid=214)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0',count($result['result']['thirdIds']));
    }
     
    //传参错误，参数错误返回3002
    public function testGetAppHomeParamsError($oid=116)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdIds']="";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("0",$result['code']);
    }

 //传参oid不存在，正常返回
    public function testGetAppHomeOidNotExist($oid=842000)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="27";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEmpty($result['result']['thirdIds']['0']['list'],"Fail! thirdIds has course info!");
    }    
   

    // 自动推荐模块数据验证
    public function testGetAppHomeVerifyRecommendData($oid=214)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="27,30,42";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $templateName=array_column($result['result']['recommends'],'name');
        foreach($templateName as $key =>$value)
        {
            if ($value=="自动推荐")
                $this->assertNotEquals(0,count($result['result']['recommends'][$key]['list']),"Fail! no course info returned in search template".' Post data:'.json_encode($postdata));  
        }
       }
            
    //thirdids 返回课程每个分类最多返回4条
        public function testGetAppHomeThirdIdsList($oid=214)
    {
         $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="176";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(4,count($result['result']['thirdIds']['0']['list']),json_encode($postdata));
    }

    
    public function testGetAppHomeVerifyOfflineCourse($oid=214)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['thirdId']="169";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        static  $testV;
     if (empty($result['result']['thirdIds'][0]['list']))
         $this->assertEmpty($result['result']['thirdIds'][0]['list']);
     else
     { 
         foreach ($result['result']['thirdIds'][0]['list'] as $key => $Value)
        {
                  if($Value['courseId']==511)
                      $testV=1;          
          }
          if ($testV==1)
              $this->assertFalse('true','course 511 should not be in result!');
     }
    }
    
   
    //分销课程不显示 分销模板返回课程应为空
    public function testGetAppHomeVerifyResellCourse($oid=214)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['secondId']="15,15";
        //$postdata['params']['thirdId']="169,24";
        $postdata['params']['userId']="23361";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
       $result =json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
       $templateName=array_column($result['result']['recommends'],'name');
       foreach($templateName as $key =>$value)
       {
           if ($value=="分销课程")
               $this->assertEquals(0,count($result['result']['recommends'][$key]['list']),"Fail! resell course should be hided".' Post data:'.json_encode($postdata));
       }
       }
     
  

  

 
  

   

}
