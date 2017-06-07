<?PHP
/**
 * 中间层
 */
class seekFunc{
    
//     public static function seekData($url, $postData){
//         if(empty($url) || empty($postData['field']) || empty($postData['query'])){
//             return array('code'=>401,'msg'=>'必传:url|field|query');
//         }

//         $data = [
//             'q' => $postData['query'],
//             'f' => $postData['field'],
//             'p' => !empty($postData['page']) ? $postData['page'] : 1,
//             'pl'=> !empty($postData['length']) ? $postData['length'] : 20
//         ];

//         if(!empty($postData['order'])){
//             $data['ob'] = $postData['order'];
//         }
        
//         $result = self::postCurl($url, json_encode($data));
//     }

//     public static function postCurl($url, $data){
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//         $output = curl_exec($ch);

//         return $output;
//     }

    
    
    public static function TeacherSeek($f,$q,$ob,$p,$pl)
    {
        if(empty($f) || empty($q) || empty($p) ||empty($pl)){
              return array('code'=>401,'msg'=>'必传:url|field|query');
                    }
        $IP ='121.42.232.104';
        $url="http://".$IP."/seek/teacher/list/";
        $postdata['f']=$f; //传参格式如：$f=array("teacher_id","user_status","real_name");
        $postdata['q']=$q; //传参格式如：$q=array("course_count"=>"1,20","user_status"=>1);
        $postdata['ob']=$ob;  // 传参格式如：$ob=array("course_id"=>"desc");
        $postdata['p']=$p;
        $postdata['pl']=$pl;
        $result=json_decode(self::HttpApiPost($url, json_encode($postdata)),true);
        //中间层返回json格式数据如：{"data":[{"teacher_id":35656,"user_status":1,"real_name":"Teacher"}],"total":"63","page":1,"pagelength":1,"time":"0.000"}
        return $result;
    
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
}
?>
