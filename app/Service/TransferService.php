<?php

namespace App\Service;

use App\Dao\BaseDao;
use App\Dao\TransferDao;
use App\Models\Transfer;

class TransferService extends BaseService
{
    protected $TransferDao;

    public function __construct(TransferDao $TransferDao)
    {
        parent::__construct($TransferDao);
        $this->TransferDao = $TransferDao;
    }

    public function validationRules() {
        return array(
        );
    }

    public function save($data) {
        return $this->TransferDao->save($data);
    }

    public function update($data, $id) {
        return $this->TransferDao->update($data, $id);
    }

    public function one($id, $name, $extra = array()) {
        return $this->TransferDao->one($id, $name, $extra);
    }

    public function search($id, $status, $limit = 0, $extra = array()) {
        return $this->TransferDao->search($id, $status, $limit, $extra);
    }
}
