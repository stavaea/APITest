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
    public function CourseSeek($url,$f,$q,$ob,$p,$pl)
    {
        global $IP;
        $url="http://".$IP."/seek/course/list/";
        $postdata['f']=$f;
        $postdata['q']=$q;
        $postdata['ob']=$ob;
        $postdata['p']=$p;
        $postdata['pl']=$pl;
        $result=json_decode($this->http->HttpApiPost($url, json_encode($postdata)),true);
        return $result;
    }
    
    public function PlanSeek($url,$f,$q,$ob,$p,$pl)
    {
        global $IP;
        $url="http://".$IP."/seek/plan/list/";
         $postdata['f']=$f;
         $postdata['q']=$q;
         $postdata['ob']=$ob;
         $postdata['p']=$p;
         $postdata['pl']=$pl;
         $result=json_decode($this->http->HttpApiPost($url, json_encode($postdata)),true);
         return $result;  
    }
    
    public function TeacherSeek($f,$q,$ob)
    {
        global $IP;
        $url="http://".$IP."/seek/teacher/list/";
        $postdata['f']=$f;
        $postdata['q']=$q;
        $postdata['ob']=$ob;
        $postdata['p']=1;
        $postdata['pl']=20;
        $result=json_decode($this->http->HttpApiPost($url, json_encode($postdata)),true);
        return $result;
    }
   
}


