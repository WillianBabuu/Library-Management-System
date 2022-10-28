<?php

namespace App\Dao;

use App\Models\User;
use App\Util\StringUtil;

class UserDao extends BaseDao
{
    protected $user;

    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->user = $user;
    }

    private function bindData($user, $data) {
        if(!empty($data->name)) $user->name = $data->name;
        if(!empty($data->email)) $user->email = $data->email;
        if(!empty($data->email_verified_at)) $user->email_verified_at = $data->email_verified_at;
        if(!empty($data->password)) $user->password = $data->password;
        if(!empty($data->status)) $user->password = $data->password;
        return $user;
    }

    public function save($data) {
        $user = new User();
        $user = $this->bindData($user, $data);
        $user->save();

        return $user;
    }

    public function update($data, $id) {
        $user = User::find($id);
        $user = $this->bindData($user, $data);
        $user->save();

        return $user;
    }

    public function one($id, $name, $extra = array()) {
        return $this->search($id, $name, 1, $extra, true);
    }

    public function search($id, $name, $limit = 0, $extra = array(), $first = false) {
        $query = new User();

        // $select = [
        //     'gift_cards.*',
        // ];

        if(!empty($id)) { $query->where('id', '=', $id); }

        if(!empty($name)) { $query->where('name', 'LIKE', StringUtil::helpLike($name)); }

        if(!empty($extra)) {
            if(!empty($extra['description'])) { $query->where('description', '=', $extra['description']); }
            if(!empty($extra['company_id'])) { 
                $company_id = $extra['company_id'];
                // dd($company_id);
                $query->whereHas('companies', function($q) use($company_id){
                    $q->where('company_id', $company_id);
                } );
            }
        }

        $query->orderBy('id', 'DESC');
        if(!empty($limit) && $limit > 0) { $query->limit($limit); }

        //exit(var_dump($this->getSql($query)));
        if($first) { return $query->first(); }
        else { return $query->get(); }
    }
}
