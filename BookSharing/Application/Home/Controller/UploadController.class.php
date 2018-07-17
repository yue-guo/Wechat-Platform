<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;
use \sinacloud\sae\Storage as Storage;

class UploadController extends Controller{
	public function index(){
        $code = $_GET["code"];
        $result = self::getUserInfo($code);
        $_SESSION['openid'] = $result['openid'];
        //var_dump($openid);die;
        $this->display('index');
	}

	public function doUpload($isbn) {
        session_start();        
        $openid = $_SESSION['openid'];
        $_SESSION['isbn'] = $isbn;
        if(!empty($openid)){
            $book = new BooksModel();
            $answer = $book->findBooks($isbn,$openid);
            if(!empty($answer)){
                //$book->bookPlus($openid, $isbn, $count);
                $result = $book->findBooks($isbn,$openid);
                $array['book_url'] = $result[0]['book_url'];
                $array['book_name'] = $result[0]['book_name'];
                $array['book_author'] = $result[0]['book_author'];
                $array['book_translator'] = $result[0]['book_translator'];
                $array['book_print'] = $result[0]['book_print'];
                $array['book_isbn'] = $result[0]['book_isbn'];
                $array['book_info'] = $result[0]['book_info'];
                $array['openid'] = $openid;
                $this->assign($array);
                $this->display('ShowResult/index');                
            }
            else{
                $url = "https://api.douban.com/v2/book/isbn/:".$isbn;  
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   
                $result = curl_exec($curl);
                curl_close($curl);
                $book_array =  (array)json_decode($result, true);
                //var_dump($book_array);die;
                
                if(!empty($book_array["title"])) {
                    $book_id = "";
                    $book_name = $book_array["title"];
                    $class_id = "";
                    $book_url = $book_array["image"];      
                    $book_author = $book_array["author"][0];
                    $book_translator = $book_array["translator"][0];
                    $book_print = $book_array["publisher"];
                    $book_isbn = $book_array["isbn13"]; // ISBN13
                    $book_info = $book_array["summary"]; 
                    $book_price = "";
                    $book_seller = $openid;
                    //$book_tags = $book_array["tags"][0];
                    //var_dump($book_tags);die;
                    $array['book_id'] = $book_id;
                    $array['book_name'] = $book_name;
                    $array['class_id'] = $class_id;
                    $array['book_url'] = $book_url;
                    $array['book_author'] = $book_author;
                    $array['book_translator'] = $book_translator;
                    $array['book_print'] = $book_print;
                    $array['book_isbn'] = $book_isbn;
                    $array['book_info'] = $book_info;
                    $array['openid'] = $book_seller;
                    //$book = new BooksModel();
                    //$a = $book->insertBookInfo($book_name,$book_url,$book_author,$book_translator,$book_print,$book_isbn,$book_info,$book_seller);
                    $this->assign($array);
                    $this->display('ShowResult/index');
                }
                else{
                    //$this->assign($_SESSION['isbn']);
                    $this->display('Selfupload/index');
                }
            }
        }
   }

	public static function getUserInfo($code){
    $appid = "wxccdc7d0ff61299f6";
	$appsecret = "9cfe8bda6e88df570c58b0c2c253b09f";

	if(empty($_COOKIE['openid'])){
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
		$result = json_decode(file_get_contents($url),true);
		if(empty($result['access_token'])){
            //echo '微信授权失败，access_token获取失败';
            exit;
		}

		$token = $result['access_token'];
		$openid = $result['openid'];
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid."&lang=zh_CN";
		$result = json_decode(file_get_contents($url),true);

		if(empty($result['openid'])){
            //echo '微信授权失败，openid获取失败';
            exit;
		}
	}
        return $result;
    }
    
    public function selfUpload(){
        $book_isbn = $_SESSION['isbn'];
        //var_dump($book_isbn);die;
        $array['book_isbn'] = $book_isbn;
        $this->assign($array);
        $this->display('Selfupload1/index');
    }
    
    public function doSelfupload(){
        session_start();        
        $openid = $_SESSION['openid'];
        $book_isbn = $_SESSION['isbn'];
        $book_name = $_POST['book_name'];
        $class_id = $_POST['class'];
        $book_author = $_POST['book_author'];
        $book_translator = $_POST['book_translator'];
        $book_print = $_POST['book_print'];
        $book_isbn = $_POST['book_isbn'];
        $book_info = $_POST['book_info'];
        $book_price = $_POST['book_price'];
        $book_count = $_POST['book_count'];
        $book_info = $_POST['book_info']; 
        //获取上传的书籍
        $imagename = 'imagename'; 
        $files = $_FILES[$imagename];        
        $name = $files[name];
        $s1 = new Storage();          
        $s1->putObjectFile($_FILES['imagename']['tmp_name'], "images", $name);
        $book_url= $s1->getUrl("images",$name);
        //插入书籍数据库
        $book = new BooksModel();
        $book->insertBookInfo($book_name,$class_id,$book_url,$book_author,$book_author,$book_print,$book_isbn,$book_info,$book_count,$book_price,$openid);
        //查询user_id
        $user = new UserModel();
        $answer = $user->selectByOpenid($openid);
        $user_id = $answer[0]['user_id'];
        $sell = new SellModel();
        $sell->insertSell($user_id,$book_isbn,$book_count);
        $this->display('Success/index');
    }
}
?>