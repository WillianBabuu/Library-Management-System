<?php

namespace App\Service;

use App\Dao\BaseDao;
use App\Dao\CommentDao;
use App\Models\Comment;

class CommentService extends BaseService
{
    protected $commentDao;

    public function __construct(CommentDao $commentDao)
    {
        parent::__construct($commentDao);
        $this->commentDao = $commentDao;
    }

    public function validationRules() {
        return array(
            'comment' => 'required|string',
        );
    }

    public function save($data) {
        return $this->commentDao->save($data);
    }

    public function update($data, $id) {
        return $this->commentDao->update($data, $id);
    }

    public function one($id, $bookid, $extra = array()) {
        return $this->commentDao->one($id, $bookid, $extra);
    }

    public function search($id, $bookid, $limit = 0, $extra = array()) {
        return $this->commentDao->search($id, $bookid, $limit, $extra);
    }
}
