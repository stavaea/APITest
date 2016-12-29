<?php
require_once 'Http.class.php';

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
        $url='http://api.gn100.com//seek/course/list/';
        $postdata['f']=$f;
        $postdata['q']=$q;
        $postdata['ob']=$ob;
        $postdata['p']=$p;
        $postdata['pl']=$pl;
        $result=json_decode($this->http->HttpPost($url, json_encode($postdata)),true);
        return $result;
    }
    
    public function PlanSeek($url,$f,$q,$ob,$p,$pl)
    {
         $url='http://api.gn100.com/seek/plan/list/';
         $postdata['f']=$f;
         $postdata['q']=$q;
         $postdata['ob']=$ob;
         $postdata['p']=$p;
         $postdata['pl']=$pl;
         $result=json_decode($this->http->HttpPost($url, json_encode($postdata)),true);
         return $result;  
    }
    
    public function TeacherSeek($f,$q,$ob)
    {
        $url='http://api.gn100.com//seek/teacher/list/';
        $postdata['f']=$f;
        $postdata['q']=$q;
        $postdata['ob']=$ob;
        $postdata['p']=1;
        $postdata['pl']=20;
        var_dump(json_encode($postdata));
        $result=json_decode($this->http->HttpPost($url, json_encode($postdata)),true);
        return $result;
    }
   
}


