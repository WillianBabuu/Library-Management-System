<?php

namespace App\Dao;

use App\Models\Favourite;
use App\Models\Book;
use App\Util\StringUtil;

class FavouriteDao extends BaseDao
{
    protected $favourite;

    public function __construct(Favourite $favourite)
    {
        parent::__construct($favourite);
        $this->favourite = $favourite;
    }

    private function bindData($favourite, $data) {
        if(!empty($data->user_id)) $favourite->user_id = $data->user_id;
        if(!empty($data->book_id)) $favourite->book_id = $data->book_id;
        return $favourite;
    }

    public function save($data) {
        $favourite = new Favourite();
        $favourite = $this->bindData($favourite, $data);
        $favourite->save();

        return $favourite;
    }

    public function update($data, $id) {
        $favourite = Favourite::find($id);
        $favourite = $this->bindData($favourite, $data);
        $favourite->save();

        return $favourite;
    }

    public function one($id, $bookId, $extra = array()) {
        return $this->search($id, $bookId, 1, $extra, true);
    }

    public function searchStatus($id, $bookId, $extra = array()) {
        return $this->search($id, $bookId, 1, $extra, true, 1);
    }

    public function search($id, $bookId, $limit = 0, $extra = array(), $first = false) {
        $query = Favourite::query();

        if(!empty($id)) { $query->where('id', '=', $id); }
        if(!empty($bookId)) { $query->where('book_id', '=', $bookId); }

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
