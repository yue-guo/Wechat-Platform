<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;

class BookDetailController extends Controller {
    public function bookDetail(){
        //var_dump($_GET['id']);die;
        $book_id = $_GET['id'];
        //var_dump($book_id);die;
        $book = new BooksModel();
        $answer = $book->selectById($book_id);
        $openid = $answer[0]['openid'];
        $user = new UserModel();
        $answer1 = $user->selectByOpenid($openid);
        //var_dump($answer);die;
        $array['book_name'] = $answer[0]['book_name'];
        $array['book_url'] = $answer[0]['book_url'];
        $array['book_author'] = $answer[0]['book_author'];
        $array['book_translator'] = $answer[0]['book_translator'];
        $array['book_price'] = $answer[0]['book_price'];
        $array['book_count'] = $answer[0]['book_count'];
        $array['book_info'] = $answer[0]['book_info'];
        $array['user_nickname'] = $answer1[0]['user_nickname'];
        $array['user_connect'] = $answer1[0]['user_connect'];
        $this->assign($array);
        $this->display('index');
        
    }
}

?>