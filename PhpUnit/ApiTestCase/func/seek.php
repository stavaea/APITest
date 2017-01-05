<?php
require_once 'Http.class.php';
require_once '../func/dbConfig.php';

class seek
{
    private $http;
    
    public function __construct()
    {
        $this->http = new HttpClass();
    }

    
    //请求course中间层
    public function CourseSeek($f,$q,$ob,$p,$pl)
    {
        global $IP;
        $url="http://".$IP."/seek/course/list/";
        $postdata['f']=$f;    //传参格式如：$f=array("course_id","status");
        $postdata['q']=$q;   //传参格式如：$q=array("status"=>1);
        $postdata['ob']=$ob;    // 传参格式如：$ob=array("course_id"=>"desc");
        $postdata['p']=$p;
        $postdata['pl']=$pl;
        $result=json_decode($this->http->HttpApiPost($url, json_encode($postdata)),true);
        return $result;
    }
    
    public function PlanSeek($f,$q,$ob,$p,$pl)
    {
        global $IP;
        $url="http://".$IP."/seek/plan/list/";
         $postdata['f']=$f;  //传参格式如：$f=array("plan_id","status");
         $postdata['q']=$q; //传参格式如：$q=array("plan_id"=>"120","status"=>1);
         $postdata['ob']=$ob; // 传参格式如：$ob=array("plan_id"=>"desc");
         $postdata['p']=$p;
         $postdata['pl']=$pl;
         $result=json_decode($this->http->HttpApiPost($url, json_encode($postdata)),true);
         return $result;  
    }
    
    public function TeacherSeek($f,$q,$ob,$p,$pl)
    {
        global $IP;
        $url="http://".$IP."/seek/teacher/list/";
        $postdata['f']=$f; //传参格式如：$f=array("teacher_id","user_status","real_name");
        $postdata['q']=$q; //传参格式如：$q=array("course_count"=>"1,20","user_status"=>1);
        $postdata['ob']=$ob;  // 传参格式如：$ob=array("course_id"=>"desc");
        $postdata['p']=$p;
        $postdata['pl']=$pl;
        $result=json_decode($this->http->HttpApiPost($url, json_encode($postdata)),true); 
       //中间层返回json格式数据如：{"data":[{"teacher_id":35656,"user_status":1,"real_name":"Teacher"}],"total":"63","page":1,"pagelength":1,"time":"0.000"}
        return $result; 
 
    }
   
}


