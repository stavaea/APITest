<?php
  class HttpClass 
  {
      var $url;
      var $data=array();
      public function HttpPost($url,$data)
      { 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
       
      }
      
      public function HttpGet($url)
      {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
      }
   
      public function HttpGetCode($url)
      {
          $ch =curl_init($url);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
          curl_setopt($ch, CURLOPT_TIMEOUT, 10);
          curl_exec($ch);
          $http_code= curl_getinfo($ch,CURLINFO_HTTP_CODE);
          curl_close($ch);
          return $http_code;
      }
      
      public function HttpPostCode($url,$data)
      {
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
          curl_setopt($ch, CURLOPT_TIMEOUT, 10);
          $result = curl_exec($ch);
          $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
          curl_close($ch);
          return $httpcode;
          
      }
      
    } 