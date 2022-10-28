<?php

namespace App\Dao;

use App\Models\Like;
use App\Util\StringUtil;

class LikeDao extends BaseDao
{
    protected $like;

    public function __construct(Like $like)
    {
        parent::__construct($like);
        $this->like = $like;
    }

    private function bindData($like, $data) {
        if(!empty($data->book_id)) $like->book_id = $data->book_id;
        if(!empty($data->user_id)) $like->user_id = $data->user_id;
        return $like;
    }

    public function save($data) {
        $like = new Like();
        $like = $this->bindData($like, $data);
        $like->save();

        return $like;
    }

    public function update($data, $id) {
        $like = Like::find($id);
        $like = $this->bindData($like, $data);
        $like->save();

        return $like;
    }

    public function one($id, $book_id, $extra = array()) {
        return $this->search($id, $book_id, 1, $extra, true);
    }

    public function search($id, $book_id, $limit = 0, $extra = array(), $first = false) {
        $query = Like::query();

        $select = [
            'categories.*',
        ];

        if(!empty($book_id)) { $query->where('categories.book_id', '=', $book_id); }

        //exit(var_dump(!empty($extra['parents_only'])));
        if(!empty($extra)) {
            if(!empty($extra['user_id'])) { $query->where('user_id', '=', $extra['user_id']); }
        }

        $query->orderBy('id', 'DESC');
        if(!empty($limit) && $limit > 0) { $query->limit($limit); }

        //exit(var_dump($this->getSql($query)));
        if($first) { return $query->first($select); }
        else { return $query->get($select); }
    }
}
