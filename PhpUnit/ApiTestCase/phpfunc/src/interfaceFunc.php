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

    /**
     * 获取接口数据
     * @param string $url
     * @param array $postData
     * @return object
     */
    public static function getPostData($url, $postData){
        if(empty($postData['params']) || !is_array($postData['params']) || empty($postData['u']) || empty($postData['time'])){
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
       // var_dump($data);
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
