<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;
use Home\Model\SearchModel;

class UserfindbookController extends Controller {
    public function index(){
        $_SESSION['openid'] = $_GET['openid'];
        $openid = $_GET['openid']; 
        $this->display('FindBook/index');
    }
    public function doFindBook(){
        session_start();        
        $openid = $_SESSION['openid'];
        $book_isbn = $_POST['book_isbn'];
        $condition = '0';
        $search = new SearchModel();
        $search->insertAll($openid,$book_isbn,$condition); 
        $this->display('Success/index1');
        
    }
}

?>