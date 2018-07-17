<?php 
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;

class UsersellbookController extends Controller{
	public function index(){
        $openid = $_GET['openid'];
        $_SESSION['openid'] = $openid;
        $book = new BooksModel();
        $answer = $book->selectByOpenid($openid);
        $this->assign('answer',$answer);
        $this->display('index');	
	}
    
    public function showBook(){
        //var_dump($_GET['id']);die;
        $book_id = $_GET['id'];
        //var_dump($book_id);die;
        $book = new BooksModel();
        $answer = $book->selectById($book_id);
        $openid = $answer[0]['openid'];
        $user = new UserModel();
        $answer1 = $user->selectByOpenid($openid);
        $array['book_id'] = $answer[0]['book_id'];
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
        $this->display('Usershowsellbook/index');
    }
    
    public function deleteBooks(){
        session_start();        
        $openid = $_SESSION['openid'];
        $book_id = $_GET['book_id'];
        //var_dump($book_id);die;
        //获取用户user_id
        $user = new UserModel();
        $answer = $user->selectByOpenid($openid);
        $user_id = $answer[0]['user_id'];
        //获取书籍isbn,数目
        $book = new BooksModel();      
        $answer1 = $book->selectById($book_id);
        $book_isbn = $answer1[0]['book_isbn'];
        $count = $answer1[0]['book_count'];
        //var_dump($count);die;
        //删除书籍
        $book->deleteById($book_id);
        //sell表数量减1
        $sell = new SellModel();
        $sell->sellMinus($user_id,$book_isbn,$count);
        $answerc = $sell->findSell($user_id,$book_isbn);
        $sell_count = $answer[0]['sell_count'];
        if($sell_count == 0){
            $sell->deleteSell($user_id,$book_isbn);
        }
        $this->display("Success/index");        
    }
    
    public function minusBook(){
        session_start();        
        $openid = $_SESSION['openid'];
        $book_id = $_GET['book_id'];
        //获取用户user_id
        $user = new UserModel();
        $answer = $user->selectByOpenid($openid);
        $user_id = $answer[0]['user_id'];
        //获取书籍isbn
        $book = new BooksModel();      
        $answer1 = $book->selectById($book_id);
        $book_isbn = $answer1[0]['book_isbn'];
        //书籍减1,sell减1
        $book->minusBook($book_id);
        $sell = new SellModel();
        $sell->sellMinusone($user_id,$book_isbn);
        $answerc = $sell->findSell($user_id,$book_isbn);
        $sell_count = $answer[0]['sell_count'];
        if($sell_count == 0){
            $sell->deleteSell($user_id,$book_isbn);
        }
        $this->display("Success/index");
               
    }
    
    public function dateTime(){
        session_start();        
        $openid = $_SESSION['openid'];
        $starttime = $_POST['starttime'];
        $endtime = $_POST['endtime'];
        $starttime1 = $starttime.' '.'00:00:00';
        $endtime1 = $endtime.' '.'23:59:59';
        //var_dump($starttime1);
        //var_dump($endtime1);die;
        $book = new BooksModel();
        $answer = $book->selectDateTime($starttime1,$endtime1,$openid);
        //var_dump($answer);die; 
        $this->assign('answer',$answer);
        $this->display('Usersellbook/index');
    }
}
?>