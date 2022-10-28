<?php

namespace App\Dao;

use App\Models\Comment;
use App\Util\StringUtil;

class CommentDao extends BaseDao
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
        $this->comment = $comment;
    }

    private function bindData($comment, $data) {
        if(!empty($data->book_id)) $comment->book_id = $data->book_id;
        if(!empty($data->comment)) $comment->comment = $data->comment;
        if(!empty($data->user_id)) $comment->user_id = $data->user_id;
        return $comment;
    }

    public function save($data) {
        $comment = new Comment();
        $comment = $this->bindData($comment, $data);
        $comment->save();

        return $comment;
    }

    public function update($data, $id) {
        $comment = Comment::find($id);
        $comment = $this->bindData($comment, $data);
        $comment->save();

        return $comment;
    }

    public function one($id, $book_id, $extra = array()) {
        return $this->search($id, $book_id, 1, $extra, true);
    }

    public function search($id, $book_id, $limit = 0, $extra = array(), $first = false) {
        $query = Comment::with('user');

        if(!empty($id)) { $query->where('id', $id); }

        if(!empty($book_id)) { $query->where('book_id', $book_id); }

        if(!empty($extra)) {
            if(!empty($extra['user_id'])) { $query->where('user_id', '=', $extra['user_id']); }
        }

        $query->orderBy('id', 'DESC');
        if(!empty($limit) && $limit > 0) { $query->limit($limit); }

        //exit(var_dump($this->getSql($query)));
        if($first) { return $query->first(); }
        else { return $query->get(); }
    }
}
