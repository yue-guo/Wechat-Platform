<?php

namespace Home\Model;
use Think\Model;

class SearchModel extends Model{
	public $openid;
	public $book_isbn;
	public $condition;

	public function __construct($openid,$book_isbn,$condition){
		$this->openid = $openid;
		$this->book_isbn = $book_isbn;
		$this->condition = $condition;
	}

	public function getOpenid(){
		return $this->openid;
	}

	public function getBookIsbn(){
		return $this->book_isbn;
	}

	public function getCondition(){
		return $this->condition;
	}

	public function insertAll($openid,$book_isbn,$condition){
		$search = M('search');
		$data['openid'] = $openid;
		$data['book_isbn'] = $book_isbn;
		$data['condition'] = $condition;
		$search->add($data);
	}
    
    public function updateCondition($book_isbn){
        $search = M('search');
        $condition['book_isbn'] = $book_isbn;
        $search->where($condition)->setField('condition','1');
    }
    
    public static function findByIsbn($book_isbn){
        $search = M('search');
        $condition['book_isbn'] = $book_isbn;
        $condition['condition'] = '0';
        $answer = $search->where($condition)->select();
        return $answer;
    }
    
    public static function findCount($book_isbn){
        $search = M('search');
        $condition['book_isbn'] = $book_isbn;
        $condition['condition'] = '0';
        $answer = $search->where($condition)->count();
        return $answer;
    }
    
    public static function findCountByOpenid($openid){
        $search = M('search');
        $condition['openid'] = $openid;
        $condition['condition'] = '1';
        $answer = $search->where($condition)->count();
        return $answer;
    }
    
    public static function foundBooks($openid){
        $search = M('search');
        $condition['openid'] = $openid;
        $condition['condition'] = '1';
        $answer = $search->where($condition)->select();
        return $answer;      
    }
    
    public function cancelBooks($openid,$book_isbn){
        $search = M('search');
        $condition['openid'] = $openid;
        $condition['book_isbn'] = $book_isbn;
        $search->where($condition)->setField('condition','2');
    }
    
    public static function findISBN($openid){
        $search = M('search');
        $condition['openid'] = $openid;
        $answer = $search->where($condition)->getField('book_isbn');;
        return $answer;
    }
}

?>