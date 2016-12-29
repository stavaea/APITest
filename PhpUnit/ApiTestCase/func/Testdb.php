<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'interface_func.php';
require_once 'seek.php';
/**
 * test case.
 */
class Testdb extends PHPUnit_Framework_TestCase
{

    public function testConnDb()
    {
        $db="db_user";
        $sql="SELECT  * FROM db_user.t_user where pk_user=22410";
        $result =interface_func::ConnectDB($db,$sql);
    }

    public function testSeek()
    {
    $f=array("teacher_id","user_status","real_name");
    $ob=array("course_id"=>"desc");
    $q=array("course_count"=>"1,20","user_status"=>1);
    $seekdata=new seek();
    $result = $seekdata->TeacherSeek($f, $q, $ob);
    var_dump($result);
    }
}
