<?php

namespace App\Dao;

use App\Models\Book;
use App\Util\StringUtil;

class BookDao extends BaseDao
{
    protected $book;

    public function __construct(Book $book)
    {
        parent::__construct($book);
        $this->book = $book;
    }

    private function bindData($book, $data) {
        if(!empty($data->name)) $book->name = $data->name;
        if(!empty($data->author)) $book->author = $data->author;
        if(!empty($data->year_published)) $book->year_published = $data->year_published;
        return $book;
    }

    public function save($data) {
        $book = new Book();
        $book = $this->bindData($book, $data);
        $book->save();

        return $book;
    }

    public function update($data, $id) {
        $book = Book::find($id);
        $book = $this->bindData($book, $data);
        $book->save();

        return $book;
    }

    public function one($id, $name, $extra = array()) {
        return $this->search($id, $name, 1, $extra, true);
    }

    public function search($id, $name, $limit = 0, $extra = array(), $first = false) {
        $query = Book::withCount('likes')->with('user_like');

        $select = [
            'books.*',
        ];

        if(!empty($id)) { $query->where('books.id', '=', $id); }

        if(!empty($name)) { $query->where('name', 'LIKE', StringUtil::helpLike($name)); }

        if(!empty($extra)) {
            if(!empty($extra['user_id'])) { 
                $query->with('user_like', function($q) use($extra){
                    $q->where('user_id',$extra['user_id']);
                }); 
                $query->with('favourite', function($q) use($extra){
                    $q->where('user_id',$extra['user_id']);
                }); 
            }
            if (!empty($extra['popular']) ) {
                if ($extra['popular'] == 'true' || $extra['popular'] == true) {
                    $query->orderBy('likes_count', 'DESC');
                }
                
            }
        }

        if(!empty($limit) && $limit > 0) { $query->limit($limit); }

        //exit(var_dump($this->getSql($query)));
        if($first) { return $query->first($select); }
        else { return $query->get($select); }
    }
}
