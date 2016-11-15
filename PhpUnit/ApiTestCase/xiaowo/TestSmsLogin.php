<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

//todo 通过走数据库拿短信验证码
/**
 * test case.
 */
class TestSmsLogin extends PHPUnit_Framework_TestCase
{

    protected $url;
    private $http;
    private $func;
    static  $u="i";
    static  $v="2";
    public $mobile;
    public $type;
    
    protected function setUp()
    {
        $this->url="test.gn100.com/interface/login/smsLogin ";
        $this->http = new HttpClass();
        $this->func =new interface_func();
    }
    
    /*

    public function testSmsLoginNoPhoneNum($mobile='15669744621',$type='4')
    {
        $this->func->GetVerificationCode($mobile,$type);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['mobile']=$mobile;
        $postdata['params']['verifyCode']=" ";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result= $this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
    */
    
    
    public function testSmsLoginNoPhoneNum($mobile='18518750406',$type='4')
    {
        $this->func->GetVerificationCode($mobile,$type);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['mobile']=$mobile;
        $postdata['params']['verifyCode']="4981";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        echo $key;
        $result= $this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
    
    /*
    public function testSmsLoginPhoneNumNotExist($mobile='132323322323',$type='4')
    {
        $this->func->GetVerificationCode($mobile,$type);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['mobile']=$mobile;
        $postdata['params']['verifyCode']="9920";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result= $this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
    
    /*
    /**
     *
     * @dataProvider additionProvider
     */
    /*
    public function testSmsLoginVerifyCellPhoneNum($mobile,$type)
    {
        $this->func->GetVerificationCode($mobile,$type);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['mobile']=$mobile;
        $postdata['params']['verifyCode']="9920";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result= $this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
 
      
    public function additionProvider()
    {
        return array(
            //"186"=>array('18610155537','4'),
            //"180"=>array('18010155537','4'),
           // "176"=>array('17600839541','4'),
           // "156"=>array('15624934000','4'),
          "155"=>array('15510091111','4'),
          //  "132"=>array('13264134814','4'),
         //   "131"=>array('13164134814','4'),
          //    "130"=>array('13011165159','4'),
         //   "170"=>array('17008539990','4'),
        //    "177"=>array('17710709939','4'),
       //     "181"=>array('18108539990','4'),
           //   "189"=>array('18911155532','4'),
        );
    }
 
   /*  //已注册国际号码
    public function testSmsLoginInternationalUser($mobile="+8108051575989",$type='4')
    {
        $this->func->GetVerificationCode($mobile,$type);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['mobile']=$mobile;
        $postdata['params']['verifyCode']="3804";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result= json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $this->assertEquals('1049',$result['code']);
    }
    
  //新用户测试，注册后，删除数据库该用户记录恢复为未注册用户
    t_user
    t_user_mobile
    t_user_profile
    三表删除用户信息。
     public function testSmsLoginRegUser($mobile="15669744621",$type='4')
    {
        $this->func->GetVerificationCode($mobile,$type);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['mobile']=$mobile;
        $postdata['params']['verifyCode']="2026";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result= $this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
   
         public function testSmsLoginNewUser($mobile="15669744621",$type='4')
    {
        $this->func->GetVerificationCode($mobile,$type);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['mobile']=$mobile;
        $postdata['params']['verifyCode']="2026";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result= $this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
    */
   
    

}

