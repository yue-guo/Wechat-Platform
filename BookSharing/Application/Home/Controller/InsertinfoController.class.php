<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;
use Home\Model\SearchModel;

class InsertInfoController extends Controller {
    public function index(){
        //$this->display('ShowResult1/index');
    	
    }
    
    public function add($mail,$title,$content){    
        if(SendMail($mail,$title,$content)){
            $result = '1';
        }
            //$this->success('发送成功！');
            //$this->display('Success/index');
        else
            $result = '0';
            //$this->display('Success/index');
            //$this->error('发送失败');
    }
    
    public function doInsertinfo(){
        //$datetime = $_POST['datetime'];
        //var_dump($datetime);die;
        $openid = $_POST['openid'];
        $book_isbn = $_POST['isbn'];
        $count = $_POST['count'];
        $price = $_POST['price'];
        $book = new BooksModel();
        $sell = new SellModel();
        $user = new UserModel();
        $search = new SearchModel();
        $answer = $book->findBooks($book_isbn,$openid);
        $answer1 = $user->selectByOpenid($openid);
        if(!empty($answer)){
            $book_name = $_POST['bookname'];
            $class_id = $_POST['class'];
            $book_url = $_POST['bookurl'];
            $book_author = $_POST['bookauthor'];
            $book_translator = $_POST['booktranslator'];
            $book_print = $_POST['bookprint'];
            $book_isbn = $_POST['isbn'];
            $book_info = $_POST['bookinfo'];
            $book_count = $count;
            $book_price = $_POST['price'];
            $book_seller = $openid;
            $book->insertBookInfo($book_name,$class_id,$book_url,$book_author,$book_translator,$book_print,$book_isbn,$book_info,$book_count,$book_price,$book_seller);
            $user_id = $answer1[0]['user_id'];
            $answer2 = $sell->sellPlus($user_id, $book_isbn,$count);
            $answers = $search->findByIsbn($book_isbn);
            $answerc = $search->findCount($book_isbn);
            if(!empty($answers)){
                //将condition设为1（已寻得）
                $search->updateCondition($book_isbn);
                //发邮件
                for($i=0; $i<=$answerc; $i++){
                    $openidr = $answers[$i]['openid'];
                    $answerr = $user->selectByOpenid($openidr);
                	$mail = $answerr[0]['user_mail'];
                	$title = '寻书提醒';
                	$content = '您所查找的ISBN号为'.$book_isbn.'的书已经存在，请及时到校园易书公众号查看';
                	self::add($mail,$title,$content);
                }
            }  
            $this->display('Success/index');            
        }
        else{
            $book_name = $_POST['bookname'];
            $class_id = $_POST['class']; 
            $book_url = $_POST['bookurl'];
            $book_author = $_POST['bookauthor'];
            $book_translator = $_POST['booktranslator'];
            $book_print = $_POST['bookprint'];
            $book_isbn = $_POST['isbn'];
            $book_info = $_POST['bookinfo'];
            $book_count = $count;
            $book_price = $_POST['price'];
            $book_seller = $openid;
            $book->insertBookInfo($book_name,$class_id,$book_url,$book_author,$book_translator,$book_print,$book_isbn,$book_info,$book_count,$book_price,$book_seller);
            $user_id = $answer1[0]['user_id'];
            //var_dump($user_id);die;
            $sell->insertSell($user_id,$book_isbn,$count);
            $answer2 = $sell->sellPlus($user_id, $book_isbn,$count);
            $answers = $search->findByIsbn($book_isbn);
            $answerc = $search->findCount($book_isbn);
            if(!empty($answers)){
                $search->updateCondition($book_isbn);
                for($i=0; $i<=$answerc; $i++){
                    $openidr = $answers[$i]['openid'];
                    $answerr = $user->selectByOpenid($openidr);
                	$mail = $answerr[0]['user_mail'];
                	$title = '寻书提醒';
                	$content = '您所查找的ISBN号为'.$book_isbn.'的书已经存在，请及时查看';
                	self::add($mail,$title,$content);
                }
            }      
            //$book_id = $answer[0]['book_id'];
            //$user_id = $answer1[0]['user_id'];
            //$sell->insertSell($user_id,$book_id,$count,$price);
            $this->display('Success/index');
        }

    }
}