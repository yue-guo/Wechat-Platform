<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;
use Home\Model\SearchModel;

class TestwechatController extends Controller {
    public function index(){
        $this->display('Test1/index');
    }
    
    public function doTest(){  
        $book = new BooksModel();
        $book_name = $_POST['book_name'];
        $answer = $book->findBookLike($book_name);
        $answer1 = $book->findBookCount($book_name);
        var_dump($answer1);die;
    }
}
?>