<?php 
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;

class HomeController extends Controller{
	public function index(){
		$book = new BooksModel();
        $answer = $book->findAll();
        $this->assign('answer',$answer);
        $this->display('index');
	}
}
?>