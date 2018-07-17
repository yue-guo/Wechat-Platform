<?php 
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;

class UserinfoController extends Controller{
    public function index(){
        $_SESSION['openid'] = $_GET['openid'];
        $this->display('Userinfo/index');
    }
	public function doInfo(){
        session_start();        
        $openid = $_SESSION['openid'];
        $user_connect = $_POST['user_connect'];
        $user_mail = $_POST['user_mail'];
        $user_department = $_POST['user_department'];
        $user = new UserModel();
        $user->insertMore($openid,$user_connect,$user_mail,$user_department);
        $this->display('Success/index');
	}
}
?>