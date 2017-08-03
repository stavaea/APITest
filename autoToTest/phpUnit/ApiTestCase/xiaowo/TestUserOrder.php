<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

/**
 * test case.
 */
class TestUserOrder extends PHPUnit_Framework_TestCase
{
private  $url;
private  $http;
private $Token;
static  $u="i";
static  $v="2";
public  $uid;

 protected function setUp()
{
    $this->url="test.gn100.com/interface/user/order";
    $this->http = new HttpClass();
    $this->Token =new TestUserToken();
}

 public function testUserOrderVerifyFields($oid,$uid)
 {
     $postdata['time']=strtotime(date('Y-m-d H:i:s'));
     $postdata['oid']=$oid;
     $postdata['u']=self::$u;
     $postdata['v']=self::$v;
     $postdata['params']['page']="1";
     $postdata['params']['length']="30";
     $postdata['params']['uid']=$uid;
     $postdata['params']['status']="all";
     $key=interface_func::GetAppKey($postdata);
     $postdata['key']=$key;
     $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
     $postdata['token']=$token;
     $result =$this->http->HttpPost($this->url, json_encode($postdata));
     var_dump($result);
 }
}
    
  
  


