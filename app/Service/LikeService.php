<?php

namespace App\Service;

use App\Dao\BaseDao;
use App\Dao\LikeDao;
use App\Models\Like;

class LikeService extends BaseService
{
    protected $likeDao;

    public function __construct(LikeDao $likeDao)
    {
        parent::__construct($likeDao);
        $this->likeDao = $likeDao;
    }

    public function validationRules() {
        return array(
    
        );
    }

    public function save($data) {
        return $this->likeDao->save($data);
    }

    public function update($data, $id) {
        return $this->likeDao->update($data, $id);
    }

    public function one($id, $bookid, $extra = array()) {
        return $this->likeDao->one($id, $bookid, $extra);
    }

    public function search($id, $bookid, $limit = 0, $extra = array()) {
        return $this->likeDao->search($id, $bookid, $limit, $extra);
    }
}
