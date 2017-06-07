<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';
require_once 'TestAddComment.php';

/**
 * test case.
 */
class TestDelComment extends PHPUnit_Framework_TestCase
{
    protected $url;
    public    $http;
    static  $u="i";
    static  $v="2";
    public  $Token;
    public $AddCom;
 
    protected function setUp()
    {
         $this->url="test.gn100.com/interface.user.delcomment";
         $this->http = new HttpClass();
         $this->AddCom =new TestAddComment();
         $this->Token =new TestUserToken();
    }
    
    
/**
 * @dataProvider additionProvider
 */
    public function testDelCommentVeriryUidShouldBeReg($courseId,$planId,$uid)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['planId']=$planId;
        $postdata['params']['uid']=$uid;
        $postdata['params']['courseId']=$courseId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->Token->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
    }
   
    Public function additionProvider()
    {
        return array(
           // "no reg user"=>array('695','2249','8303'),
          //  "no login user"=>array('283','888','5401'),
            "login user"=>array('794','2629','23361')
            //"reg user"=>array('976','3464','5312')
        );
    }
    public function testDelCommentNoComment()
    {
        
    }
}

