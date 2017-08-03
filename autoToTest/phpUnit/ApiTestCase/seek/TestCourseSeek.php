<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once '../func/dbConfig.php';
/**
 * test case.
 */
class TestCourseSeek extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    private $q=array();
      //  $postData ={"f":["course_id","title","desc","first_cate","second_cate","third_cate","first_cate_name","class_count","second_cate_name","third_cate_name","thumb_big","course_type","user_id","fee_type","price","max_user","min_user","status","admin_status","system_status","comment","avg_score","section_count","vv","user_total","start_time","end_time"],"q":{"course_id":"317"},"ob":{"course_id":"desc"},"p":1,"pl":20};
 
    public function __construct()
    {   
        global $IP;
       $this->url ="http://".$IP."/seek/course/list/"; 
       $this->http =new HttpClass();
       //$this->q =array();
    }
    
    public function testCourseSeekIsOk($q=array("course_id"=>'317'))
    {
        
    }
    
    public function testCourseSeekVerifyIs_Pro($q=array("course_id"=>'317'))
    {
    
    }
    
    public function testCourseSeekVerifyHave_App($q=array("course_id"=>'317'))
    {
    
    }
    
    
}

