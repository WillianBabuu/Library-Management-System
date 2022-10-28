<?php

namespace App\Service;

use App\Dao\BaseDao;
use App\Dao\BookDao;
use App\Models\Book;

class BookService extends BaseService
{
    protected $BookDao;

    public function __construct(BookDao $BookDao)
    {
        parent::__construct($BookDao);
        $this->BookDao = $BookDao;
    }

    public function validationRules() {
        return array(
            'name' => 'required|string',
        );
    }

    public function save($data) {
        return $this->BookDao->save($data);
    }

    public function update($data, $id) {
        return $this->BookDao->update($data, $id);
    }

    public function one($id, $name, $extra = array()) {
        return $this->BookDao->one($id, $name, $extra);
    }

    public function search($id, $name, $limit = 0, $extra = array()) {
        return $this->BookDao->search($id, $name, $limit, $extra);
    }
}
