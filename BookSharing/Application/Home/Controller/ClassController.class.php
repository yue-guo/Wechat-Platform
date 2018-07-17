<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;

class ClassController extends Controller {
    public function index(){
        $class_id = $_GET['classid'];
        //var_dump($class_id);die;
        //$_SESSION['classid'] = $class_id;
        $book = new BooksModel();
        $answer = $book->selectByClassid($class_id);
        //var_dump($answer);die;
        $this->assign('answer',$answer);
        $this->display('ClassBooks/index');        
    }
    
    public function doMore(){
        $this->display('ClassMore/index');
    }
}

?>