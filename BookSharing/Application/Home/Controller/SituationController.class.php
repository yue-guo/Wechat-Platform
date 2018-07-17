<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;

class SituationController extends Controller {
    public function index(){
        $this->display('Home/index');
        
    }
}

?>