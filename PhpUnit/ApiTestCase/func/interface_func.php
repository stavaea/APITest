<?php
require_once 'Sconfig.php';
require_once 'Http.class.php';
require_once 'dbConfig.php';

class interface_func
{
    private static $u="i";
    private static $v="2";
    private $http;
   
    public function __construct()
    {
        $this->http = new HttpClass();
    }
    
    //app接口，获取appkey
    public static function GetAppKey($param)
    {
       $tParam = json_encode($param['params'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $conf = 'gn1002015';
        $tKey = md5(md5($tParam.$param['time'].$conf));
        return $tKey;
    }

    public  function AppLogin($param)
    {
        $url="test.gn100.com/interface/login";
        
  
    }
   
    public function  AuthCheck($param)
    {
        
    }
    //获取短信验证码
    public function  GetVerificationCode($mobile,$type)
    {
       $url="test.gn100.com/interface/user/GetVerificationCode";
       $postdata['time']=strtotime(date('Y-m-d H:i:s'));
       $postdata['u']=self::$u;
       $postdata['v']=self::$v;
       $postdata['params']['mobile']=$mobile;
       $postdata['params']['type']=$type;
       $key=self::GetAppKey($postdata);
       $postdata['key']=$key;
       $result=$this->http->HttpPost($url, json_encode($postdata));
       var_dump($result);
       return $result;
    }
    
    //建课接口，获取courseAddToken参数
     public static  function GetCourseAddToken()
     {
         $addtoken=md5(time().'courseAddToken'.time());
         return $addtoken;
     }
     
     //连接数据库，并执行sql
     public static  function ConnectDB($mysql_db,$sql)
     {
         $conn=mysql_connect($mysql_server_name,$mysql_user) or die ("Failed to connect mysql");
         mysql_query("set names 'utf8'");
         mysql_select_db($mysql_db);
         $result =mysql_query($sql,$conn);
         mysql_close();
     }
}


