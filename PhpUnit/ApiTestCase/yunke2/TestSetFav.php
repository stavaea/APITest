<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once 'TestTeacherInfo.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestSetFav extends PHPUnit_Framework_TestCase
{
    private $url;
    public  $http;
    private  $tInfo;
    public $GetToken;
    static $u="p";
    static $v="2";
    
    public function  setUp()
    {
         $this->url = "http://test.gn100.com/interface/teacher/setFav";
         $this->http = new HttpClass();
         $this->tInfo=new TestTeacherInfo();
         $this->GetToken =new TestUserToken();
    }
    

    //传参正确，uid存在，收藏新老师，收藏成功
    public function testSetFavIsOk($userId='22412',$teacherId='23402')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['teacherId']=$teacherId;
        $token=$this->GetToken->testUserTokenGenIsSuccess($userId);
        $postdata['token']=$token;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('success', $result['message'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('操作成功', $result['errMsg'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->tInfo->testTeacherFav($userId,$teacherId);           
    }
  

    //传参正确，uid存在，点击已收藏老师，取消收藏成功
    public function testSetUnFav($userId='22412',$teacherId='23402')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['teacherId']=$teacherId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('success', $result['message'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('操作成功', $result['errMsg'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->tInfo->testTeacherUnFav($userId,$teacherId);           
    }

    
    //errorcode，uid为0，点击收藏老师，返回1021
    public function testVistorFav($userId='0',$teacherId='23402')
 {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['teacherId']=$teacherId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1021', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('no landing', $result['message'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('没有登陆', $result['errMsg'],'url:'.$this->url.'   Post data:'.json_encode($postdata));        
    }
    
    //errorcode，老师收藏自己，返回1025
    public function testFavMyself($userId='22411',$teacherId='22411')
 {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['teacherId']=$teacherId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1025', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals("You can't collect yourself", $result['message'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('自己不能收藏自己', $result['errMsg'],'url:'.$this->url.'   Post data:'.json_encode($postdata));        
    }
    
    //errorcode，未传必填参数
    public function testNoTeacherId($userId='0')
 {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['teacherId']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1021', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('no landing', $result['message'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('没有登陆', $result['errMsg'],'url:'.$this->url.'   Post data:'.json_encode($postdata));        
    }
    
    //errorcode，传参名错误
    public function testParamsError($userId='0',$teacherId='0')
 {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['teacheId']=$teacherId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1021', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('no landing', $result['message'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('没有登陆', $result['errMsg'],'url:'.$this->url.'   Post data:'.json_encode($postdata));        
    }
    
    //errorcode，传参teacherId非老师id
    public function testFavStudent($userId='22410',$teacherId='22717')
 {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$userId;
        $postdata['params']['teacherId']=$teacherId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('success', $result['message'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('操作成功', $result['errMsg'],'url:'.$this->url.'   Post data:'.json_encode($postdata));     
    } 
    
    protected function tearDown()
    {
        unset($this->http);
        unset($this->GetToken);
        unset($this->tInfo);
    }
}