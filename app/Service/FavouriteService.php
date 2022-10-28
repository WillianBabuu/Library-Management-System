<?php

namespace App\Service;

use App\Dao\BaseDao;
use App\Dao\FavouriteDao;
use App\Models\Favourite;

class FavouriteService extends BaseService
{
    protected $favouriteDao;

    public function __construct(FavouriteDao $favouriteDao)
    {
        parent::__construct($favouriteDao);
        $this->favouriteDao = $favouriteDao;
    }

    public function validationRules() {
        return array(
    
        );
    }

    public function save($data) {
        return $this->favouriteDao->save($data);
    }

    public function update($data, $id) {
        return $this->favouriteDao->update($data, $id);
    }

    public function one($id, $bookid, $extra = array()) {
        return $this->favouriteDao->one($id, $bookid, $extra);
    }

    public function search($id, $bookid, $limit = 0, $extra = array()) {
        return $this->favouriteDao->search($id, $bookid, $limit, $extra);
    }
}
