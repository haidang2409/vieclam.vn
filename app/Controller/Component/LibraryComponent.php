<?php
class LibraryComponent extends Component
{
    public function randomNumber($option = 10)
    {
        $int = rand(0,51);
        $a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $rand_letter = $a_z[$int];
        for($i=1; $i < $option; $i++){
            $int1 = rand(0,51);
            $rand_letter.= $a_z[$int1];
        }
        return $rand_letter;
    }
    function convert_dmy_to_ymd($datetime)
    {
        if($datetime != '' && $datetime != null)
        {
            $arr = explode(' ', $datetime);
            $date = $arr[0];
            $arrDate = explode('/', $date);
            $newDate = $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
            return $newDate;
        }
        else
        {
            return null;
        }
    }
    public function make_link($str){
        $str = trim($str);
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd'=>'đ|Đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '-'=>' |_',
        );
        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $str = preg_replace('/[^a-zA-Z0-9\-_]/','',$str);
        $str = preg_replace('/\-\-+/', '-', $str);
        $num = strlen($str);
        if($num > 255)
        {
            $str = substr($str, 0, 255);
        }
        return strtolower(rtrim($str, '-'));
    }
    function encrypt_data($string, $key){
        $result = "";
        for($i=0; $i<strlen($string); $i++){
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }
        $salt_string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxys0123456789";//~!@#$^&*()_+`-={}|:<>?[]\;',./";
        $length = rand(1, 15);
        $salt = "";
        for($i=0; $i<=$length; $i++){
            $salt .= substr($salt_string, rand(0, strlen($salt_string)), 1);
        }
        $salt_length = strlen($salt);
        $end_length = strlen(strval($salt_length));
        return base64_encode($result.$salt.$salt_length.$end_length);
    }
    function decrypt_data($string, $key){
        $result = "";
        $string = base64_decode($string);
        $end_length = intval(substr($string, -1, 1));
        $string = substr($string, 0, -1);
        $salt_length = intval(substr($string, $end_length*-1, $end_length));
        $string = substr($string, 0, $end_length*-1+$salt_length*-1);
        for($i=0; $i<strlen($string); $i++){
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }
        return $result;
    }
    function convertDateTime_Mysql_to_DateTime($datetime)
    {
        $arr = explode(' ', $datetime);
        $date = $arr[0];
        $arrDate = explode('-', $date);
        $newDate = $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0] . ' ' . $arr[1];
        return $newDate;
    }
    function convert_ymd_to_dmy($datetime)
    {
        $arr = explode(' ', $datetime);
        $date = $arr[0];
        $arrDate = explode('-', $date);
        $newDate = $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
        return $newDate;
    }
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    function watermark_image($file, $destination, $overlay){
        $watermark =    imagecreatefrompng($overlay);
        $source = getimagesize($file);
        $source_mime = $source['mime'];
        //Lấy kích thướt ảnh
        //print_r($source)//để xem tham số
        $source_x = $source[0];
        $source_y = $source[1];
        if($source_mime == "image/png"){
            $image = imagecreatefrompng($file);
        }else if($source_mime == "image/jpeg"){
            $image = imagecreatefromjpeg($file);
        }else if($source_mime == "image/gif"){
            $image = imagecreatefromgif($file);
        }
        //Lấy chiều ngang/2 = tâm x, trừ 147(do anh mark co chieu ngang 295/2) => anh mark nam ngay tam theo chieu ngang
        $X = ($source_x / 2) - 147;
        //Lấy chiều cao - 50 (do anh mark cao 40) tru them 10 để cách bottom 10
        $Y = $source_y - 50;
        imagecopy($image, $watermark, $X, $Y, 0, 0, imagesx($watermark), imagesy($watermark));
        imagepng($image, $destination);
        return $destination;
    }
    function base64_to_jpeg($base64_string, $output_file)
    {
        // open the output file for writing
        $ifp = fopen($output_file, 'wb');
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );
        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, base64_decode($data[1]));
        // clean up the file resource
        fclose( $ifp );
        return $output_file;
    }
}