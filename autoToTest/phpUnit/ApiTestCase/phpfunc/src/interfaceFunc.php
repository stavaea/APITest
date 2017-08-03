<?PHP
/**
 * 手机APP公共接口
 */
class interfaceFunc{
    
    /**
     * 请求接口类型
     */
    static  $uniform = [
        'i' => 'gn1002015',
        'a' => 'gn1002015',
        'p' => 'gn1002015'
    ];
    
    /**
     * 生成私钥
     * @param array $params
     * @param string $u
     * @param string $time
     * @return string
     */
    public static function createKey($params, $u, $time){
        if(empty(self::$uniform[$u])){
            return array('code'=>'402','msg'=>'u 只支持i|o|p');
        }

        $uniform = self::$uniform[$u];
        $paramsJson = json_encode($params, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        return md5(md5($paramsJson.$time.$uniform));
    }
    
    //获取token值
    public static function testUserTokenGenIsSuccess($userId="22414")
    {
        $IP='192.168.0.43';
        //$IP='121.42.232.104';
        $url="http://".$IP."/user/token/gen";
        $postData['uid']=$userId;
        $postData['platform']="1";
        $postData['token']="";
        $postData['user_status']="1";
        $postData['live_status']="0";
        $postData['ip']="121.69.7.6";
        $data =json_encode($postData,true);
        $result=json_decode(self::HttpApiPost($url, $data),true);
        $token =$result['data']['token'];
        return $token;
    }
    
    
    public static function HttpApiPost($url,$data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array("Host: api.gn100.com"));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 获取接口数据
     * @param string $url
     * @param array $postData
     * @return object
     */
    public static function getPostData($url, $postData){
        if( !is_array($postData['params']) || empty($postData['u']) || empty($postData['time'])){
            return array('code'=>'401','msg'=>'必传:params(数组)|u|time');
        }
        $key = self::createKey($postData['params'], $postData['u'], $postData['time']);
        $data = json_encode([
            'u'      => $postData['u'],
            'v'      => !empty($postData['v']) ? $postData['v'] : 1,
            'oid'    => !empty($postData['oid']) ? $postData['oid'] : 0,
            'key'    => $key,
            'time'   => $postData['time'],
            'params' => $postData['params']
        ]);
        var_dump($data);
        return json_decode(self::postCurl($url, $data), true);
    }
    
    
    
    public static function getPostTokenData($url, $postData){
        if(empty($postData['params']) || !is_array($postData['params']) || empty($postData['u']) || empty($postData['time'])){
            return array('code'=>'401','msg'=>'必传:params(数组)|u|time');
        }
        
        $key = self::createKey($postData['params'], $postData['u'], $postData['time']);
        $token = self::testUserTokenGenIsSuccess($postData['userId']);
        $data = json_encode([
            'u'      => $postData['u'],
            'v'      => !empty($postData['v']) ? $postData['v'] : 1,
            'oid'    => !empty($postData['oid']) ? $postData['oid'] : 0,
            'key'    => $key,
            'time'   => $postData['time'],
            'params' => $postData['params'],
            'token'  => $token
        ]);
        var_dump($data);
        return json_decode(self::postCurl($url, $data), true);
    }

    public static function postCurl($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);

        return $output;
    }
}
?>
