<?php

namespace App\Service;

use App\Dao\BaseDao;
use App\Dao\UserDao;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

class UserService extends BaseService
{
    protected $userDao;

    public function __construct(UserDao $userDao)
    {
        parent::__construct($userDao);
        $this->userDao = $userDao;
    }

    public function validationRules() {
        return array(
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
            'store_id' => 'required'
        );
    }

    public function save($data) {
        return $this->userDao->save($data);
    }

    public function update($data, $id) {
        return $this->userDao->update($data, $id);
    }

    public function one($id, $name, $extra = array()) {
        return $this->userDao->one($id, $name, $extra);
    }

    public function search($id, $name, $limit = 0, $extra = array()) {
        return $this->userDao->search($id, $name, $limit, $extra);
    }
}
