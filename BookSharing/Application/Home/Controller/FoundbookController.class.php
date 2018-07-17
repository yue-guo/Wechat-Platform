<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;
use Home\Model\SearchModel;

class FoundbookController extends Controller {
    public function index(){
        $openid = $_GET['openid'];
        $_SESSION['openid'] = $openid;
        $search = new SearchModel();      
        $answerc = $search->findCountByOpenid($openid);
        for($i=0;$i<$answerc;$i++){
          $answer1 = $search->foundBooks($openid);
        	$book_isbn = $answer1[$i]['book_isbn'];
        	$book = new BooksModel();
        	$answer = $book->selectByISBN($book_isbn);
            //$answer2[$i] = $answer;
            //var_dump($answer[0]['book_id']);die;
        }
        //$book_isbn = $answer1[0]['book_isbn'];
        //$book = new BooksModel();
        //$answer = $book->findBooks($book_isbn,$openid);
        //$answer = $book->selectByISBN($book_isbn);
        //var_dump($answer2);die;
        $this->assign('answer',$answer);
        $this->display('FoundBooks/index');
    }
    
    public function doCancel(){
        $book_id = $_GET['book_id'];
        //var_dump($book_id);die;
        session_start();        
        $openid = $_SESSION['openid'];
        $book = new BooksModel();
        $answer = $book->selectById($book_id);
        $book_isbn = $answer[0]['book_isbn'];
        $search = new SearchModel();
        $search->cancelBooks($openid,$book_isbn);
        $this->display('Success/index2');
    }
}

?>