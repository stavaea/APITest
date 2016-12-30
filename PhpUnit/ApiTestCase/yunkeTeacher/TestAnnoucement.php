<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';
require_once 'yunkeTeacher/TestAnnoucementGet.php';



class TestAnnoucement extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
     protected function setUp()
     {
        //公告添加
        $this->url = "http://test.gn100.com/interface/announcement/Announcement";
        $this->http = new HttpClass();
    
     }
    
    
    //发布公告
     
    public function testAddDataIsOK($fk_plan='3724')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['status']= "1";
        $postdata['params']['fkPlan']= $fk_plan;
        $postdata['params']['content']='测试一下公告哦';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
    
        $this->assertEquals('0',$result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        
        TestAnnouncementGet::testAnnouceDataIsOK($fk_plan);
    }
    
    //status不存在，返回值
    
    public function testStatusIsNotExist($fk_plan='3724')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['status']= "3";
        $postdata['params']['fkPlan']= $fk_plan;
        $postdata['params']['content']='不存在的状态值';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEmpty($result,'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
        //参数content为空，返回值
        public function testContentIsNull($fk_plan='3724')
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           $postdata['params']['status']= "1";
           $postdata['params']['fkPlan']=$fk_plan;
           $postdata['params']['content']='';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
           $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
           
           $this->assertEquals('1001',$result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//content为空
            
       }  
       
       
       
       //参数content大于100个汉字，返回值
       public function testContentChineseIsBig($fk_plan='3724')
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           $postdata['params']['status']= "1";
           $postdata['params']['fkPlan']=$fk_plan;
           $postdata['params']['content']='一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五啊';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
           $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            
           $this->assertEquals('2051',$result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//content大于100个汉字
       
       }
       
       
       //参数content大于200个字符，返回值
       public function testContentEnglishIsBig($fk_plan='3724')
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           $postdata['params']['status']= "1";
           $postdata['params']['fkPlan']=$fk_plan;
           $postdata['params']['content']='abcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdew';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
           $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
       
           $this->assertEquals('2051',$result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//content大于200个字符
           
       }
       
       
       //更新公告
       public function testUpdateDataIsOK($fk_plan='3724')
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           $postdata['params']['status']= "1";
           $postdata['params']['fkPlan']= $fk_plan;
           $postdata['params']['content']='我更改一下公告哦';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
           $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
       
           $this->assertEquals('0',$result['code']);
       
           TestAnnouncementGet::testAnnouceUpdateDataIsOK($fk_plan);
       
       }
       
       //删除公告
       public function testDelDataIsOK($fk_plan='3724')
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           $postdata['params']['status']= "2";
           $postdata['params']['fkPlan']= $fk_plan;
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
           $this->assertEquals('0',$result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
           TestAnnouncementGet::testAnnouceDelDataIsOK($fk_plan);
       }
       
       
}