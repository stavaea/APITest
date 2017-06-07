<?php
/*
 * 连接数据库
 */

class dbConnect
{
    //连接数据库，并执行sql
    public static  function ConnectDB($mysql_db,$sql)
    {
        $mysql_server_name='121.42.232.104';
        $mysql_user='michael';
        $mysql_user_password='michael';
        $conn=mysqli_connect($mysql_server_name,$mysql_user,$mysql_user_password,$mysql_db,'3306') or die ("Failed to connect mysql");
        $conn->query("set names utf8");
        $resultQuery=mysqli_query($conn,$sql);
        if (is_bool($resultQuery)){
            return $resultQuery;
        }else{
            $result=(mysqli_fetch_all($resultQuery));
            mysqli_close($conn);
            return $result;
        }
    }
}