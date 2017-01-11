<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestMain extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/main/homev2";
        //$this->url = "http://dev.gn100.com/interface/main/homev2";
        $this->http = new HttpClass();
    }
  
    //参数正确，返回节点是否正确
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='';//云课2的兴趣选择是在定制中，此参数在此没有用
        $postdata['params']['uid']='183';//3596
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(0, $result['code']);
        //比对是否存在相应的节点数据
        $this->assertArrayHasKey('ad',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('types',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('lives',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('interests',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('recommends',$result['result'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }

    /*参数正确，接口返回banner字段正确  */  
    public function testAdFields()
    {
        $db="db_platform";
        $sql = "select title,url,link from t_platform_banner where status=1 and type=2 order by order_no asc;";
        $ad=interface_func::ConnectDB($db, $sql); //db获取手机尺寸banner
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='';
        $postdata['params']['uid']='183';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $postdata['dinfo']['rw']="414.000000";
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(count($ad), count($result['result']['ad']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertContains($ad[0][1],$result['result']['ad']['0']['image'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertContains($ad[0][2],$result['result']['ad']['0']['url'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
              
    }

   //传参正确，返回二级分类列表正确，接口写死，返回1000、2000、3000、0
     public function testTypes()
    {
        $arraytype=array("小学","初中","高中","全部");
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='';
        $postdata['params']['uid']='183';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEmpty(array_diff($arraytype,array_column($result['result']['types'],'name')),'url:'.$this->url.'   Post data:'.json_encode($postdata));          
    }
    
    //传参正确，recommend模块返回sc字段
    public function testSc()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='';
        $postdata['params']['uid']='183';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('8',$result['result']['recommends']['1']['sc'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    //传参正确，直播课堂模块，返回日期和list模块类型和字段正确，array
    public function testLive()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='';
        $postdata['params']['uid']='183';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $arrayResult=array_keys($result['result']['lives']);
        $this->assertTrue(is_int($arrayResult[0]),'url:'.$this->url.'   Post data:'.json_encode($postdata));

    }
      //推荐模块课程信息验证
    public function testRecommendsList()
    {
        $arrayRecommendName=array("小学阶段","初中阶段","高中阶段");
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='';
        $postdata['params']['uid']='183';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $arrayResult=array_keys($result['result']['recommends']['0']['list']);
        $this->assertTrue(is_int($arrayResult[0]),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEmpty(array_diff($arrayRecommendName,array_column($result['result']['recommends'],'attrName')),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('2',$result['result']['recommends']['1']['list']['1']['type'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $arrayJunior=array_column($result['result']['recommends']['1']['list'],'total');
        $this->assertLessThan( $arrayJunior[0],  $arrayJunior[1],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('976', $result['result']['recommends']['2']['list']['0']['courseId']);
        $this->assertEquals('app-plancomment接口测试课程', $result['result']['recommends']['2']['list']['0']['title'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('1', $result['result']['recommends']['2']['list']['0']['courseType'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('hye测试机构', $result['result']['recommends']['2']['list']['0']['orgSubname'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
   //推荐模块验证
    public function testRecommendsCheckTotal()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='';
        $postdata['params']['uid']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('3',$result['result']['recommends']['0']['list']['2']['type'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0',$result['result']['recommends']['0']['list']['2']['total'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //兴趣模块课程信息验证
    public function testInterests()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='170';
        $postdata['params']['uid']='183';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $arrayResult=array_column($result['result']['interests']['0']['list'],'courseId');
        $this->assertTrue(is_int($arrayResult[0]),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        foreach ($arrayResult as $key =>$value)
        {
            if ($arrayResult[$key]=='686')
                $this->assertEquals("勿动-黄金会员课程2", $result['result']['interests']['0']['list'][$key]['courseName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertEquals("http://testf.gn100.com/5,439078e1bc02", $result['result']['interests']['0']['list'][$key]['imgurl'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
                $this->assertNotEmpty($result['result']['interests']['0']['list'][$key]['userTotal'],'url:'.$this->url.'   Post data:'.json_encode($postdata));               
        }         
    }
       
    //参数正确，推荐课程最多四门课程
    public function testRecommendsMoreFour()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['condition']='34,35,36';//云课2的兴趣选择是在定制中，此参数在此没有用
        $postdata['params']['uid']='159';//3596
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(0, $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertLessThanOrEqual('8', count($result['result']['recommends'][1]['list']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    protected function tearDown()
    {
        unset($this->http);
    }
   
}