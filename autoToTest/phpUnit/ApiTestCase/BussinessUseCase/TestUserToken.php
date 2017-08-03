<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/dbConfig.php';
/**
 * test case.
 */
class TestUserToken extends PHPUnit_Framework_TestCase
{
    /**
     * Constructs the test case.
     */
    public  $http;
    public  $uid;
    public function __construct()
    {
        $this->http=new HttpClass();
    }
    
    /*
     * test API user/token/gen
     */
    /*
     * ��½�û����token��ȷ����
     */
    public function testUserTokenGenIsSuccess($uid="22414")
    {
        global $IP;
        $url="http://".$IP."/user/token/gen";
        $postData['uid']=$uid;
        $postData['platform']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $postData['ip']="121.69.7.6";
        $data =json_encode($postData,true);
        $result=json_decode($this->http->HttpApiPost($url, $data),true);
        $token =$result['data']['token'];
        $this->assertEquals('0',$result['result']['code']);
        $this->assertNotEmpty($result['data']['token']);
        return $token;
    }
    
    
    public function testUserTokenGenIsSuccessDev($uid="22414")
    {
        global $IPDev;
        $url="http://".$IPDev."/user/token/gen";
        $postData['uid']=$uid;
        $postData['platform']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $postData['ip']="192.168.0.43";
        $data =json_encode($postData,true);
        $result=json_decode($this->http->HttpApiPost($url, $data),true);
        $token =$result['data']['token'];
        $this->assertEquals('0',$result['result']['code']);
        $this->assertNotEmpty($result['data']['token']);
        return $token;
    }
    
    public static function testUserStaticTokenGenIsSuccess($uid="3596")
    {
        global $IP;
        $url="http://".$IP."/user/token/gen";
        $postData['uid']=$uid;
        $postData['platform']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $postData['ip']="121.69.7.6";
        $data =json_encode($postData,true);
         $result =  json_decode(HttpClass::HttpStaticApiPost($url, $data),true);
         $token =$result['data']['token'];
         self::assertEquals('0',$result['result']['code']);
         self::assertNotEmpty($result['data']['token']);
         return $token;
    }
    
    
    /*
     * �ο����token��ȷ
     */
    public function testUserTokenGenVisitor()
    {
        global $IP;
        $url="http://".$IP."/user/token/gen";
        $postData['uid']="0";
        $postData['platform']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $postData['ip']="121.69.7.6";
        $data =json_encode($postData,true);
        $result =  json_decode($this->http->HttpApiPost($url, $data),true);
        $token2 =$result['data']['token'];
        $this->assertEquals('0',$result['result']['code']);
        return $token2;
    }
    
    /*
     * �������ȷʵ����
     */
    public function testUserTokenGenNoIp()
    {
        global $IP;
        $url="http://".$IP."/user/token/gen";
        $postData['uid']="22410";
        $postData['platform']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $data =json_encode($postData,true);
        $result =  json_decode($this->http->HttpApiPost($url, $data),true);
        $this->assertEquals('-1',$result['result']['code']); 
    }
    
    /*
     * �������������
     */
    
    public function testUserTokenGenParamsError()
    {
        global $IP;
        $url="http://".$IP."/user/token/gen";
        $postData['uid']="22410";
        $postData['platform3']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $data =json_encode($postData,true);
        $result =  json_decode($this->http->HttpApiPost($url, $data),true);
        $this->assertEquals('-1',$result['result']['code']);
    }
    
    
    /*
     * tokenΨһ������
     */
    /**
     * 
     * @depends testUserTokenGenIsSuccess
     * @depends testUserTokenGenVisitor
     */
    public function testUserTokenGenUnique($token,$token2)
    {
        $this->assertNotEquals($token, $token2);
    }
    
    /*
     * test API user/token/get
     */
    
    /*
     * ���token��ȡ�û���Ϣ��ȷ
     */
    
    /**
     * @depends testUserTokenGenIsSuccess
     */
    public function testUserTokenGetIsSuccess($token)
    {
        global $IP;
        $url="http://".$IP."/user/token/get/$token";
        $result =json_decode($this->http->HttpApiGet($url),true);
        $this->assertEquals('0', $result['result']['code']);
        $this->assertEquals('22414', $result['data']['uid']);
    }
    
    /*
     * �û�����������
     */
    public function testUserTokenGetParamsError()
    {
         global $IP;
        $url="http://".$IP."/user/token/get/2993939";
        $result =json_decode($this->http->HttpApiGet($url),true);
        $this->assertEquals('-1', $result['result']['code']);
    }
    
    /*
     * test API user/token/del
     */
    
    /*
     * ɾ��token�ɹ�����
     */
    /**
     * @depends testUserTokenGenIsSuccess
     */
    public function testUserTokenDel($token)
    {
        global $IP;
        $url="http://".$IP."/user/token/del/$token";
        $result =json_decode($this->http->HttpApiPost($url, ''),true);
        $this->assertEquals('1', $result['result']['code']);
        $geturl="http://api.gn100.com//user/token/get/$token";
        $getresult =json_decode($this->http->HttpApiGet($url),true);
        $this->assertEquals('-1', $getresult['result']['code']);
    }
    
    /*
     * ɾ���ο�token
     */
    /**
     * @depends testUserTokenGenVisitor
     */
    public function testUserTokenDelVisitorToken($token2)
    {
        global $IP;
        $url="http://".$IP."/user/token/del/$token2";
        $result =json_decode($this->http->HttpApiPost($url, ''),true);
        $this->assertEquals('1', $result['result']['code']);
    }
    
    }


