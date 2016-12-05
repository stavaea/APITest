<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'interface_func.php';

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
        var_dump($result);
    }

}
