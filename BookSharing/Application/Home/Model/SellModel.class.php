<?php

namespace Home\Model;
use Think\Model;

class SellModel extends Model{
	public $user_id;
	public $book_isbn;
    public $sell_count;



	public function __construct($user_id,$book_isbn,$sell_count){
		$this->user_id = $user_id;
		$this->book_isbn = $book_isbn;
        $this->sell_count = $sell_count;
	}

	public function getUserId(){
		return $this->user_id;
	}
	public function getBookISBN(){
		return $this->book_isbn;
	}
    public function getSellCount(){
        return $this->sell_count;
    }

	public function insertSell($user_id,$book_isbn,$sell_count){
		$sell = M('sell');
		$data['user_id'] = $user_id;
		$data['book_isbn'] = $book_isbn;
        $data['sell_count'] = $sell_count;
		$sell->add($data);
	}
    
    public function sellPlus($user_id, $book_isbn, $count){
        $sell = M('sell');
        $condition['book_isbn'] = $book_isbn;
        $condition['user_id'] = $user_id;
        $sell->where($condition)->setInc('sell_count',$count);
    }
    
    public function sellMinus($user_id,$book_isbn,$count){
        $sell = M('sell');
        $condition['user_id'] = $user_id;
        $condition['book_isbn'] = $book_isbn;
        $sell->where($condition)->setDec('sell_count',$count);
    }
    
    public function sellMinusone($user_id,$book_isbn){
        $sell = M('sell');
        $condition['user_id'] = $user_id;
        $condition['book_isbn'] = $book_isbn;
        $sell->where($condition)->setDec('sell_count');
    }
    
    public static function findAll(){
        $sell = M('sell');
        $answer = $sell->select();
        return $answer;
    } 
    
    public static function findSell($user_id,$book_isbn){
        $sell = M('sell');
        $condition['user_id'] = $user_id;
        $condition['book_isbn'] = $book_isbn;
        $answer = $sell->where($condition)->select();
        return $answer;       
    }
    
    public function deleteSell($user_id,$book_isbn){
        $sell = M('sell');
        $condition['user_id'] = $user_id;
        $condition['book_isbn'] = $book_isbn;
        $sell->where($condition)->delete();
    }
    
}
?>